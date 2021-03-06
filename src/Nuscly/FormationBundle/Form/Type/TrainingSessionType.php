<?php

namespace Nuscly\FormationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrainingSessionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('state')
            ->add('date')
            ->add('comment')
            ->add('numberOfDays', 'number')
            ->add('price', 'money')
            //->add('trainingEvents')
            ->add('trainingMonitoring', new TrainingMonitoringType())
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nuscly\FormationBundle\Entity\TrainingSession',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'trainingsession';
    }
}
