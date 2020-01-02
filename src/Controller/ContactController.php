<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact", name="front_contact")
 *
 * Class ContactController
 * @package App\Controller
 */
class ContactController extends AbstractController
{
    /**
     * @Route("", name="_index", methods={"GET"})
     * @Template()
     */
    public function index(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $contactQuery = $em->getRepository(User::class)->getContact($this->getUser());

        $pagination = $paginator->paginate(
            $contactQuery, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return [
            'contacts' => $pagination ?? []
        ];
    }
}
