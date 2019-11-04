<?php


namespace App\Repository;


use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MessageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function getAllMessageFromGroupe($groupe, $step = 5, $order = null)
    {
        $resultat = [];
        $offset = 0;
        $res = $this->createQueryBuilder('message')
            ->select('count(message.message) nbMessage')
            ->join('message.discussion', 'discussion')
            ->where('discussion.token = :token')
            ->setParameter('token', $groupe->getToken())
            ->getQuery()->getArrayResult();
        $max = (int)current($res)['nbMessage'];
        if ($max > 0) {
            $offset = $max - $step;
        }
        if($offset < 0) {
            $offset = 0;
        }
        if ($order) {
            $resultat = $this->createQueryBuilder('message')
                ->select('message.id')
                ->addSelect('message.message')
                ->addSelect("DATE_FORMAT(message.create_at, '%d-%m-%Y %H:%i:%s') as create_at")
                ->join('message.discussion', 'discussion')
                ->join('message.sender', 'sender')
                ->addSelect('sender.firstname')
                ->addSelect('sender.lastname')
                ->addSelect('sender.token')
                ->where('discussion.token = :token')
                ->setParameter('token', $groupe->getToken());
            if ($offset >= 0) {
                $resultat->setFirstResult($offset)
                    ->setMaxResults(5);
            }
            $res = $resultat->getQuery()->getArrayResult();
            rsort($res);

            return $res;
        } else {
            $resultat = $this->createQueryBuilder('message')
                ->select('message.id')
                ->addSelect('message.message')
                ->addSelect("DATE_FORMAT(message.create_at, '%d-%m-%Y %H:%i:%s') as create_at")
                ->join('message.discussion', 'discussion')
                ->join('message.sender', 'sender')
                ->addSelect('sender.firstname')
                ->addSelect('sender.lastname')
                ->addSelect('sender.token')
                ->where('discussion.token = :token')
                ->setParameter('token', $groupe->getToken());
            if ($offset > 0) {
                $resultat->setFirstResult($offset)
                    ->setMaxResults(5);
            } else {
                $resultat->setMaxResults(5);
            }

            return $resultat->getQuery()->getArrayResult();
        }
    }
}
