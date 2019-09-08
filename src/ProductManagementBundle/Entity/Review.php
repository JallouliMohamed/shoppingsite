<?php

namespace ProductManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Review
 *
 * @ORM\Table(name="review")
 * @ORM\Entity(repositoryClass="ProductManagementBundle\Repository\ReviewRepository")
 */
class Review
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
     * @ORM\Column(name="reviewText", type="string", length=255)
     */
    private $reviewText;

    /**
     * @var date
     * @ORM\Column(name="reviewedAt", type="datetime")
     */
    private $reviewedAt;

    /**
     * @var integer
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\LessThanOrEqual(5)
     * @ORM\Column(name="Rating", type="integer", nullable=true)
     */
    private $rating;

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * Review constructor.
     *
     */
    public function __construct()
    {
        $this->reviewedAt = new \DateTime("now");
    }


    /**
     * @return datetime
     */
    public function getReviewedAt()
    {
        return $this->reviewedAt;
    }

    /**
     * @param datetime $reviewedAt
     */
    public function setReviewedAt($reviewedAt)
    {
        $this->reviewedAt = $reviewedAt;
    }

    /**
     *
     * @ORM\ManyToOne(targetEntity="ProductManagementBundle\Entity\Product")
     * @ORM\JoinColumn(name="Product_id",referencedColumnName="id", onDelete="CASCADE")
     */
    private $product;

    /**
     *
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\Users")
     * @ORM\JoinColumn(name="User_id",referencedColumnName="id", onDelete="CASCADE")
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
     * @return string
     */
    public function getReviewText()
    {
        return $this->reviewText;
    }

    /**
     * @param string $reviewText
     */
    public function setReviewText($reviewText)
    {
        $this->reviewText = $reviewText;
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

