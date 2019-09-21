<?php

namespace UsersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Form\Type\RegistrationFormType;

class RegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phone')

           // ->add('description')

        ;
    }


    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }
    public function getName()
    {
        return 'app_user_registration';
    }
    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'users_bundle_registration_type';
    }
}
