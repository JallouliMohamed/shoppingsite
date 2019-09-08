<?php

namespace EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;

/**
 * Orders
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="EcommerceBundle\Repository\OrdersRepository")
 */
class Orders
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
     * @ORM\OneToMany(targetEntity="EcommerceBundle\Entity\LineOrder", mappedBy="commande", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $lineorder;



    /** @ORM\OneToOne(targetEntity="JMS\Payment\CoreBundle\Entity\PaymentInstruction") */
    private $paymentInstruction;

    /** @ORM\Column(type="decimal", precision=10, scale=5) */
    private $amount;

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }



    public function getAmount()
    {
        return $this->amount;
    }

    public function getPaymentInstruction()
    {
        return $this->paymentInstruction;
    }

    public function setPaymentInstruction(PaymentInstruction $instruction)
    {
        $this->paymentInstruction = $instruction;
    }

    /**
     * @return \EcommerceBundle\Entity\LineOrder
     */
    public function getLineorder()
    {
        return $this->lineorder;
    }

    /**
     * @param mixed $lineorder
     */
    public function setLineorder(\EcommerceBundle\Entity\LineOrder $lineorder = null)
    {
        $this->lineorder = $lineorder;
    }


    /**
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\Adresses", inversedBy="orders")
     * @ORM\JoinColumn(nullable=true)
     */
    private $adresse;



    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }




    /**
     * @var array
     *
     * @ORM\Column(name="orders", type="array", nullable=true)
     */
    private $order;

    /**
     * @return array
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param array $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string")
     */
    private $reference;

    /**
     * @return int
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param int $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\Users", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=true)
     */

    private $utilisateur;


    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->utilisateur;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->utilisateur = $user;
    }

    /**
     * @return mixed
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param mixed $payment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="PaymentState", type="string")
     */
    private $paymentstate;

    /**
     * @return string
     */
    public function getPaymentstate()
    {
        return $this->paymentstate;
    }

    /**
     * @param string $paymentstate
     */
    public function setPaymentstate($paymentstate)
    {
        $this->paymentstate = $paymentstate;
    }




   /* /**
     * @ORM\ManyToOne(targetEntity="EcommerceBundle\Entity\LineOrder")
     * @ORM\JoinColumn(name="LineOrder_id",referencedColumnName="id")
     */
    //private $lineorder;

    /**
     * @ORM\ManyToOne(targetEntity="EcommerceBundle\Entity\Payment")
     * @ORM\JoinColumn(name="payment_id",referencedColumnName="id", nullable=true)
     */
    private $payment;






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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Orders
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Orders
     */


    public function __construct()
    {

        $this->utilisateur = new ArrayCollection();
        $this->lineorder= new ArrayCollection();
        // $this->addRole("ROLE_USER");
       // $this->amount = $amount;
    }



}
