<?php

namespace Nuscly\FormationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrainingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('employee')
            ->add('title')
            ->add('domain')
            ->add('organization')
            ->add('typology')
            ->add('nextRetraining')
            ->add('deadline')
            ->add('stateRequests', 'bootstrap_collection', array(
                'type'               => new StateRequestType(),
                'allow_add'          => true,
                'allow_delete'       => true,
                'sub_widget_col'     => 9,
                'button_col'         => 3,
                'prototype_name'     => 'inlinep',
                'by_reference'       => false,
                'options'            => array()
                )
            );

}

/**
* {@inheritdoc}
*/
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nuscly\FormationBundle\Entity\Training',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'training';
    }
}
