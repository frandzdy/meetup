<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sm_communaute")
 * @ORM\Entity(repositoryClass="App\Repository\CommunauteRepository")
 */
class Communaute
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
     * @ORM\ManyToMany(targetEntity="User", inversedBy="communautes")
     * @ORM\JoinTable(name="sm_communaute_user",
     *     joinColumns={@ORM\JoinColumn(name="communaute", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id")})
     */
    private $members;

    /**
     * @ORM\ManyToOne(targetEntity="RefTypeCommunaute")
     * @ORM\JoinColumn(name="type_communaute_id", referencedColumnName="id")
     */
    private $typeCommunaute;

    /**
     * Communaute constructor.
     */
    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    /**
     * @param User $member
     * @return $this
     */
    public function addMember(User $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
        }

        return $this;
    }

    /**
     * @param User $member
     * @return $this
     */
    public function removeMember(User $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypeCommunaute()
    {
        return $this->typeCommunaute;
    }

    /**
     * @param $typeCommunaute
     * @return $this
     */
    public function setTypeCommunaute($typeCommunaute): self
    {
        $this->typeCommunaute = $typeCommunaute;

        return $this;
    }
}
