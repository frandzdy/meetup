<?php


namespace App\Repository;


use App\Entity\Discussion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DiscussionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Discussion::class);
    }

    /**
     * @param array $data
     * @param $type
     * @return mixed
     */
    public function getDiscussion(array $data)
    {

        $res  = $this->createQueryBuilder('discussion')
            ->select('discussion');
            foreach ($data as $dat) {
                $res->join('discussion.users', 'users'.$dat->getId() , 'WITH', 'users'.$dat->getId().'.id = ' . $dat->getId());
            }
        $res->groupBy('discussion.id');

            return $res->getQuery()->getResult();
    }
}
