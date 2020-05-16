<?php


namespace App\Service;


use App\Entity\Notification;
use App\Entity\User;
use App\Entity\Wall;
use Doctrine\ORM\EntityManagerInterface;

class NotificationService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * NotificationService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param User $user
     */
    public function sendNotification(array $tokens, Wall $wall, $forCommentaire = false){
        if($tokens) {
            foreach ($tokens as $token) {
                $user  = $this->em->getRepository(User::class)->findOneBy(
                    [
                        'token' => $token
                    ]
                );
                if ($user) {
                    $notification = new Notification();
                    $notification->setUser($user)->setWall($wall)->setLu(false)->setCreatedAt((new \DateTime()));
                    if ($forCommentaire) {
                        $this->em->persist($notification);
                    }
                    $this->em->flush();
                }
            }
            return true;
        }
        return false;
    }
}
