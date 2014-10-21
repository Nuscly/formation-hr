<?php

namespace Nuscly\FormationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Nuscly\FormationBundle\Entity\TrainingSession;
use Nuscly\FormationBundle\Form\Type\TrainingSessionType;
use Nuscly\FormationBundle\Form\Type\TrainingSessionFilterType;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * TrainingSession controller.
 *
 */
class TrainingSessionController extends Controller
{
    /**
     * Lists all TrainingSession entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new TrainingSessionFilterType());
        if (!is_null($response = $this->saveFilter($form, 'trainingsession', 'training-session'))) {
            return $response;
        }
        $qb = $em->getRepository('FormationBundle:TrainingSession')->createQueryBuilder('t');
        $paginator = $this->filter($form, $qb, 'trainingsession');
                return $this->render('FormationBundle:TrainingSession:index.html.twig', array(
            'form'      => $form->createView(),
            'paginator' => $paginator,
        ));
    }

    /**
     * Finds and displays a TrainingSession entity.
     *
     */
    public function showAction(TrainingSession $trainingsession)
    {
        $deleteForm = $this->createDeleteForm($trainingsession->getId(), 'training-session_delete');

        return $this->render('FormationBundle:TrainingSession:show.html.twig', array(
            'trainingsession' => $trainingsession,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new TrainingSession entity.
     *
     */
    public function newAction()
    {
        $trainingsession = new TrainingSession();
        $form = $this->createForm(new TrainingSessionType(), $trainingsession);

        return $this->render('FormationBundle:TrainingSession:new.html.twig', array(
            'trainingsession' => $trainingsession,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new TrainingSession entity.
     *
     */
    public function createAction(Request $request)
    {
        $trainingsession = new TrainingSession();
        $form = $this->createForm(new TrainingSessionType(), $trainingsession);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trainingsession);
            $em->flush();

            return $this->redirect($this->generateUrl('training-session_show', array('id' => $trainingsession->getId())));
        }

        return $this->render('FormationBundle:TrainingSession:new.html.twig', array(
            'trainingsession' => $trainingsession,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TrainingSession entity.
     *
     */
    public function editAction(TrainingSession $trainingsession)
    {
        $editForm = $this->createForm(new TrainingSessionType(), $trainingsession, array(
            'action' => $this->generateUrl('training-session_update', array('id' => $trainingsession->getid())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($trainingsession->getId(), 'training-session_delete');

        return $this->render('FormationBundle:TrainingSession:edit.html.twig', array(
            'trainingsession' => $trainingsession,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing TrainingSession entity.
     *
     */
    public function updateAction(TrainingSession $trainingsession, Request $request)
    {
        $editForm = $this->createForm(new TrainingSessionType(), $trainingsession, array(
            'action' => $this->generateUrl('training-session_update', array('id' => $trainingsession->getid())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('training-session_edit', array('id' => $trainingsession->getId())));
        }
        $deleteForm = $this->createDeleteForm($trainingsession->getId(), 'training-session_delete');

        return $this->render('FormationBundle:TrainingSession:edit.html.twig', array(
            'trainingsession' => $trainingsession,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Save order.
     *
     */
    public function sortAction($field, $type)
    {
        $this->setOrder('trainingsession', $field, $type);

        return $this->redirect($this->generateUrl('training-session'));
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
     * Deletes a TrainingSession entity.
     *
     */
    public function deleteAction(TrainingSession $trainingsession, Request $request)
    {
        $form = $this->createDeleteForm($trainingsession->getId(), 'training-session_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($trainingsession);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('training-session'));
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
