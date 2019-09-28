<?php


namespace App\Repository;


use App\Entity\Events;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EventsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Events::class);
    }

    /**
     * @param $start
     * @param $end
     * @return mixed
     */
    public function getEvents($start, $end)
    {
        return $this->createQueryBuilder('e')
            ->where('e.startDate BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()->getResult();
    }
}
