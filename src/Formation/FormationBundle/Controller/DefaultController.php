<?php

namespace Formation\FormationBundle\Controller;

use Formation\FormationBundle\Entity\Employee;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FormationBundle:Default:index.html.twig');
    }

    public function createEmployeeAction()
    {
        $employee = new Employee();
        $employee->setName("Rotorpolis");
        $employee->setSurname("Michel");
        $employee->setArrivalDate(new \DateTime());
        $employee->setArrivalReason("new employee");


    }


}
