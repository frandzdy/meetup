<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait TraitToken
{
    /**
     * @var
     * @ORM\Column(name="token", type="string", length=255, nullable=false)
     */
    private $token;

    /**
     * @return mixed
     */
    public function getToken() : string
    {
        return $this->token;
    }

    /**
     *
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
}
