<?php

namespace ProductManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favorite
 *
 * @ORM\Table(name="favorite")
 * @ORM\Entity(repositoryClass="ProductManagementBundle\Repository\FavoriteRepository")
 */
class Favorite
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
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\Users")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * Favorite constructor.
     * @param $user
     * @param $subcategory
     */
    public function __construct($user, $subcategory)
    {
        $this->user = $user;
        $this->subcategory = $subcategory;
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
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ProductManagementBundle\Entity\SubCategory")
     * @ORM\JoinColumn(name="SubCategory_id",referencedColumnName="id", onDelete="CASCADE")
     */
    private $subcategory;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

