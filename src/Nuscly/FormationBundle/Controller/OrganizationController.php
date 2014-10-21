<?php

namespace Nuscly\FormationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Nuscly\FormationBundle\Entity\Organization;
use Nuscly\FormationBundle\Form\Type\OrganizationType;
use Nuscly\FormationBundle\Form\Type\OrganizationFilterType;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Organization controller.
 *
 */
class OrganizationController extends Controller
{
    /**
     * Lists all Organization entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new OrganizationFilterType());
        if (!is_null($response = $this->saveFilter($form, 'organization', 'organization'))) {
            return $response;
        }
        $qb = $em->getRepository('FormationBundle:Organization')->createQueryBuilder('o');
        $paginator = $this->filter($form, $qb, 'organization');
                return $this->render('FormationBundle:Organization:index.html.twig', array(
            'form'      => $form->createView(),
            'paginator' => $paginator,
        ));
    }

    /**
     * Finds and displays a Organization entity.
     *
     */
    public function showAction(Organization $organization)
    {
        $deleteForm = $this->createDeleteForm($organization->getId(), 'organization_delete');

        return $this->render('FormationBundle:Organization:show.html.twig', array(
            'organization' => $organization,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Organization entity.
     *
     */
    public function newAction()
    {
        $organization = new Organization();
        $form = $this->createForm(new OrganizationType(), $organization);

        return $this->render('FormationBundle:Organization:new.html.twig', array(
            'organization' => $organization,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Organization entity.
     *
     */
    public function createAction(Request $request)
    {
        $organization = new Organization();
        $form = $this->createForm(new OrganizationType(), $organization);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($organization);
            $em->flush();

            return $this->redirect($this->generateUrl('organization_show', array('id' => $organization->getId())));
        }

        return $this->render('FormationBundle:Organization:new.html.twig', array(
            'organization' => $organization,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Organization entity.
     *
     */
    public function editAction(Organization $organization)
    {
        $editForm = $this->createForm(new OrganizationType(), $organization, array(
            'action' => $this->generateUrl('organization_update', array('id' => $organization->getid())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($organization->getId(), 'organization_delete');

        return $this->render('FormationBundle:Organization:edit.html.twig', array(
            'organization' => $organization,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Organization entity.
     *
     */
    public function updateAction(Organization $organization, Request $request)
    {
        $editForm = $this->createForm(new OrganizationType(), $organization, array(
            'action' => $this->generateUrl('organization_update', array('id' => $organization->getid())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('organization_edit', array('id' => $organization->getId())));
        }
        $deleteForm = $this->createDeleteForm($organization->getId(), 'organization_delete');

        return $this->render('FormationBundle:Organization:edit.html.twig', array(
            'organization' => $organization,
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
        $this->setOrder('organization', $field, $type);

        return $this->redirect($this->generateUrl('organization'));
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
     * Deletes a Organization entity.
     *
     */
    public function deleteAction(Organization $organization, Request $request)
    {
        $form = $this->createDeleteForm($organization->getId(), 'organization_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($organization);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('organization'));
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
