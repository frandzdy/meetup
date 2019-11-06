<?php


namespace App\Repository;


use App\Entity\RefTypeCommunaute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RefTypeCommunauteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RefTypeCommunaute::class);
    }
}
