<?php

namespace App\Repository;


use App\Entity\RefCivilite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class RefCiviliteRepository
 * @package App\Entity\Repository
 */
class RefCiviliteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RefCivilite::class);
    }
}
