<?php

namespace Nuscly\FormationBundle\Controller;

use Nuscly\FormationBundle\Entity\StateRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Nuscly\FormationBundle\Entity\Training;
use Nuscly\FormationBundle\Form\Type\TrainingType;
use Nuscly\FormationBundle\Form\Type\TrainingFilterType;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\QueryBuilder;
use DateTime;

/**
 * Training controller.
 *
 */
class TrainingController extends Controller
{
    /**
     * Lists all Training entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new TrainingFilterType());
        if (!is_null($response = $this->saveFilter($form, 'training', 'training'))) {
            return $response;
        }
        $qb = $em->getRepository('FormationBundle:Training')->createQueryBuilder('t');
        $paginator = $this->filter($form, $qb, 'training');
                return $this->render('FormationBundle:Training:index.html.twig', array(
            'form'      => $form->createView(),
            'paginator' => $paginator,
        ));
    }

    /**
     * Finds and displays a Training entity.
     *
     */
    public function showAction(Training $training)
    {
        $deleteForm = $this->createDeleteForm($training->getId(), 'training_delete');

        return $this->render('FormationBundle:Training:show.html.twig', array(
            'training' => $training,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Training entity.
     *
     */
    public function newAction()
    {
        $training = new Training();
        $form = $this->createForm(new TrainingType(), $training);

        return $this->render('FormationBundle:Training:new.html.twig', array(
            'training' => $training,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Displays a form to create a new Training entity.
     *
     */
    public function testAction()
    {
        $em = $this->getDoctrine()->getManager();

        $training = new Training();
        $training->setTitle("test training ".date('l'));
        $training->setDomain("domain ".date('l'));
        $training->setNextRetraining(new DateTime());
        $training->setDeadline(new DateTime());

        $em->persist($training);

        $stateRequest = new StateRequest();
        $stateRequest->setTraining($training);
        $stateRequest->setState($em->find('\Nuscly\FormationBundle\Entity\State', 1));
        $stateRequest->setComment("Comment ".date('l'));
        $stateRequest->setDate(new DateTime());
        $training->addStateRequest($stateRequest);

        $stateRequest2 = new StateRequest();
        $stateRequest2->setTraining($training);
        $stateRequest2->setState($em->find('\Nuscly\FormationBundle\Entity\State', 2));
        $stateRequest2->setComment("Comment ".date('l'));
        $stateRequest2->setDate(new DateTime());
        $training->addStateRequest($stateRequest2);

        //$em->persist($training);

        foreach ($training->getStateRequests() as $stateRequestIte) {
            $em->persist($stateRequestIte);
            //$em->flush();
        }

        //$em->persist($training);
        $em->flush();



        $editForm = $this->createForm(new TrainingType(), $training, array(
            'action' => $this->generateUrl('training_update', array('id' => $training->getid())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($training->getId(), 'training_delete');

        return $this->render('FormationBundle:Training:edit.html.twig', array(
            'training' => $training,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a new Training entity.
     *
     */
    public function createAction(Request $request)
    {
        $training = new Training();
        $form = $this->createForm(new TrainingType(), $training);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
//
//            foreach ($training->getStateRequests() as $stateRequest) {
//                $em->persist($stateRequest);
//                //$em->flush();
//            }

            $em->persist($training);
            $em->flush();

            return $this->redirect($this->generateUrl('training_show', array('id' => $training->getId())));
        }

        return $this->render('FormationBundle:Training:new.html.twig', array(
            'training' => $training,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Training entity.
     *
     * @param Training $training
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Training $training)
    {
        $editForm = $this->createForm(new TrainingType(), $training, array(
            'action' => $this->generateUrl('training_update', array('id' => $training->getid())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($training->getId(), 'training_delete');

        return $this->render('FormationBundle:Training:edit.html.twig', array(
            'training' => $training,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Training entity.
     *
     * @param Training $training
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Training $training, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(new TrainingType(), $training, array(
            'action' => $this->generateUrl('training_update', array('id' => $training->getid())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {

//            foreach ($training->getStateRequests() as $stateRequest) {
//                $em->persist($stateRequest);
//                //$em->flush();
//            }
//
//            $em->persist($training);
            $em->flush();

            return $this->redirect($this->generateUrl('training_edit', array('id' => $training->getId())));
        }
        $deleteForm = $this->createDeleteForm($training->getId(), 'training_delete');

        return $this->render('FormationBundle:Training:edit.html.twig', array(
            'training' => $training,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Save order.
     *
     *
     * @param $field
     * @param $type
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sortAction($field, $type)
    {
        $this->setOrder('training', $field, $type);

        return $this->redirect($this->generateUrl('training'));
    }

    /**
     * @param string $name  session name
     * @param string $field field name
     * @param string $type  sort type ("ASC"/"DESC")
     */
    protected function setOrder($name, $field, $type = 'ASC')
    {
        $this->getRequest()->getSession()->set('sort.' . $name, array('field' => $field, 'type' => $type));
    }

    /**
     * @param  string $name
     * @return array
     */
    protected function getOrder($name)
    {
        $session = $this->getRequest()->getSession();

        return $session->has('sort.' . $name) ? $session->get('sort.' . $name) : null;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $name
     */
    protected function addQueryBuilderSort(QueryBuilder $qb, $name)
    {
        $alias = current($qb->getDQLPart('from'))->getAlias();
        if (is_array($order = $this->getOrder($name))) {
            $qb->orderBy($alias . '.' . $order['field'], $order['type']);
        }
    }

    /**
     * Save filters
     *
     * @param  FormInterface $form
     * @param  string        $name   route/entity name
     * @param  string        $route  route name, if different from entity name
     * @param  array         $params possible route parameters
     * @return Response
     */
    protected function saveFilter(FormInterface $form, $name, $route = null, array $params = null)
    {
        $request = $this->getRequest();
        $url = $this->generateUrl($route ?: $name, is_null($params) ? array() : $params);
        if ($request->query->has('submit-filter') && $form->handleRequest($request)->isValid()) {
            $request->getSession()->set('filter.' . $name, $request->query->get($form->getName()));

            return $this->redirect($url);
        } elseif ($request->query->has('reset-filter')) {
            $request->getSession()->set('filter.' . $name, null);

            return $this->redirect($url);
        }
    }

    /**
     * Filter form
     *
     * @param  FormInterface                                       $form
     * @param  QueryBuilder                                        $qb
     * @param  string                                              $name
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    protected function filter(FormInterface $form, QueryBuilder $qb, $name)
    {
        if (!is_null($values = $this->getFilter($name))) {
            if ($form->submit($values)->isValid()) {
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $qb);
            }
        }

        // possible sorting
        $this->addQueryBuilderSort($qb, $name);
        return $this->get('knp_paginator')->paginate($qb, $this->getRequest()->query->get('page', 1), 20);
    }

    /**
     * Get filters from session
     *
     * @param  string $name
     * @return array
     */
    protected function getFilter($name)
    {
        return $this->getRequest()->getSession()->get('filter.' . $name);
    }

    /**
     * Deletes a Training entity.
     *
     */
    public function deleteAction(Training $training, Request $request)
    {
        $form = $this->createDeleteForm($training->getId(), 'training_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($training);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('training'));
    }

    /**
     * Create Delete form
     *
     * @param integer                       $id
     * @param string                        $route
     * @return \Symfony\Component\Form\Form
     */
    protected function createDeleteForm($id, $route)
    {
        return $this->createFormBuilder(null, array('attr' => array('id' => 'delete')))
            ->setAction($this->generateUrl($route, array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
