<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="sm_ref_installation")
 * @ORM\Entity(repositoryClass="App\Repository\RefInstallationRepository")
 */
class RefInstallation
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
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addressComplement;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $codePostal;

    /**
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(name="nb_place_parking", type="integer", length=11)
     */
    private $nbPlaceParking;

    /**
     * @ORM\Column(name="id_installation", type="string", length=255)
     */
    private $idInstallation;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param $address
     * @return $this
     */
    public function setAddress($address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressComplement()
    {
        return $this->addressComplement;
    }

    /**
     * @param $addressComplement
     * @return $this
     */
    public function setAddressComplement($addressComplement): self
    {
        $this->addressComplement = $addressComplement;

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
     * @param $codePostal
     * @return $this
     */
    public function setCodePostal($codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param $city
     * @return $this
     */
    public function setCity($city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNbPlaceParking()
    {
        return $this->nbPlaceParking;
    }

    /**
     * @param $nbPlaceParking
     * @return $this
     */
    public function setNbPlaceParking($nbPlaceParking): self
    {
        $this->nbPlaceParking = $nbPlaceParking;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNbPlaceParkingHandi()
    {
        return $this->nbPlaceParkingHandi;
    }

    /**
     * @param $nbPlaceParkingHandi
     * @return $this
     */
    public function setNbPlaceParkingHandi($nbPlaceParkingHandi): self
    {
        $this->nbPlaceParkingHandi = $nbPlaceParkingHandi;

        return $this;
    }

    /**
     * @param $idInstallation
     * @return $this
     */
    public function setIdInstallation($idInstallation): self
    {
        $this->idInstallation = $idInstallation;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdInstallation() : int
    {
        return $this->idInstallation;
    }
}
