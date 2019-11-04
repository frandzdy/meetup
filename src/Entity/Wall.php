<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sm_wall")
 * @ORM\Entity(repositoryClass="App\Repository\WallRepository")
 */
class Wall
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $date_creation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="walls")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\events", inversedBy="walls")
     * @ORM\JoinColumn(name="events_id", referencedColumnName="id")
     */
    private $events;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    /**
     * @param \DateTimeInterface $date_creation
     * @return $this
     */
    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    /**
     * @return user|null
     */
    public function getUser(): ?user
    {
        return $this->user;
    }

    /**
     * @param user|null $userId
     * @return $this
     */
    public function setUser(?user $userId): self
    {
        $this->user = $userId;

        return $this;
    }

    /**
     * @return events|null
     */
    public function getEvents(): ?events
    {
        return $this->events;
    }

    /**
     * @param events|null $eventId
     * @return $this
     */
    public function setEvents(?events $eventId): self
    {
        $this->events = $eventId;

        return $this;
    }
}
