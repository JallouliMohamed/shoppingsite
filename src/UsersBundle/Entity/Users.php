<?php
// src/AppBundle/Entity/Users.php

namespace UsersBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use FOS\MessageBundle\Model\ParticipantInterface;
/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @Vich\Uploadable
 */
class Users extends BaseUser implements ParticipantInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255,nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255,nullable=true)
     */
    private $ville;

    /**
     * @var int
     *
     * @ORM\Column(name="Birthday", type="date",nullable=true)
     */
    private $birthday;



    /**
     * @var int
     *
     * @ORM\Column(name="PhoneNumber", type="integer",nullable=true)
     */
    private $phoneNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="PointsF", type="integer",nullable=true)
     */
    private $pointsF;

    /**
     * @var int
     *
     * @ORM\Column(name="CIN", type="integer",nullable=true)
     */
    private $cin;


    /**
     * @ORM\OneToMany(targetEntity="EcommerceBundle\Entity\Orders", mappedBy="utilisateur", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $commandes;


    /**
     * @ORM\OneToMany(targetEntity="UsersBundle\Entity\Adresses", mappedBy="utilisateur", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $address;



    /**
     * @ORM\OneToMany(targetEntity="EcommerceBundle\Entity\Planning", mappedBy="utilisateur", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $planning;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $facebook_id;

    /**
     * @return mixed
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * @param mixed $facebook_id
     */
    public function setFacebookId($facebook_id)
    {
        $this->facebook_id = $facebook_id;
    }




    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName", size="imageSize", nullable=true)
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $joinedAt;

    /**
     * @return \DateTime
     */
    public function getJoinedAt()
    {
        return $this->joinedAt;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @param \DateTime $joinedAt
     */
    public function setJoinedAt($joinedAt)
    {
        $this->joinedAt = $joinedAt;
    }

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function setImageFile($image = null)
    {
        $this->imageFile = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    public function getImageName()
    {
        return $this->imageName;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="zone", type="string",nullable=true)
     */
    private $zone;

    /**
     * @return string
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * @param string $zone
     */
    public function setZone($zone)
    {
        $this->zone = $zone;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="profile_picture", type="string", length=250, nullable=true)
     *
     */
    protected $profilePicture;

    /**
     * @return string
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @param string $profilePicture
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    /**
     * @return int
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param int $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return int
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param int $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return int
     */
    public function getPointsF()
    {
        return $this->pointsF;
    }

    /**
     * @param int $pointsF
     */
    public function setPointsF($pointsF)
    {
        $this->pointsF = $pointsF;
    }

    /**
     * @return int
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * @param int $cin
     */
    public function setCin($cin)
    {
        $this->cin = $cin;
    }

    /**
     * @return mixed
     */
    public function getPlanning()
    {
        return $this->planning;
    }

    /**
     * @param mixed $planning
     */
    public function setPlanning($planning)
    {
        $this->planning = $planning;
    }



    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }
    /**
     * Get adresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdresses()
    {
        return $this->address;
    }

    /**
     *  Get adresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param mixed $notifications
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="NotificationsBundle\Entity\Notification", mappedBy="user")
     */
    private $notifications;

    public function __construct()
    {
        parent::__construct();
        $this->joinedAt = new \DateTime();
        $this->notifications = new ArrayCollection();
        $this->adresses = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->planning = new ArrayCollection();
        $this->addRole("ROLE_USER");
    }


}