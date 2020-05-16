<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\This;

/**
 * @ORM\Table(name="sm_commentaire")
 * @ORM\Entity(repositoryClass="App\Repository\CommentaireRepository")
 */
class Commentaire
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
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="App\Entity\LikeCommentaire", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="sm_commentaire_like",
     *     joinColumns={@ORM\JoinColumn(name="commentaire_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="like_commentaire_id", referencedColumnName="id")}
     * )
     */
    private $likes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Wall")
     */
    private $wall;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message): self
    {
        $this->message = $message;

        return $this;
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
     * @return Collection|Communaute[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(LikeCommentaire $likeCommentaire): self
    {
        if (!$this->likes->contains($likeCommentaire)) {
            $this->likes[] = $likeCommentaire;
            $likeCommentaire->setCommentaire($this);
        }

        return $this;
    }

    public function removeLike(LikeCommentaire $likeCommentaire): self
    {
        if ($this->likes->contains($likeCommentaire)) {
            $this->likes->removeElement($likeCommentaire);

            if ($likeCommentaire->getCommentaire() === $this) {
                $likeCommentaire->setCommentaire(null);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getUserFromLikes() {
        $allUserFromLikes = [];
        foreach ($this->getLikes() as $like) {
            if ($like) {
                $allUserFromLikes[] = $like->getUser()->getId();
            }
        }

        return array_flip($allUserFromLikes);
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
