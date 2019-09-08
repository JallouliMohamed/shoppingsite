<?php

namespace EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;

/**
 * Planning
 *
 * @ORM\Table(name="planning")
 * @ORM\Entity(repositoryClass="EcommerceBundle\Repository\PlanningRepository")
 */
class Planning extends FullCalendarEvent
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
     * @var \DateTime
     *
     * @ORM\Column(name="DateStart", type="datetime")
     */


    private $DateStart;

    /**
     * @ORM\OneToOne(targetEntity="EcommerceBundle\Entity\LineOrder")
     * @ORM\JoinColumn(nullable=true)
     */
    private $lineorder;

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
    public function setLineorder($lineorder)
    {
        $this->lineorder = $lineorder;
    }



//
//     /**
//      * @var \AncaRebeca\FullCalendarBundle\Event\CalendarEvent
//      *
//      * @ORM\Column(name="Event", type="integer")
//      */
//
//
//     private $Event;

    /**
     * @return \AncaRebeca\FullCalendarBundle\Event\CalendarEvent
     */
    public function getEvent()
    {
        return $this->Event;
    }

    /**
     * @param \AncaRebeca\FullCalendarBundle\Event\CalendarEvent $Event
     */
    public function setEvent($Event)
    {
        $this->Event = $Event;
    }
    /**
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\Users", inversedBy="planning")
     * @ORM\JoinColumn(nullable=true)
     */
    private $utilisateur;

    /**
     * @return Planning
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * @param mixed $utilisateur
     */
    public function setUtilisateur(\UsersBundle\Entity\Users $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;
    }



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateEnd", type="datetime" ,nullable=true)
     */
    private $DateEnd;

    /**
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->DateStart;
    }

    /**
     * @param \DateTime $DateStart
     */
    public function setDateStart($DateStart)
    {
        $this->DateStart = $DateStart;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->DateEnd;
    }

    /**
     * @param \DateTime $DateEnd
     */
    public function setDateEnd($DateEnd)
    {
        $this->DateEnd = $DateEnd;
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

    public function toArray()
    {
        // TODO: Implement toArray() method.
    }
    public function __construct($title, \DateTime $start, \DateTime $end)
    {
        parent::__construct($title, $start,$end);
    }

}

