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


class StatePlanType extends AbstractType
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
            ->add('trainingPlan')
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nuscly\FormationBundle\Entity\StatePlan',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'stateplan';
    }
} 