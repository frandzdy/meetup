<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Image;
use App\Entity\LikeCommentaire;
use App\Entity\LikeWall;
use App\Entity\Notification;
use App\Entity\User;
use App\Entity\Video;
use App\Entity\Wall;
use App\Form\WallType;
use App\Service\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MenuController
 * @package App\Controller
 */
class MenuController extends AbstractController
{
    /**
     * @Route("/menu", name="front_menu")
     */
    public function menu(Request $request, EntityManagerInterface $em, NotificationService $notificationService)
    {
        $user = $em->getRepository(User::class)->getUserNotfications($this->getUser());

        return $this->render('component/menu.html.twig', ['user' => $user]);
    }
}

