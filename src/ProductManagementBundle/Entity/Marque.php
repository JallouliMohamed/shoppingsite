<?php
/**
 * Created by PhpStorm.
 * User: Emir
 * Date: 11/09/2019
 * Time: 01:22
 */

namespace ProductManagementBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * SubCategory
 *
 * @ORM\Table(name="marque")
 * @ORM\Entity(repositoryClass="ProductManagementBundle\Repository\MarqueRepository")
 *
 */
class Marque
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
     * @ORM\ManyToOne(targetEntity="ProductManagementBundle\Entity\SubCategory")
     * @ORM\JoinColumn(name="SubCategory_id",referencedColumnName="id", onDelete="CASCADE")
     */
    private $subcategory;

    /**
     * @ORM\Column(type="datetime")
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
        $this->updatedAt = new \DateTimeImmutable();
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getSubCategory()
    {
        return $this->subcategory;
    }

    /**
     * @param mixed $subcategory
     */
    public function setSubCategory($subcategory)
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
     * @return Marque
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
    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

}