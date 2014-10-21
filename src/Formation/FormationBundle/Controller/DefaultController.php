<?php

namespace Formation\FormationBundle\Controller;

use Formation\FormationBundle\Entity\Department;
use Formation\FormationBundle\Entity\Employee;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FormationBundle:Default:index.html.twig');
    }




}
