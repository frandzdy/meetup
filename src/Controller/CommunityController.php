<?php

namespace App\Controller;

use App\Entity\Communaute;
use App\Entity\Events;
use App\Entity\RefEquipement;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

/**
 * @Route("/communauté", name="front_community")
 *
 * Class CommunityController
 * @package App\Controller
 */
class CommunityController extends AbstractController
{
    /**
     * @Route("", name="_index")
     * @Template()
     */
    public function index(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        $user = $this->getUser();
        $communities = $em->getRepository(Communaute::class)->getCommunity($user->getId());

        return [
            'communities' => $communities ?? [],
            'user' => $user ?? [],
        ];
    }

    /**
     * @Route("/{id}/show", name="_show", requirements={"id"="\d+"}, methods={"GET"})
     * @Template()
     *
     * @param Communaute $community
     * @return array
     */
    public function show(Communaute $community): array
    {
        return [
            'community' => $community,
        ];
    }

    /**
     * @Route("/{id}/edit", name="_edit", requirements={"id"="\d+"}, methods={"GET", "POST"})
     * @Template()
     */
    public function edit(Request $request, Communaute $community, EntityManagerInterface $em): array
    {
        $form = $this->createForm(EventType::class, $community);
        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
//            $refEquipement = $em->getRepository(RefEquipement::class)->findOneBy(
//                [
//                    'id' => $event->getEventsPlace()
//                ]
//            );
//            $event->setEventsPlace($refEquipement);
//            $em->flush();
//
//            return $this->redirectToRoute('event_index');
//        }

        return [
            'community' => $community,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/{id}/delete", name="_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete(Request $request, Communaute $community, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $community->getId(), $request->request->get('_token'))) {
            $em->remove($community);
            $em->flush();
        }

        return $this->redirectToRoute('front_community_index');
    }

}
