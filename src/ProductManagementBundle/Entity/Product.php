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
     * @var float
     * @Assert\GreaterThanOrEqual(0)
     * @ORM\Column(name="Price", type="float")
     */
    private $price;

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
     * @ORM\Column(type="string", length=255)
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

}

