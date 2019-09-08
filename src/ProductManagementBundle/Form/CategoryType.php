<?php

namespace ProductManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        if($options['isEdit'] == true){
            $builder->add('imageFile',VichImageType::class, [
                'required' => false,
            ]);
        }else{
            $builder->add('imageFile',VichImageType::class, [
                'required' => true,
            ]);
        }
        $builder->add('sauvegarder', SubmitType::class);
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProductManagementBundle\Entity\Category',
            'isEdit' => false
        ));

        $resolver->setRequired('isEdit'); // Requires that currentOrg be set by the caller.
        $resolver->setAllowedTypes('isEdit', 'boolean'); // Validates the type(s) of option(s) passed.
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'productmanagementbundle_category';
    }


}
