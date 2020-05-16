<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sm_notification")
 * @ORM\Entity(repositoryClass=NotificationRepository::class)
 */
class Notification
{
    use TraitDate;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="notifications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Wall", inversedBy="notifications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $wall;

    /**
     * @ORM\Column(type="boolean")
     */
    private $lu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getWall(): ?Wall
    {
        return $this->wall;
    }

    public function setWall(?Wall $wall): self
    {
        $this->wall = $wall;

        return $this;
    }

    public function getLu(): ?bool
    {
        return $this->lu;
    }

    public function setLu(bool $lu): self
    {
        $this->lu = $lu;

        return $this;
    }
}
