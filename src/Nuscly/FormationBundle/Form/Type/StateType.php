<?php
/**
 * Created by PhpStorm.
 * User: schape
 * Date: 21/10/14
 * Time: 16:51
 */

namespace Nuscly\FormationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nuscly\FormationBundle\Entity\State',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'state';
    }
} 