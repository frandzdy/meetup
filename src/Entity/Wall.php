<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="sm_wall")
 * @ORM\Entity(repositoryClass="App\Repository\WallRepository")
 */
class Wall
{
    use TraitDate, TraitFiltre;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="walls")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var
     * @ORM\OneToOne(targetEntity="App\Entity\Video", cascade={"persist", "remove"})
     * @ORM\JoinColumn(referencedColumnName="id", name="video")
     *
     */
    private $video;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="App\Entity\Image", cascade={"persist", "remove"}, mappedBy="wall")
     * @ORM\JoinColumn(referencedColumnName="id", name="photo")
     */
    private $photos;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="App\Entity\Commentaire", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="sm_wall_commentaire",
     *     joinColumns={@ORM\JoinColumn(name="wall_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="commentaire_id", referencedColumnName="id")}
     * )
     */
    private $commentaires;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="App\Entity\LikeWall", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="sm_wall_like",
     *     joinColumns={@ORM\JoinColumn(name="wall_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="like_wall_id", referencedColumnName="id")}
     * )
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notification", mappedBy="wall", cascade={"persist","remove"})
     */
    private $notifications;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->notifications = new ArrayCollection();
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
     * @return mixed
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param mixed $video
     */
    public function setVideo($video): void
    {
        $this->video = $video;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param mixed $photo
     */
    public function addPhoto(Image $photo): void
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setWall($this);
        }
    }

    public function removePhoto(Image $photo): self
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);

            if ($photo->getWall() === $this) {
                $photo->setWall(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|Message[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setWall($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);

            if($commentaire->getWall() === $this) {
                $commentaire->setWall(null);
            }
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    /**
     * @param LikeWall $likeWall
     * @return $this
     */
    public function addLike(LikeWall $likeWall): self
    {
        if (!$this->likes->contains($likeWall)) {
            $this->likes[] = $likeWall;
            $likeWall->setWall($this);
        }

        return $this;
    }

    /**
     * @param LikeWall $likeWall
     * @return $this
     */
    public function removeLike(LikeWall $likeWall): self
    {
        if ($this->likes->contains($likeWall)) {
            $this->likes->removeElement($likeWall);

            if ($likeWall->getWall() === $this) {
                $likeWall->setWall(null);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getUserFromLikes() {
        $allLikesFromUser = [];
        foreach($this->getLikes() as $like) {
            if ($like) {
                $allLikesFromUser[] = $like->getUser()->getId();
            }
        }

        return array_flip($allLikesFromUser);
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setWall($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
            // set the owning side to null (unless already changed)
            if ($notification->getWall() === $this) {
                $notification->setWall(null);
            }
        }

        return $this;
    }
}
