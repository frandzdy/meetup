<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homes")
     */
    public function index(EntityManagerInterface $em)
    {
        $user = $this->getUser();

        return $this->render('home/index.html.twig', [
            'user' => $user ? $user : [],
        ]);
    }

}
