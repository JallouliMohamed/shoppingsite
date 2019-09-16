<?php

namespace ProductManagementBundle\Entity;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="ProductManagementBundle\Repository\ProductRepository")
 * @Vich\Uploadable
 */
 class Product implements JsonSerializable
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
      * @ORM\Column(name="title", type="string", length=255)
      */

     private $title;


     /**
      * @var string
      *
      * @ORM\Column(name="adress", type="string", length=255)
      */
     private $adress;
    /**
     * @var float
     * @Assert\GreaterThanOrEqual(0)
     * @ORM\Column(name="Price", type="float")
     */
    private $price;
     /**
      * @var string
      *
      * @ORM\Column(name="country", type="string", length=255)
      */
     private $country;

     /**
      * @var string
      *
      * @ORM\Column(name="horsepower", type="integer", length=255,nullable=true)
      */
     private $horsepower;
     /**
      * @var string
      *
      * @ORM\Column(name="color", type="string", length=255,nullable=true)
      */
     private $color;
     /**
      * @var string
      *
      * @ORM\Column(name="ram", type="string", length=255,nullable=true)
      */
     private $ram;
     /**
      * @var string
      *
      * @ORM\Column(name="camera", type="string", length=255,nullable=true)
      */
     private $camera;
     /**
      * @var string
      *
      * @ORM\Column(name="numberofbeds", type="string", length=255,nullable=true)
      */
     private $numberofbeds;
     /**
      * @var string
      *
      * @ORM\Column(name="numberofbaths", type="string", length=255,nullable=true)
      */
     private $numberofbaths;
     /**
      * @var string
      *
      * @ORM\Column(name="space", type="string", length=255,nullable=true)
      */
     private $space;

     /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255)
     */
    private $description;

    /**
     * @var float
     * @Assert\GreaterThanOrEqual(0)
     * @ORM\Column(name="Rating", type="float", nullable=true)
     */
    private $rating;

    /**
     * @var float
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\LessThanOrEqual(100)
     * @ORM\Column(name="reduction", type="float", nullable=true)
     */
    private $reduction;

    /**
     * @return float
     */
    public function getReduction()
    {
        return $this->reduction;
    }

    /**
     * @param float $reduction
     */
    public function setReduction($reduction)
    {
        $this->reduction = $reduction;
    }



    /**
     * @ORM\ManyToOne(targetEntity="ProductManagementBundle\Entity\SubCategory")
     * @ORM\JoinColumn(name="SubCategory_id",referencedColumnName="id", onDelete="CASCADE")
     */
    private $subcategory;

     /**
      * @ORM\ManyToOne(targetEntity="ProductManagementBundle\Entity\Marque")
      * @ORM\JoinColumn(name="marque_id",referencedColumnName="id", onDelete="CASCADE")
      */
     private $marque;

     /**
      * @return mixed
      */
     public function getMarque()
     {
         return $this->marque;
     }

     /**
      * @param mixed $marque
      */
     public function setMarque($marque)
     {
         $this->marque = $marque;
     }

    /**
     * @ORM\ManyToOne(targetEntity="BakeryManagementBundle\Entity\Enseigne")
     * @ORM\JoinColumn(name="Enseigne_id",referencedColumnName="id")
     */
    private $enseigne;


    /**
     * @ORM\ManyToOne(targetEntity="BakeryManagementBundle\Entity\Bakery")
     * @ORM\JoinColumn(name="Bakery_id",referencedColumnName="id")
     */
    private $bakery;

    /**
     * Set bakery
     *
     * @param \BakeryManagementBundle\Entity\Bakery $bakery
     *
     * @return Product
     */

    public function setBakery(\BakeryManagementBundle\Entity\Bakery $bakery = null)
    {
        $this->bakery = $bakery;

        return $this;
    }

    /**
     * Get bakery
     *
     * @return \BakeryManagementBundle\Entity\Bakery
     */
    public function getBakery()
    {
        return $this->bakery;
    }


     /**
      * @ORM\OneToMany(targetEntity="EcommerceBundle\Entity\LineOrder", mappedBy="product", cascade={"remove"})
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


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName", size="imageSize")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @var string
     */
    private $imageName;


    /**
     * @var int
     * @Assert\GreaterThanOrEqual(0)
     * @ORM\Column(name="sales", type="integer", nullable=true)
     */
    private $sales;
     /**
      * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\Users")
      * @ORM\JoinColumn(name="user_id",referencedColumnName="id", onDelete="CASCADE")
      */
     private $user;

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
     * Product constructor.
     */
    public function __construct()
    {
        $this->addedAt = new \DateTime("now");
        $this->rating = 3;
        $this->reduction = 0;
    }

    /**
     * @return int
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * @param int $sales
     */
    public function setSales($sales)
    {
        $this->sales = $sales;
    }



    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="added_at", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $addedAt;

    /**
     * @return \DateTime
     */
    public function getAddedAt()
    {
        return $this->addedAt;
    }

    /**
     * @param \DateTime $addedAt
     */
    public function setAddedAt($addedAt)
    {
        $this->addedAt = $addedAt;
    }

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

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }

    /**
     * @return mixed
     */
    public function getEnseigne()
    {
        return $this->enseigne;
    }

    /**
     * @param mixed $enseigne
     */
    public function setEnseigne($enseigne)
    {
        $this->enseigne = $enseigne;
    }




    /**
     * @return mixed
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * @param mixed $subcategory
     */
    public function setSubcategory($subcategory)
    {
        $this->subcategory = $subcategory;
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
     * @return Product
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
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set rating
     *
     * @param float $rating
     *
     * @return Product
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return float
     */
    public function getRating()
    {
        return $this->rating;
    }

     /**
      * @return string
      */
     public function getTitle()
     {
         return $this->title;
     }

     /**
      * @param string $title
      */
     public function setTitle($title)
     {
         $this->title = $title;
     }

     /**
      * @return string
      */
     public function getAdress()
     {
         return $this->adress;
     }

     /**
      * @param string $adress
      */
     public function setAdress($adress)
     {
         $this->adress = $adress;
     }

     /**
      * @return string
      */
     public function getCountry()
     {
         return $this->country;
     }

     /**
      * @param string $country
      */
     public function setCountry($country)
     {
         $this->country = $country;
     }

     /**
      * @return string
      */
     public function getHorsepower()
     {
         return $this->horsepower;
     }

     /**
      * @param string $horsepower
      */
     public function setHorsepower($horsepower)
     {
         $this->horsepower = $horsepower;
     }

     /**
      * @return string
      */
     public function getColor()
     {
         return $this->color;
     }

     /**
      * @param string $color
      */
     public function setColor($color)
     {
         $this->color = $color;
     }

     /**
      * @return string
      */
     public function getRam()
     {
         return $this->ram;
     }

     /**
      * @param string $ram
      */
     public function setRam($ram)
     {
         $this->ram = $ram;
     }

     /**
      * @return string
      */
     public function getCamera()
     {
         return $this->camera;
     }

     /**
      * @param string $camera
      */
     public function setCamera($camera)
     {
         $this->camera = $camera;
     }

     /**
      * @return string
      */
     public function getNumberofbeds()
     {
         return $this->numberofbeds;
     }

     /**
      * @param string $numberofbeds
      */
     public function setNumberofbeds($numberofbeds)
     {
         $this->numberofbeds = $numberofbeds;
     }

     /**
      * @return string
      */
     public function getNumberofbaths()
     {
         return $this->numberofbaths;
     }

     /**
      * @param string $numberofbaths
      */
     public function setNumberofbaths($numberofbaths)
     {
         $this->numberofbaths = $numberofbaths;
     }

     /**
      * @return string
      */
     public function getSpace()
     {
         return $this->space;
     }

     /**
      * @param string $space
      */
     public function setSpace($space)
     {
         $this->space = $space;
     }

}

