<?php

namespace Nuscly\FormationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrainingMonitoringType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inscription', 'checkbox', array(
                'required' => false,
            ))
            ->add('confirmation', 'checkbox', array(
                'required' => false,
            ))
            ->add('convocation', 'checkbox', array(
                'required' => false,
            ))
            ->add('certificate', 'checkbox', array(
                'required' => false,
            ));
    }



    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nuscly\FormationBundle\Entity\TrainingMonitoring',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'trainingmonitoring';
    }
}
