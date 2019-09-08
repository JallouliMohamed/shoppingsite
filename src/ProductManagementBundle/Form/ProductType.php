<?php

namespace ProductManagementBundle\Form;


use ProductManagementBundle\Entity\Product;
use ProductManagementBundle\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('price', NumberType::class, array(
                'scale' => 3,
            ))
            ->add('reduction')
            ->add('description')
            ->add('SubCategory', EntityType::class, array(
                // looks for choices from this entity
                'class' => SubCategory::class,
                'choice_label' => function ($category) {
                    return $category->getName();
                }
            ))
        ;
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
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProductManagementBundle\Entity\Product',
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
        return 'productmanagementbundle_product';
    }


}
