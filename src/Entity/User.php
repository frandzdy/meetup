<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 * @UniqueEntity("username", message="Il existe déjà un compte pour cette identifiant.")
 * @UniqueEntity("email", message="Il existe déjà un compte pour cette e-mail.")
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
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"})
     * @Assert\NotNull(message="Votre photo est obligatoire", groups={"create","edit"})
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="RefCivilite")
     * @Assert\NotNull(message="Votre civilitée est obligatoire", groups={"create","edit"})
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
     * Set image
     *
     * @param Image $image
     *
     * @return User
     */
    public function setImage(Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set civilite
     *
     * @param RefCivilite $civilite
     *
     * @return RefCivilite
     */
    public function setCivilite(RefCivilite $civilite)
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
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
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
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
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
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
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
    public function setAdresse($adresse): void
    {
        $this->adresse = $adresse;
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
    public function setCodePostal($codePostal): void
    {
        $this->codePostal = $codePostal;
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
    public function setId($id): void
    {
        $this->id = $id;
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
    public function setVille($ville): void
    {
        $this->ville = $ville;
    }
}
