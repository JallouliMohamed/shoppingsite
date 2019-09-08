<?php

namespace ProductManagementBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use ProductManagementBundle\Entity\Product;
use ProductManagementBundle\Repository\ProductRepository;
use ProductManagementBundle\Repository\StockRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockType extends AbstractType
{

    private $BrandId;
    private $isEdit;
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->BrandId = $options['BrandId'];
        $this->isEdit = $options['isEdit'];

        $builder->add('qte');
        if(!$this->isEdit){
            $builder->add('product', EntityType::class, array(
                // looks for choices from this entity
                'class' => Product::class,
                'query_builder' => function(ProductRepository $repository) {
                    return $repository->getAvailableProducts($this->BrandId);
                },
                'choice_label' => 'name'
            ));
        }
        $builder->add('sauvegarder', SubmitType::class);
    }

    /**
 *
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProductManagementBundle\Entity\Stock',
            'isEdit' => false
        ));


        $resolver->setRequired('BrandId'); // Requires that currentOrg be set by the caller.
        $resolver->setRequired('isEdit'); // Requires that currentOrg be set by the caller.
        $resolver->setAllowedTypes('BrandId', 'integer'); // Validates the type(s) of option(s) passed.
        $resolver->setAllowedTypes('isEdit', 'boolean'); // Validates the type(s) of option(s) passed.
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'productmanagementbundle_stock';
    }


}
