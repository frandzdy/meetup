<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact")
 * Class ContactController
 * @package App\Controller
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="sm_front_contact", methods={"GET"})
     */
    public function contact(Request $request, EntityManagerInterface $em)
    {
        $contactQuery = $em->getRepository(User::class)->getContact($this->getUser());

        return $this->render('contact/index.html.twig',
            [
                'contacts' => []
            ]
        );
    }
}
