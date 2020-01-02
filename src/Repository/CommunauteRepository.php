<?php


namespace App\Repository;


use App\Entity\Communaute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CommunauteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Communaute::class);
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getCommunity(int $userId) : array {

        $qb = $this->createQueryBuilder('c');

        $qb->select('c')
        ->innerJoin('c.members', 'm')
        //->where('m.id = :userId')
        ->where($qb->expr()->eq('m.id', $userId));

        return  $qb->getQuery()->getResult();
    }
}
