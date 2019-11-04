<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sm_ref_equipement")
 * @ORM\Entity(repositoryClass="App\Repository\RefEquipementRepository")
 */
class RefEquipement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameEquipement;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    private $nbEquipement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeEquipement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gestionnairePrincipal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $proprietairePrincipal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gestionnaireSecond;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $proprietaireSecond;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $interieur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $natureSol;

    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $nbCouloir;

    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $nbVestiaire;

    /**
     * @ORM\Column(type="boolean", length=255)
     */
    private $hasAccessHandi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gpsX;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gpsY;

    /**
     * @ORM\ManyToOne(targetEntity="RefInstallation")
     * @ORM\JoinColumn(name="ref_installation_id", referencedColumnName="id")
     */
    private $eventInstallation;

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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddressComplement(): ?string
    {
        return $this->addressComplement;
    }

    /**
     * @param string $addressComplement
     * @return $this
     */
    public function setAddressComplement(string $addressComplement): self
    {
        $this->addressComplement = $addressComplement;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    /**
     * @param string $codePostal
     * @return $this
     */
    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getAccessibilityHandiMoteur(): ?int
    {
        return $this->accessibilityHandiMoteur;
    }

    /**
     * @param int $accessibilityHandiMoteur
     * @return $this
     */
    public function setAccessibilityHandiMoteur(int $accessibilityHandiMoteur): self
    {
        $this->accessibilityHandiMoteur = $accessibilityHandiMoteur;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getAccessibilityHandiSens(): ?int
    {
        return $this->accessibilityHandiSens;
    }

    /**
     * @param int $accessibilityHandiSens
     * @return $this
     */
    public function setAccessibilityHandiSens(int $accessibilityHandiSens): self
    {
        $this->accessibilityHandiSens = $accessibilityHandiSens;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getNbPlaceParking(): ?int
    {
        return $this->nbPlaceParking;
    }

    /**
     * @param int $nbPlaceParking
     * @return $this
     */
    public function setNbPlaceParking(int $nbPlaceParking): self
    {
        $this->nbPlaceParking = $nbPlaceParking;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getNbPlaceParkingHandi(): ?int
    {
        return $this->nbPlaceParkingHandi;
    }

    /**
     * @param int $nbPlaceParkingHandi
     * @return $this
     */
    public function setNbPlaceParkingHandi(int $nbPlaceParkingHandi): self
    {
        $this->nbPlaceParkingHandi = $nbPlaceParkingHandi;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getHasGuardian(): ?bool
    {
        return $this->hasGuardian;
    }

    /**
     * @param bool $hasGuardian
     * @return $this
     */
    public function setHasGuardian(bool $hasGuardian): self
    {
        $this->hasGuardian = $hasGuardian;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNameEquipement()
    {
        return $this->nameEquipement;
    }

    /**
     * @param $nameEquipement
     * @return $this
     */
    public function setNameEquipement($nameEquipement): self
    {
        $this->nameEquipement = $nameEquipement;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNbEquipement()
    {
        return $this->nbEquipement;
    }

    /**
     * @param $nbEquipement
     * @return $this
     */
    public function setNbEquipement($nbEquipement): self
    {
        $this->nbEquipement = $nbEquipement;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypeEquipement()
    {
        return $this->typeEquipement;
    }

    /**
     * @param $typeEquipement
     * @return $this
     */
    public function setTypeEquipement($typeEquipement): self
    {
        $this->typeEquipement = $typeEquipement;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGestionnairePrincipal()
    {
        return $this->gestionnairePrincipal;
    }

    /**
     * @param $gestionnairePrincipal
     * @return $this
     */
    public function setGestionnairePrincipal($gestionnairePrincipal): self
    {
        $this->gestionnairePrincipal = $gestionnairePrincipal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProprietairePrincipal()
    {
        return $this->proprietairePrincipal;
    }

    /**
     * @param $proprietairePrincipal
     * @return $this
     */
    public function setProprietairePrincipal($proprietairePrincipal): self
    {
        $this->proprietairePrincipal = $proprietairePrincipal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGestionnaireSecond()
    {
        return $this->gestionnaireSecond;
    }

    /**
     * @param $gestionnaireSecond
     * @return $this
     */
    public function setGestionnaireSecond($gestionnaireSecond): self
    {
        $this->gestionnaireSecond = $gestionnaireSecond;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProprietaireSecond()
    {
        return $this->proprietaireSecond;
    }

    /**
     * @param $proprietaireSecond
     * @return $this
     */
    public function setProprietaireSecond($proprietaireSecond): self
    {
        $this->proprietaireSecond = $proprietaireSecond;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInterieur()
    {
        return $this->interieur;
    }

    /**
     * @param $interieur
     * @return $this
     */
    public function setInterieur($interieur): self
    {
        $this->interieur = $interieur;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNatureSol()
    {
        return $this->natureSol;
    }

    /**
     * @param $natureSol
     * @return $this
     */
    public function setNatureSol($natureSol): self
    {
        $this->natureSol = $natureSol;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNbCouloir()
    {
        return $this->nbCouloir;
    }

    /**
     * @param $nbCouloir
     * @return $this
     */
    public function setNbCouloir($nbCouloir): self
    {
        $this->nbCouloir = $nbCouloir;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNbVestiaire()
    {
        return $this->nbVestiaire;
    }

    /**
     * @param $nbVestiaire
     * @return $this
     */
    public function setNbVestiaire($nbVestiaire): self
    {
        $this->nbVestiaire = $nbVestiaire;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHasAccessHandi()
    {
        return $this->hasAccessHandi;
    }

    /**
     * @param $hasAccessHandi
     * @return $this
     */
    public function setHasAccessHandi($hasAccessHandi): self
    {
        $this->hasAccessHandi = $hasAccessHandi;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGpsX()
    {
        return $this->gpsX;
    }

    /**
     * @param $gpsX
     * @return $this
     */
    public function setGpsX($gpsX): self
    {
        $this->gpsX = $gpsX;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGpsY()
    {
        return $this->gpsY;
    }

    /**
     * @param $gpsY
     * @return $this
     */
    public function setGpsY($gpsY): self
    {
        $this->gpsY = $gpsY;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEventInstallation()
    {
        return $this->eventInstallation;
    }

    /**
     * @param $eventInstallation
     * @return $this
     */
    public function setEventInstallation($eventInstallation): self
    {
        $this->eventInstallation = $eventInstallation;

        return $this;
    }
}
