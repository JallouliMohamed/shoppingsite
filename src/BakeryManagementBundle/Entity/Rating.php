<?php

namespace BakeryManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="BakeryManagementBundle\Repository\RatingRepository")
 */
class Rating
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
     * @var float
     *
     * @ORM\Column(name="note", type="float")
     */
    private $note;


    /**
     * @ORM\ManyToOne(targetEntity="Enseigne")
     *
     *
     */
    private $enseigne;

    /**
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\Users")
     *
     *
     */
    private $user;
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set note
     *
     * @param float $note
     *
     * @return Rating
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return float
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set enseigne
     *
     * @param \BakeryManagementBundle\Entity\Enseigne $enseigne
     *
     * @return Rating
     */
    public function setEnseigne(\BakeryManagementBundle\Entity\Enseigne $enseigne = null)
    {
        $this->enseigne = $enseigne;
    
        return $this;
    }

    /**
     * Get enseigne
     *
     * @return \BakeryManagementBundle\Entity\Enseigne
     */
    public function getEnseigne()
    {
        return $this->enseigne;
    }



    /**
     * Set user
     *
     * @param \UsersBundle\Entity\Users $user
     *
     * @return Rating
     */
    public function setUser(\UsersBundle\Entity\Users $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \UsersBundle\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }
}
