<?php

namespace BakeryManagementBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnseigneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
                ->add('address')
                ->add('phoneNumber')
                ->add('fax')
                ->add('email')
                ->add('website')
                ->add('description')
                ->add('logo',FileType::class, array('label' => 'logo','data_class' => null))
                ->add('codeRC')
//                ->add('user',EntityType::class,array(
//                    'class'=>"UsersBundle:Users",
//                    'choice_label' =>'username', //choice_label:liste déroulanter selon le libelle
//                    'multiple'=>false,))
            ->add('Ajouter',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BakeryManagementBundle\Entity\Enseigne'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bakerymanagementbundle_enseigne';
    }


}
