<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait TraitDate
 * @package App\Entity
 * @ORM\HasLifecycleCallbacks()
 */
trait TraitDate
{
    /**
     * @var
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;
    /**
     * @var
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;
    /**
     * @var
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @throws \Exception
     */
    public function createdAt()
    {
        $this->createdAt = new \DateTime('now');
    }
    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PreUpdate()
     * @throws \Exception
     */
    public function updatedAt()
    {
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param $deletedAt
     * @return $this
     */
    public function setDeletedAt($deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @ORM\PreRemove()
     * @throws \Exception
     */
    public function deletedAt($deletedAt): self
    {
        $this->deletedAt = new \DateTime('now');

        return $this;
    }
}
