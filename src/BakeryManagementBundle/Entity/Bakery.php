<?php

namespace BakeryManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bakery
 *
 * @ORM\Table(name="bakery")
 * @ORM\Entity(repositoryClass="BakeryManagementBundle\Repository\BakeryRepository")
 */
class Bakery
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
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Address", type="string", length=255)
     */
    private $address;

    /**
     * @var int
     *
     * @ORM\Column(name="PhoneNumber", type="integer")
     */
    private $phoneNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="Fax", type="integer")
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255)
     */
    private $email;
    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     */
    private $longitude;
    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    private $latitude;

    /**
     * @var array
     *
     * @ORM\Column(name="Image", type="json_array", nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="BakeryManagementBundle\Entity\Enseigne")
     * @ORM\JoinColumn(name="enseigne_id",referencedColumnName="id")
     */
    private $enseigne;

    /**
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\Users")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $user;

  /*  /**
     * @ORM\ManyToOne(targetEntity="ProductManagementBundle\Entity\Stock")
     * @ORM\JoinColumn(name="stock_id",referencedColumnName="id")
     */
   // private $stock;

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }





    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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
     * Set name
     *
     * @param string $name
     *
     * @return Bakery
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Bakery
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phoneNumber
     *
     * @param integer $phoneNumber
     *
     * @return Bakery
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return int
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set fax
     *
     * @param integer $fax
     *
     * @return Bakery
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return int
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Bakery
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set image
     *
     * @param array $image
     *
     * @return Bakery
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return array
     */
    public function getImage()
    {
        return $this->image;
    }

//    /**
//     * @return mixed
//     */
//    public function getEnseigne()
//    {
//        return $this->enseigne;
//    }
//
//    /**
//     * @param mixed $enseigne
//     */
//    public function setEnseigne($enseigne)
//    {
//        $this->enseigne = $enseigne;
//    }



    /**
     * Set enseigne
     *
     * @param \BakeryManagementBundle\Entity\Enseigne $enseigne
     *
     * @return Bakery
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
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Bakery
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Bakery
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
}
