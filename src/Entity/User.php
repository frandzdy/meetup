<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="sm_user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    use Date;
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="lastname", type="text")
     * @Assert\NotNull(message="Le nom de famille est obligatoire", groups={"create","edit"})
     */
    private $lastname;

    /**
     * @ORM\Column(name="firstname", type="text")
     * @Assert\NotNull(message="Le prénom de famille est obligatoire", groups={"create","edit"})
     */
    private $firstname;

    /**
     * @ORM\Column(name="avatar", type="string", length=255, nullable=false)
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="RefCivilite")
     * @Assert\NotNull(message="Votre civilitée est obligatoire", groups={"create", "edit"})
     */
    private $civilite;

    /**
     * @ORM\Column(name="date_naissance", type="datetime")
     * @Assert\NotNull(message="Votre date de naissance est obligatoire", groups={"create", "edit"})
     */
    private $dateNaissance;

    /**
     * @ORM\Column(name="adresse", type="string", length=255)
     * @Assert\NotNull(message="Votre adresse est obligatoire", groups={"create", "edit"})
     */
    private $adresse;

    /**
     * @ORM\Column(name="code_postal", type="integer", length=11)
     * @Assert\NotNull(message="Votre adresse est obligatoire", groups={"create", "edit"})
     */
    private $codePostal;

    /**
     * @ORM\Column(name="ville", type="string", length=255)
     * @Assert\NotNull(message="Votre adresse est obligatoire", groups={"create", "edit"})
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="sender")
     */
    private $messagesSender;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User")
     * @ORM\JoinTable(name="sm_user_contact",
     *     joinColumns={@ORM\JoinColumn(name="me", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="my_contact", referencedColumnName="id")}
     * )
     */
    private $myUsers;

    /**
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Discussion", mappedBy="users")
     */
    private $discussions;
    /**
     * @var
     * @Assert\Unique(message="Le-mail doit être unique")
     */
    protected $email;
    /**
     * @var
     * @Assert\Unique(message="L'identifiant doit être unique")
     */
    protected $username;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Events", mappedBy="participants")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Wall", mappedBy="user_id")
     */
    private $walls;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->messagesSender = new ArrayCollection();
        $this->myUsers = new ArrayCollection();
        $this->discussions = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->walls = new ArrayCollection();
    }

    /**
     * Set image
     *
     * @param Image $image
     *
     * @return User
     */
    public function setAvatar(string $avatar) : self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get Avatar
     *
     * @return string
     */
    public function getAvatar() : ?string
    {
        return $this->avatar;
    }

    /**
     * Set civilite
     *
     * @param RefCivilite $civilite
     *
     * @return RefCivilite
     */
    public function setCivilite(RefCivilite $civilite) : self
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get Civilite
     *
     * @return RefCivilite
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Set dateNaissance
     *
     * @param $dateNaissance
     * @return $this
     */
    public function setDateNaissance(\DateTime $dateNaissance) : self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance() : ?\DateTime
    {
        return $this->dateNaissance;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname(string $lastname) : self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname(string $firstname) : self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param mixed $codePostal
     */
    public function setCodePostal(int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) : self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessagesSender(): Collection
    {
        return $this->messagesSender;
    }

    public function addMessageSender(Message $message): self
    {
        if (!$this->messagesSender->contains($message)) {
            $this->messagesSender[] = $message;
            $message->setSender($this);
        }

        return $this;
    }

    public function removeMessageSender(Message $message): self
    {
        if ($this->messagesSender->contains($message)) {
            $this->messagesSender->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMyUsers(): Collection
    {
        return $this->myUsers;
    }

    public function addMyUsers(User $myUsers): self
    {
        if (!$this->myUsers->contains($myUsers)) {
            $this->myUsers[] = $myUsers;
        }

        return $this;
    }

    public function removeMyUsers(User $myUsers): self
    {
        if ($this->myUsers->contains($myUsers)) {
            $this->myUsers->removeElement($myUsers);
        }

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
     * @param $token
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     *
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
     * @return Collection|Discussion[]
     */
    public function getDiscussions(): Collection
    {
        return $this->discussions;
    }

    public function addDiscussion(Discussion $discussion): self
    {
        if (!$this->discussions->contains($discussion)) {
            $this->discussions[] = $discussion;
            $discussion->addUser($this);
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): self
    {
        if ($this->discussions->contains($discussion)) {
            $this->discussions->removeElement($discussion);
            $discussion->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Events[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Events $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addParticipant($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            $event->removeParticipant($this);
        }

        return $this;
    }

    /**
     * @return Collection|Wall[]
     */
    public function getWalls(): Collection
    {
        return $this->walls;
    }

    public function addWall(Wall $wall): self
    {
        if (!$this->walls->contains($wall)) {
            $this->walls[] = $wall;
            $wall->setUserId($this);
        }

        return $this;
    }

    public function removeWall(Wall $wall): self
    {
        if ($this->walls->contains($wall)) {
            $this->walls->removeElement($wall);
            // set the owning side to null (unless already changed)
            if ($wall->getUserId() === $this) {
                $wall->setUserId(null);
            }
        }

        return $this;
    }
}
