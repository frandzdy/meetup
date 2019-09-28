<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

// contrainte sur les attributs de la classe Advert
use Symfony\Component\Validator\Constraints as Assert;

// vérification de l'unicité de la classe unique
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

// pareil validation du formulaire
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * RefCivilite
 *
 * @ORM\Table(name="ref_civilite")
 * @ORM\Entity(repositoryClass="App\Repository\RefCiviliteRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class RefCivilite
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="civilite", type="text")
     * @Assert\NotBlank
     */
    private $civilite;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * @param string $civilite
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
    }

}
