<?php

namespace App\Repository;


use App\Entity\User;
use App\Entity\Wall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class WallRepository
 * @package App\Entity\Repository
 */
class WallRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Wall::class);
    }

    /**
     * @param User $user
     * @return int|mixed|string
     */
    public function getWallUser(User $user)
    {
        return $this->createQueryBuilder('wall')
            ->select('wall, commentaires, video, photo, user, likesWall, likesCommentaire, notifications')
            ->leftJoin('wall.commentaires', 'commentaires')
            ->leftJoin('commentaires.likes', 'likesCommentaire')
            ->leftJoin('wall.photos', 'photo')
            ->leftJoin('wall.user', 'user')
            ->leftJoin('wall.video', 'video')
            ->leftJoin('wall.likes', 'likesWall')
            ->leftJoin('wall.notifications', 'notifications')
            ->where('user.id = :user')
            ->setParameter('user', $user)
            ->orderBy('wall.createdAt','DESC')
            ->addOrderBy('commentaires.createdAt','ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $id
     * @return int|mixed|string
     */
    public function findWall($id)
    {
        return $this->createQueryBuilder('wall')
            ->select('wall, commentaires, video, photo, user, notifications, likesWall, likesCommentaire')
            ->leftJoin('wall.commentaires', 'commentaires')
            ->leftJoin('commentaires.likes', 'likesCommentaire')
            ->leftJoin('wall.photos', 'photo')
            ->leftJoin('wall.user', 'user')
            ->leftJoin('wall.video', 'video')
            ->leftJoin('wall.notifications', 'notifications')
            ->leftJoin('wall.likes', 'likesWall')
            ->where('wall.id = :wall')
            ->setParameter('wall', $id)
            ->getQuery()
            ->getResult();
    }
}
