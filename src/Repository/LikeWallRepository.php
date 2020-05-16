<?php
namespace App\Repository;


use App\Entity\Commentaire;
use App\Entity\LikeWall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class LikeWallRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LikeWall::class);
    }
}
