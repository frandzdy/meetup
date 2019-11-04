<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sm_discussion")
 * @ORM\Entity(repositoryClass="App\Repository\DiscussionRepository")
 */
class Discussion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\user", inversedBy="discussions")
     * @ORM\JoinTable(name="sm_discussion_user",
     *     joinColumns={@ORM\JoinColumn(name="discussion_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    private $users;

    /**
     * @var
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="discussion")
     */
    private $messages;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RefTypeGroupe")
     */
    private $type;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|user[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(user $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(user $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getToken() : string
    {
        return $this->token;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     *
     * @return $this
     * @throws \Exception
     */
    public function setToken(): self
    {
        if (!$this->token) {
            $this->token = hash('sha256', random_bytes(32));
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param $messages
     * @return $this
     */
    public function setMessages($messages): self
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     * @return $this
     */
    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }
}
