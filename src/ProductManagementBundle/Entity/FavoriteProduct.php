<?php
/**
 * Created by PhpStorm.
 * User: Emir
 * Date: 17/09/2019
 * Time: 22:50
 */

namespace ProductManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favorite
 *
 * @ORM\Table(name="favorite_product")
 * @ORM\Entity(repositoryClass="ProductManagementBundle\Repository\FavoriteProductRepository")
 */
class FavoriteProduct
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ProductManagementBundle\Entity\Product")
     * @ORM\JoinColumn(name="product_id",referencedColumnName="id", onDelete="CASCADE")
     */
    private $product;
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\Users")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * FavoriteProduct constructor.
     * @param $product
     * @param $user
     */
    public function __construct($product, $user)
    {
        $this->product = $product;
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
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

}