<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sm_like_wall")
 * @ORM\Entity(repositoryClass="App\Repository\LikeWallRepository")
 */
class LikeWall
{
    use TraitDate, TraitFiltre;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Wall")
     */
    private $wall;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $users
     */
    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getWall()
    {
        return $this->wall;
    }

    /**
     * @param mixed $wall
     */
    public function setWall($wall): self
    {
        $this->wall = $wall;

        return $this;
    }
}
