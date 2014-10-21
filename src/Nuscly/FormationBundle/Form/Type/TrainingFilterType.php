<?php

namespace Nuscly\FormationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrainingFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('title', 'filter_text')
            ->add('domain', 'filter_text')
            ->add('nextRetraining', 'filter_date')
            ->add('deadline', 'filter_date')
            ->add('typology', 'filter_entity', array('class' => 'Nuscly\FormationBundle\Entity\Typology'))
            ->add('employee', 'filter_entity', array('class' => 'Nuscly\FormationBundle\Entity\Employee'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'Nuscly\FormationBundle\Entity\Training',
            'csrf_protection'   => false,
            'validation_groups' => array('filter'),
            'method'            => 'GET',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'training_filter';
    }
}
