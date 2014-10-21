<?php
/**
 * Created by PhpStorm.
 * User: schape
 * Date: 15/10/14
 * Time: 17:40
 */
// src/Acme/DemoBundle/Menu/Builder.php
namespace Nuscly\FormationBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setUri('/');

        $menu->addChild('Dashboard', array('route' => 'formation_homepage'));
        $menu->addChild('Departments', array('route' => 'department'));
        $menu->addChild('Employees', array('route' => 'employee'));
        $menu->addChild('Trainings', array('route' => 'training'));
        $menu->addChild('Trainings plan', array('route' => 'training-plan'));
        $menu->addChild('Trainings session', array('route' => 'training-session'));
        $menu->addChild('Organization', array('route' => 'organization'));
        /*
        $menu->addChild('About Me', array(
            'route' => 'random',
            'routeParameters' => array('limit' => 42)
        ));*/
        // ... add more children

        return $menu;
    }
}
