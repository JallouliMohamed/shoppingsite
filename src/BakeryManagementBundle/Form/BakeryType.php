<?php

namespace BakeryManagementBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BakeryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('phoneNumber')
            ->add('fax')
            ->add('email')
            ->add('image',HiddenType::class)
//            ->add('enseigne',EntityType::class,array(
//                'class' => 'BakeryManagementBundle:Enseigne',
//                'choice_label' => 'name'
//            ),HiddenType::class)
            ->add('user',EntityType::class,array(
                'class' => 'UsersBundle:Users',
                'choice_label' => 'email'
            ))
            ->add('Ajouter',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BakeryManagementBundle\Entity\Bakery'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bakerymanagementbundle_bakery';
    }


}
