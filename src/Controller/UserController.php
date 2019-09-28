<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    function logoutAction()
    {
        return $this->redirect($this->generateUrl('fos_user_security_logout'));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="inscription", name="front_create_person")
     */
    function create(Request $request, TranslatorInterface $translator)
    {
        // On crée un objet Advert
        $user = new User();
        $options['validation_groups'] = 'create';
        // On crée le FormBuilder grâce au service form factory
        $form = $this->createForm(UserType::class, $user, $options);
        // on vérifie que le formulaire est valide
        if ($form->handleRequest($request) && $form->isSubmitted()) {
            if ($form->isValid()) {
                // on enregistre l'image
                // $user->getImage()->upload();
                // on appel notre manager pour enregistrer car new Advert
                $em = $this->getDoctrine()->getManager();
                $password = $form->get('password')->getData();

                // on persist l'annonce
                $user->setRoles(array('ROLE_USER'))->setPlainPassword($password)
                    ->setEnabled(true);

                $em->persist($user);
                // on enregistre
                $em->flush();
                // message pour la vue de retour
                $request->getSession()->getFlashBag()->add('notice', 'Création du compte bien enregistré.');
                // redirection vers la vue de l'annonce en récupérant l'id de l'advert Créer
                return $this->redirect($this->generateUrl('fos_user_security_login'));
            }
        }

        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('user/compte.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response|\Symfony\Component\Security\Core\Exception\AccessDeniedException
     *
     * @Route("person/edit/{id}", name="front_edit_person")
     */
    function editCompte($id, Request $request, EntityManagerInterface $entityManager)
    {
        // On crée un objet User
        $userManager = $entityManager;

        if ($this->getUser()->getId() != $id and !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createNotFoundException('fiche non accessible');
        }

        $user = $userManager->getRepository(User::class)->findOneBy(array('id' => $id));
        $options['validation_groups'] = 'edit';
        // On crée le FormBuilder grâce au service form factory
        $form = $this->createForm(UserType::class, $user, $options);
        // on récupère le mot de passe du l'utilisateur
        $password = $user->getPassword();

        // on vérifie que le submit est valide
        $form->handleRequest($request);
        // on vérifie que le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('password')->getData();
            // on enregistre
            if (!empty($newPassword)) {
                // set plain permet de crypter le nouveau mot de passe
                $user->setPlainPassword($form->get('password')->getData());
            } else {
                // setPassword va concerver le mot de passe crypter déjà existant
                $user->setPassword($password);
            }
            $user->setRoles(array('ROLE_USER'));
//            $userManager->updateUser($user);
            $userManager->flush();
            // message pour la vue de retour
            $request->getSession()->getFlashBag()->add('notice', 'Modification du compte bien enregistré.');
            // redirection vers la vue de l'annonce en récupérant l'id de l'advert Créer
            return $this->redirect($this->generateUrl('front_edit_person', array('id' => $user->getId())));
        }
        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('user/compte.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

//    /**
//     * @param $id
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse
//     * @Route('person/delete", name="imw_person_delete")
//     */
//    function deleteCompte($id, Request $request, EntityManager $entityManager)
//    {
//        // On crée un objet User
//        $userManager = $entityManager;
//        $user = $userManager->findUserBy(array('id' => $id));
//        // on vérifie que le formulaire est valide
//        if ($request->isMethod("GET")) {
//            $userManager->remove($user);
//            $request->getSession()->getFlashBag()->add('notice', 'Suppression du compte bien enregistré.');
//
//            return $this->redirect($this->generateUrl('oc_platform_home'));
//        }
//        // return $this -> redirect($this->generateUrl('oc_platform_editUser',array('id'=>$user -> getId())));
//    }
}
