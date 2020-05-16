<?php
namespace App\Repository;


use App\Entity\Commentaire;
use App\Entity\LikeCommentaire;
use App\Entity\LikeWall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class LikeCommentaireRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LikeCommentaire::class);
    }
}
