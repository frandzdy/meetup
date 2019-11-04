<?php


namespace App\Repository;


use App\Entity\RefEquipement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RefEquipementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RefEquipement::class);
    }

    /***
     * @param $search
     * @return mixed
     */
    public function findEquipementAutocomplete($search)
    {
        return $this->createQueryBuilder('ref_equipement')
            ->select('ref_equipement.id')
            ->join('ref_equipement.eventInstallation', 'eventInstallation')
            ->addSelect("CONCAT_WS(' - ', eventInstallation.name, ref_equipement.nameEquipement, eventInstallation.city, eventInstallation.codePostal) as label")
            ->addSelect('ref_equipement.gpsX')
            ->addSelect('ref_equipement.gpsY')
            ->addSelect('eventInstallation.name as nomInstallation')
            ->addSelect('eventInstallation.city as ville')
            ->addSelect('eventInstallation.address as adresse')
            ->addSelect('eventInstallation.addressComplement as adresseComplementaire')
            ->addSelect('eventInstallation.codePostal')
            ->addSelect('eventInstallation.nbPlaceParking')
            ->addSelect('ref_equipement.typeEquipement')
            ->addSelect('ref_equipement.proprietairePrincipal')
            ->addSelect('ref_equipement.proprietaireSecond')
            ->addSelect('ref_equipement.gestionnairePrincipal')
            ->addSelect('ref_equipement.gestionnaireSecond')
            ->addSelect('ref_equipement.interieur')
            ->addSelect('ref_equipement.natureSol')
            ->addSelect('ref_equipement.nbVestiaire as NombreVestiaire')
            ->addSelect('ref_equipement.nbEquipement as NombreEquipement')
            ->addSelect('ref_equipement.nbCouloir as NombreCouloir')
            ->where('eventInstallation.codePostal like :search')
            ->orWhere('eventInstallation.name like :search')
            ->orWhere('eventInstallation.city like :search')
            ->orWhere('ref_equipement.nameEquipement like :search')
            ->setParameter('search', $search.'%')
            ->getQuery()->getResult()
        ;
    }
}
