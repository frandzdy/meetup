<?php

namespace App\Repository;


use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class UserRepository
 * @package App\Entity\Repository
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param User $user
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findUser(User $user)
    {
        return current($this->createQueryBuilder('user')
            ->select('user, myUsers, discussions, type, userDiscussions, typeDiscussions')
            ->leftJoin('user.myUsers', 'myUsers')
            ->leftJoin('user.discussions', 'discussions')
            ->leftJoin('discussions.type', 'type')
            ->leftJoin('myUsers.discussions', 'userDiscussions')
            ->leftJoin('userDiscussions.type', 'typeDiscussions')
            ->where('user = :user')
            ->setParameter('user', $user)
            ->andWhere('typeDiscussions.id = 1')
            ->getQuery()
            ->getArrayResult());
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getContact(User $user)
    {
        $contactIds = [];
        if (!$user->getMyUsers()->isEmpty()) {
            foreach ($user->getMyUsers() as $contact) {
                $contactIds[] = $contact->getId();
            }

            return $this->createQueryBuilder('user')
                ->where('user.id in (:ids)')
                ->setParameter('ids', $contactIds)
                ->getQuery();
        }
    }
}
