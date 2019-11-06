<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="sm_events")
 * @ORM\Entity(repositoryClass="App\Repository\EventsRepository")
 */
class Events
{
    use TraitDate, TraitAuthor;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(name="start_date", type="datetime")
     *
     */
    private $startDate;

    /**
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="RefEquipement")
     * @ORM\JoinColumn(name="ref_equipement_id", referencedColumnName="id")
     */
    private $eventsPlace;

    /**
     * @var
     * @ORM\Column(name="nb_participants", type="integer", length=11)
     * @Assert\GreaterThan(value="0", message="Le nombre de participant ne peut être égale à 0")
     * @Assert\LessThan(value="30", message="Le nombre de participant ne peut être supérieur à 30")
     */
    private $nbParticipants;

    /**
     * @ORM\Column(name="place", type="string", length=255)
     */
    private $place;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="User", inversedBy="events")
     * @ORM\JoinTable(name="sm_event_user",
     *     joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *     )
     */
    private $participants;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Wall", mappedBy="event_id")
     */
    private $walls;

    /**
     * @ORM\Column(name="i_calendar", type="text", nullable=true)
     */
    private $iCalendar;

    /**
     * @ORM\Column(name="a_calendar", type="text", nullable=true)
     */
    private $aCalendar;

    /**
     * Events constructor.
     */
    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->walls = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate($startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate($endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param $author
     * @return $this
     */
    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEventsPlace()
    {
        return $this->eventsPlace;
    }

    /**
     * @param mixed $eventsPlace
     */
    public function setEventsPlace($eventsPlace): void
    {
        $this->eventsPlace = $eventsPlace;
    }

    /**
     * @return mixed
     */
    public function getNbParticipants()
    {
        return $this->nbParticipants;
    }

    /**
     * @param mixed $nbParticipants
     */
    public function setNbParticipants($nbParticipants): void
    {
        $this->nbParticipants = $nbParticipants;
    }

    /**
     * @return mixed
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param user $participant
     * @return $this
     */
    public function addParticipant(user $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
        }

        return $this;
    }

    /**
     * @param mixed $participants
     */
    public function removeParticipant(User $participant): self
    {
        if ($this->participants->contains($participant)) {
            $this->participants->removeElement($participant);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param $place
     * @return $this
     */
    public function setPlace($place): self
    {
        $this->place = $place;

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
            $wall->setEventId($this);
        }

        return $this;
    }

    public function removeWall(Wall $wall): self
    {
        if ($this->walls->contains($wall)) {
            $this->walls->removeElement($wall);
            // set the owning side to null (unless already changed)
            if ($wall->getEventId() === $this) {
                $wall->setEventId(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getICalendar()
    {
        return $this->iCalendar;
    }

    /**
     * @param $iCalendar
     * @return $this
     */
    public function setICalendar(?string $iCalendar): self
    {
        $this->iCalendar = $iCalendar;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getACalendar()
    {
        return $this->aCalendar;
    }

    /**
     * @param $aCalendar
     * @return $this
     */
    public function setACalendar(?string $aCalendar): self
    {
        $this->aCalendar = $aCalendar;

        return $this;
    }
}
