<?php


namespace App\Repository;


use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MessageRepository extends ServiceEntityRepository
{
    private $first_call;
    private $session;

    public function __construct(RegistryInterface $registry, SessionInterface $session)
    {
        parent::__construct($registry, Message::class);
        $this->first_call = false;
        $this->session = $session;
    }

    public function getAllMessageFromGroupe($groupe, $step = 0)
    {
        $resultat = [];

        $res = $this->createQueryBuilder('message')
            ->select('message.id')
            ->addSelect('message.message')
            ->addSelect("DATE_FORMAT(message.createdAt, '%d-%m-%Y %H:%i:%s') as created_at")
            ->join('message.discussion', 'discussion')
            ->join('message.sender', 'sender')
            ->addSelect('sender.firstname')
            ->addSelect('sender.lastname')
            ->addSelect('sender.token')
            ->where('discussion.token = :token')
            ->setParameter('token', $groupe->getToken())
            ->orderBy('message.createdAt', 'DESC')
            ->setFirstResult($step)
            ->setMaxResults(5)->getQuery()->getArrayResult();

        return $res;
    }
}
