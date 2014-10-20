<?php
/**
 * Created by PhpStorm.
 * User: schape
 * Date: 15/10/14
 * Time: 17:40
 */
// src/Acme/DemoBundle/Menu/Builder.php
namespace Formation\FormationBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Agents', array('route' => 'formation_homepage'));
        $menu->addChild('Formations', array('route' => 'formation_homepage'));
        $menu->addChild('Tableaux de bords', array('route' => 'formation_homepage'));
        /*
        $menu->addChild('About Me', array(
            'route' => 'random',
            'routeParameters' => array('limit' => 42)
        ));*/
        // ... add more children

        return $menu;
    }
}
