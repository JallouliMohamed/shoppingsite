<?php

namespace ProductManagementBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="stock")
 * @ORM\Entity(repositoryClass="ProductManagementBundle\Repository\StockRepository")
 */
class Stock
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    /*private $id;*/

    /**
     * @var int
     *
     * @ORM\Column(name="qte", type="integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $qte;

    /**
     * @ORM\ManyToOne(targetEntity="ProductManagementBundle\Entity\Product")
     * @ORM\JoinColumn(name="Product_id",referencedColumnName="id", onDelete="CASCADE")
     * @ORM\Id
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="BakeryManagementBundle\Entity\Bakery")
     * @ORM\JoinColumn(name="Bakery_id",referencedColumnName="id", onDelete="CASCADE")
     * @ORM\Id
     */
    private $bakery;

    /**
     * @return mixed
     */
    public function getBakery()
    {
        return $this->bakery;
    }

    /**
     * @param mixed $bakery
     */
    public function setBakery($bakery)
    {
        $this->bakery = $bakery;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set qte
     *
     * @param integer $qte
     *
     * @return Stock
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get qte
     *
     * @return int
     */
    public function getQte()
    {
        return $this->qte;
    }
}

