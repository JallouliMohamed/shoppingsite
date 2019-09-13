<?php
/**
 * Created by PhpStorm.
 * User: Emir
 * Date: 11/09/2019
 * Time: 01:23
 */

namespace ProductManagementBundle\Form;
use ProductManagementBundle\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarqueType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('subcategory', EntityType::class, array(
                // looks for choices from this entity
                'class' => SubCategory::class,
                'choice_label' => function ($subcategory) {
                    return $subcategory->getName();
                }
            ));

        $builder->add('sauvegarder', SubmitType::class);
        ;
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProductManagementBundle\Entity\Marque',
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
        return 'productmanagementbundle_marque';
    }
}