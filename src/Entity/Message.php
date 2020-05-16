<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sm_message")
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    use TraitDate, TraitAuthor;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="messagesSender")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Discussion", inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $discussion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAtFormatted()
    {
        return $this->getCreatedAt()->format('d-m-Y H:i:s');
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiscussion()
    {
        return $this->discussion;
    }

    /**
     * @param Discussion $discussion
     * @return $this
     */
    public function setDiscussion(Discussion $discussion): self
    {
        $this->discussion = $discussion;

        return $this;
    }
}
