<?php

namespace Nuscly\FormationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrainingSessionFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('state', 'filter_entity', array('class' => 'Nuscly\FormationBundle\Entity\State'))
            ->add('date', 'filter_date')
            ->add('comment', 'filter_text')
            ->add('numberOfDays', 'filter_text')
           // ->add('trainingEvents', 'filter_entity', array('class' => 'Nuscly\FormationBundle\Entity\TrainingEvent'))
           // ->add('trainingMonitoring', 'filter_entity', array('class' => 'Nuscly\FormationBundle\Entity\TrainingMonitoring'))
        ;

    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'Nuscly\FormationBundle\Entity\TrainingSession',
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
        return 'trainingsession_filter';
    }
}
