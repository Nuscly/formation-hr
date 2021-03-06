<?php

namespace Nuscly\FormationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Nuscly\FormationBundle\Entity\Department;
use Nuscly\FormationBundle\Form\Type\DepartmentType;
use Nuscly\FormationBundle\Form\Type\DepartmentFilterType;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Department controller.
 *
 */
class DepartmentController extends Controller
{
    /**
     * Lists all Department entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new DepartmentFilterType());
        if (!is_null($response = $this->saveFilter($form, 'department', 'department'))) {
            return $response;
        }
        $qb = $em->getRepository('FormationBundle:Department')->createQueryBuilder('d');
        $paginator = $this->filter($form, $qb, 'department');
                return $this->render('FormationBundle:Department:index.html.twig', array(
            'form'      => $form->createView(),
            'paginator' => $paginator,
        ));
    }

    /**
     * Finds and displays a Department entity.
     *
     */
    public function showAction(Department $department)
    {
        $deleteForm = $this->createDeleteForm($department->getId(), 'department_delete');

        return $this->render('FormationBundle:Department:show.html.twig', array(
            'department' => $department,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Department entity.
     *
     */
    public function newAction()
    {
        $department = new Department();
        $form = $this->createForm(new DepartmentType(), $department);

        return $this->render('FormationBundle:Department:new.html.twig', array(
            'department' => $department,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Department entity.
     *
     */
    public function createAction(Request $request)
    {
        $department = new Department();
        $form = $this->createForm(new DepartmentType(), $department);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($department);
            $em->flush();

            return $this->redirect($this->generateUrl('department_show', array('id' => $department->getId())));
        }

        return $this->render('FormationBundle:Department:new.html.twig', array(
            'department' => $department,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Department entity.
     *
     */
    public function editAction(Department $department)
    {
        $editForm = $this->createForm(new DepartmentType(), $department, array(
            'action' => $this->generateUrl('department_update', array('id' => $department->getid())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($department->getId(), 'department_delete');

        return $this->render('FormationBundle:Department:edit.html.twig', array(
            'department' => $department,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Department entity.
     *
     */
    public function updateAction(Department $department, Request $request)
    {
        $editForm = $this->createForm(new DepartmentType(), $department, array(
            'action' => $this->generateUrl('department_update', array('id' => $department->getid())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('department_edit', array('id' => $department->getId())));
        }
        $deleteForm = $this->createDeleteForm($department->getId(), 'department_delete');

        return $this->render('FormationBundle:Department:edit.html.twig', array(
            'department' => $department,
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
        $this->setOrder('department', $field, $type);

        return $this->redirect($this->generateUrl('department'));
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
     * Deletes a Department entity.
     *
     */
    public function deleteAction(Department $department, Request $request)
    {
        $form = $this->createDeleteForm($department->getId(), 'department_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($department);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('department'));
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
