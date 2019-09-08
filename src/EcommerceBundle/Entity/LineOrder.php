<?php

namespace EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProductManagementBundle\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use EcommerceBundle\Entity\Orders;


/**
 * LineOrder
 *
 * @ORM\Table(name="line_order")
 * @ORM\Entity(repositoryClass="EcommerceBundle\Repository\LineOrderRepository")
 */
class LineOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    /**
     * @var Orders
     * @ORM\ManyToOne(targetEntity="EcommerceBundle\Entity\Orders", inversedBy="lineorder", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $commande;


    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="ProductManagementBundle\Entity\Product", inversedBy="lineorder")
     * @ORM\JoinColumn(nullable=true)
     */
    private $product;



    /**
     * @return \ProductManagementBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct(\ProductManagementBundle\Entity\Product $product = null)
    {
        $this->product = $product;
    }



    /**
     * @return \EcommerceBundle\Entity\Orders
     */
    public function getOrder()
    {
        return $this->commande;
    }

    /**
     * @param mixed $order
     */
    public function setOrder(\EcommerceBundle\Entity\Orders $commande = null)
    {
        $this->commande = $commande;
    }



    /**
     * @var int
     *
     * @ORM\Column(name="qte", type="integer")
     */
    private $qte;




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
     * @return LineOrder
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

    public function __construct()
    {

        $this->product = new ArrayCollection();
        $this->commande= new ArrayCollection();

    }
}


