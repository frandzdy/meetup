<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Wall;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of RecaptchaService
 *
 * Service permettant de gerer la réponse captcha lors d' inscription sur le site de SARPi
 *
 * @author Sanon Frandzdy <fsanon@webnet.fr>
 */
class WallService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * WallService constructor.
     * @param EntityManagerInterface $ems
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param User $user
     * @return Wall
     * @throws \Exception
     */
    public function saveWall(User $user, $message) :Wall
    {
        $wall = (new Wall())->setUser($user)->setMessage($message)
            ->setDateCreation(new \DateTime('now'));

        $this->em->persist($wall);
        $this->em->flush();

        return  $wall;
    }
}
