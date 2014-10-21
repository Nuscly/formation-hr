<?php

namespace Nuscly\FormationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Nuscly\FormationBundle\Entity\TrainingPlan;
use Nuscly\FormationBundle\Form\Type\TrainingPlanType;
use Nuscly\FormationBundle\Form\Type\TrainingPlanFilterType;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * TrainingPlan controller.
 *
 */
class TrainingPlanController extends Controller
{
    /**
     * Lists all TrainingPlan entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new TrainingPlanFilterType());
        if (!is_null($response = $this->saveFilter($form, 'trainingplan', 'training-plan'))) {
            return $response;
        }
        $qb = $em->getRepository('FormationBundle:TrainingPlan')->createQueryBuilder('t');
        $paginator = $this->filter($form, $qb, 'trainingplan');
                return $this->render('FormationBundle:TrainingPlan:index.html.twig', array(
            'form'      => $form->createView(),
            'paginator' => $paginator,
        ));
    }

    /**
     * Finds and displays a TrainingPlan entity.
     *
     */
    public function showAction(TrainingPlan $trainingplan)
    {
        $deleteForm = $this->createDeleteForm($trainingplan->getId(), 'training-plan_delete');

        return $this->render('FormationBundle:TrainingPlan:show.html.twig', array(
            'trainingplan' => $trainingplan,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new TrainingPlan entity.
     *
     */
    public function newAction()
    {
        $trainingplan = new TrainingPlan();
        $form = $this->createForm(new TrainingPlanType(), $trainingplan);

        return $this->render('FormationBundle:TrainingPlan:new.html.twig', array(
            'trainingplan' => $trainingplan,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new TrainingPlan entity.
     *
     */
    public function createAction(Request $request)
    {
        $trainingplan = new TrainingPlan();
        $form = $this->createForm(new TrainingPlanType(), $trainingplan);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trainingplan);
            $em->flush();

            return $this->redirect($this->generateUrl('training-plan_show', array('id' => $trainingplan->getId())));
        }

        return $this->render('FormationBundle:TrainingPlan:new.html.twig', array(
            'trainingplan' => $trainingplan,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TrainingPlan entity.
     *
     */
    public function editAction(TrainingPlan $trainingplan)
    {
        $editForm = $this->createForm(new TrainingPlanType(), $trainingplan, array(
            'action' => $this->generateUrl('training-plan_update', array('id' => $trainingplan->getid())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($trainingplan->getId(), 'training-plan_delete');

        return $this->render('FormationBundle:TrainingPlan:edit.html.twig', array(
            'trainingplan' => $trainingplan,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing TrainingPlan entity.
     *
     */
    public function updateAction(TrainingPlan $trainingplan, Request $request)
    {
        $editForm = $this->createForm(new TrainingPlanType(), $trainingplan, array(
            'action' => $this->generateUrl('training-plan_update', array('id' => $trainingplan->getid())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('training-plan_edit', array('id' => $trainingplan->getId())));
        }
        $deleteForm = $this->createDeleteForm($trainingplan->getId(), 'training-plan_delete');

        return $this->render('FormationBundle:TrainingPlan:edit.html.twig', array(
            'trainingplan' => $trainingplan,
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
        $this->setOrder('trainingplan', $field, $type);

        return $this->redirect($this->generateUrl('training-plan'));
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
     * Deletes a TrainingPlan entity.
     *
     */
    public function deleteAction(TrainingPlan $trainingplan, Request $request)
    {
        $form = $this->createDeleteForm($trainingplan->getId(), 'training-plan_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($trainingplan);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('training-plan'));
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
