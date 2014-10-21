<?php

namespace Nuscly\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EmployeeController extends Controller
{
    public function createEmployeeAction()
    {
        $department = new Department();
        $department->setName("DEJEC");

        $subDepartment = new Department();
        $subDepartment->setName("Creche");
        $subDepartment->setParent($department);

        $employee = new Employee();
        $employee->setName("Rotorpolis");
        $employee->setSurname("Michel");
        $employee->setArrivalDate(new \DateTime());
        $employee->setArrivalReason("new employee");
        $employee->setDepartment($subDepartment);

        $em = $this->getDoctrine()->getManager();
        $em->persist($department);
        $em->persist($subDepartment);
        $em->persist($employee);
        $em->flush();


        return new Response(
            'Created employee id: '.$employee->getId()
            .' and Department id: '.$subDepartment->getId()
        );


    }

    public function listEmployeeAction()
    {

    }

    public function editEmployeeAction()
    {

    }
}
