<?php

namespace ProductManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * Follower
 *
 * @ORM\Table(name="follower")
 * @ORM\Entity(repositoryClass="ProductManagementBundle\Repository\FollowerRepository")
 */
class Follower implements JsonSerializable
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
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\Users")
     * @ORM\JoinColumn(name="follower_id",referencedColumnName="id", onDelete="CASCADE")
     */
    private $follower;
    /**
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\Users")
     * @ORM\JoinColumn(name="followed_id",referencedColumnName="id", onDelete="CASCADE")
     */
    private $followed;
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
     * @return mixed
     */
    public function getFollower()
    {
        return $this->follower;
    }

    /**
     * @param mixed $follower
     */
    public function setFollower($follower)
    {
        $this->follower = $follower;
    }

    /**
     * @return mixed
     */
    public function getFollowed()
    {
        return $this->followed;
    }

    /**
     * @param mixed $followed
     */
    public function setFollowed($followed)
    {
        $this->followed = $followed;
    }
    public function jsonSerialize() {
        return [

            'follower' => $this->follower,
            'followed' => $this->followed,
            'id'=>$this->id

        ];
    }

}

