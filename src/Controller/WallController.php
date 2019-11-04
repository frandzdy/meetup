<?php

namespace App\Controller;

use App\Entity\Wall;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WallController
 * @package App\Controller
 */
class WallController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function wall(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();

        $walls = $em->getRepository(Wall::class)->findBy([
            'user' => $user
         ]);

        return $this->render('wall/index.html.twig', ['walls' => $walls]);
    }
}
