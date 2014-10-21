<?php

namespace Nuscly\FormationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Nuscly\FormationBundle\Entity\Employee;
use Nuscly\FormationBundle\Form\Type\EmployeeType;
use Nuscly\FormationBundle\Form\Type\EmployeeFilterType;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Employee controller.
 *
 */
class EmployeeController extends Controller
{
    /**
     * Lists all Employee entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new EmployeeFilterType());
        if (!is_null($response = $this->saveFilter($form, 'employee', 'employee'))) {
            return $response;
        }
        $qb = $em->getRepository('FormationBundle:Employee')->createQueryBuilder('e');
        $paginator = $this->filter($form, $qb, 'employee');
                return $this->render('FormationBundle:Employee:index.html.twig', array(
            'form'      => $form->createView(),
            'paginator' => $paginator,
        ));
    }

    /**
     * Finds and displays a Employee entity.
     *
     */
    public function showAction(Employee $employee)
    {
        $deleteForm = $this->createDeleteForm($employee->getId(), 'employee_delete');

        return $this->render('FormationBundle:Employee:show.html.twig', array(
            'employee' => $employee,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Employee entity.
     *
     */
    public function newAction()
    {
        $employee = new Employee();
        $form = $this->createForm(new EmployeeType(), $employee);

        return $this->render('FormationBundle:Employee:new.html.twig', array(
            'employee' => $employee,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Employee entity.
     *
     */
    public function createAction(Request $request)
    {
        $employee = new Employee();
        $form = $this->createForm(new EmployeeType(), $employee);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($employee);
            $em->flush();

            return $this->redirect($this->generateUrl('employee_show', array('id' => $employee->getId())));
        }

        return $this->render('FormationBundle:Employee:new.html.twig', array(
            'employee' => $employee,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Employee entity.
     *
     */
    public function editAction(Employee $employee)
    {
        $editForm = $this->createForm(new EmployeeType(), $employee, array(
            'action' => $this->generateUrl('employee_update', array('id' => $employee->getid())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($employee->getId(), 'employee_delete');

        return $this->render('FormationBundle:Employee:edit.html.twig', array(
            'employee' => $employee,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Employee entity.
     *
     */
    public function updateAction(Employee $employee, Request $request)
    {
        $editForm = $this->createForm(new EmployeeType(), $employee, array(
            'action' => $this->generateUrl('employee_update', array('id' => $employee->getid())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('employee_edit', array('id' => $employee->getId())));
        }
        $deleteForm = $this->createDeleteForm($employee->getId(), 'employee_delete');

        return $this->render('FormationBundle:Employee:edit.html.twig', array(
            'employee' => $employee,
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
        $this->setOrder('employee', $field, $type);

        return $this->redirect($this->generateUrl('employee'));
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
     * Deletes a Employee entity.
     *
     */
    public function deleteAction(Employee $employee, Request $request)
    {
        $form = $this->createDeleteForm($employee->getId(), 'employee_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($employee);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('employee'));
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
