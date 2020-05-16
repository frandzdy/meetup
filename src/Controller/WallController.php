<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Image;
use App\Entity\LikeCommentaire;
use App\Entity\LikeWall;
use App\Entity\Notification;
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
 * Class WallController
 * @package App\Controller
 */
class WallController extends AbstractController
{
    /**
     * @Route("/mur", name="front_wall", options={"expose"="true"})
     */
    public function wall(Request $request, EntityManagerInterface $em, NotificationService $notificationService)
    {
        $user = $this->getUser();
        $wall = new Wall();
        $form = $this->createForm(WallType::class);
        $walls = $em->getRepository(Wall::class)->getWallUser($user);
        $form->handleRequest($request);
        $token = $request->request->get('token');
        $message = $request->request->get('message');
        $messageSanitaze = $request->request->get('messageSanitaze');
        $getPhotos = $request->files->get('photo');
        $getVideo = $request->files->get('video');
        if ($request->isXmlHttpRequest() && $request->getMethod('POST') && $this->isCsrfTokenValid('add-wall', $token)) {
            if ($getVideo) {
                $video = new Video();
                $video->setFile($getVideo);
                $wall->setVideo($video);
                $em->persist($video);
            }
            if ($getPhotos) {
                foreach ($getPhotos as $photo) {
                    $image = new Image();
                    $image->setFile($photo);
                    $wall->addPhoto($image);
                    $em->persist($image);
                }
            }
            $res = [];
            preg_match_all('/@\[([^\]]+)\]\(([^ \)]+)\)/', $message, $res);

            $notificationService->sendNotification($res[2], $wall);
            $wall->setMessage($messageSanitaze);
            $wall->setUser($user);
            $wall->setCreatedAt((new \DateTime('now')));

            $em->persist($wall);
            $em->flush();

            return new JsonResponse(
                [
                    'groupUsers' => $res[2],
                    'wall' => $wall,
                    'view' => $this->renderView('wall/wall.html.twig', ['wall' => $wall, 'user' => $user]),
                    'token' => $user->getToken()
                ],
                200);
        }

        return $this->render('wall/index.html.twig', ['walls' => $walls, 'form' => $form->createView(), 'user' => $user]);
    }

    /**
     * @Route("/mur-commentaire", methods={"POST"}, name="front_wall_commentaire", options={"expose"="true"})
     */
    public function commentaire(Request $request, EntityManagerInterface $em, NotificationService $notificationService)
    {
        $token = $request->request->get('wall')['token'];
        if ($request->isXmlHttpRequest() && $this->isCsrfTokenValid('add-commentaire', $token)) {
            $wall = $em->getRepository(Wall::class)->findWall($request->request->get('wall')['id']);
            if ($wall[0]) {
                $commentaire = new Commentaire();
                $commentaire->setMessage($request->request->get('wall')['commentaireSanitaze'])->setUser($this->getUser())
                    ->setCreatedAt((new \DateTime()));
                $wall[0]->addCommentaire($commentaire);
                $res = [];
                preg_match_all('/@\[([^\]]+)\]\(([^ \)]+)\)/', $request->request->get('wall')['commentaire'], $res);

                $notificationService->sendNotification($res[2], $wall[0], true);
                $em->persist($commentaire);
                $em->flush();

                return new JsonResponse(
                    [
                        'groupUsers' => $res[2],
                        'view' => $this->renderView('wall/commentaire.html.twig', ['commentaire' => $commentaire])
                    ],
                    200);
            }

            return new JsonResponse(['response' => 'ko'], 500);
        }
    }

    /**
     * @Route("/like-commentaire", methods={"POST"}, name="front_wall_like_commentaire", options={"expose"="true"})
     */
    public function likeCommentaire(Request $request, EntityManagerInterface $em)
    {
        if ($request->isXmlHttpRequest()) {
            $commentaire = $em->getRepository(Commentaire::class)->find($request->request->get('commentaire'));
            $user = $this->getUser();
            $existLikecommentaire = $em->getRepository(LikeCommentaire::class)->findOneBy([
                'commentaire' => $request->request->get('commentaire'),
                'user' => $user
            ]);

            if (!$existLikecommentaire) {
                $likeCommentaire = new LikeCommentaire();
                $likeCommentaire->setUser($user);
                $commentaire->addLike($likeCommentaire);
                $likeCommentaire->setCreatedAt((new \DateTime()));
                $rep = 1;
            } else {
                $commentaire->removeLike($existLikecommentaire);
                $em->remove($existLikecommentaire);
                $rep = 0;
            }
            $em->flush();

            return new JsonResponse(['response' => $rep], 200);
        }

        return new JsonResponse(['response' => 'ko'], 500);
    }

    /**
     * @Route("/like-mur", methods={"POST"}, name="front_wall_like_wall", options={"expose"="true"})
     */
    public function likeWall(Request $request, EntityManagerInterface $em)
    {
        if ($request->isXmlHttpRequest()) {
            $wall = $em->getRepository(Wall::class)->find($request->request->get('wall'));
            $user = $this->getUser();
            $existLikeWall = $em->getRepository(LikeWall::class)->findOneBy(
                [
                    'wall' => $request->request->get('wall'),
                    'user' => $user,
                ]
            );
            if (!$existLikeWall) {
                $likeWall = new LikeWall();
                $likeWall->setUser($user);
                $wall->addLike($likeWall);
                $likeWall->setCreatedAt((new \DateTime()));
                $rep = 1;
            } else {
                $wall->removeLike($existLikeWall);
                $em->remove($existLikeWall);
                $rep = 0;
            }
            $em->flush();

            return new JsonResponse(['response' => $rep], 200);
        }

        return new JsonResponse(['response' => 'ko'], 500);
    }

    /**
     * @Route("nofitication-wall/{id}", name="front_wall_notification_show_wall", requirements={"id":"\d+"})
     */
    public function notificationShowWall(Notification $notification, Request $request, EntityManagerInterface $em)
    {
        if (!$notification->getLu()) {
            $notification->setLu(true);
            $em->flush();
        }

        $wall = $em->getRepository(Wall::class)->findWall($notification->getWall()->getId());

        return $this->render('notification/wall.html.twig', ['wall' => $wall[0], 'user' => $this->getUser()]);
    }
}

