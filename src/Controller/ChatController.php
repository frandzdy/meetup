<?php

namespace App\Controller;

use App\Entity\Discussion;
use App\Entity\User;
use App\Service\ChatService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

/**
 * @Route("/chat")
 * Class ChatController
 * @package App\Controller
 */
class ChatController extends AbstractController
{
    /**
     * @var TokenStorageInterface
     */
    private $step = 5;
    private $limit = 5;
    private $max;


    /**
     * ChatController constructor.
     * @param TokenStorageInterface $storage
     */
    function __construct()
    {
    }

    /**
     * @Route("/", name="front_chat")
     */
    public function index(EntityManagerInterface $em)
    {
        $user = $em->getRepository(User::class)->findUser($this->getUser());

        return $this->render('chat/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/save_message/{discussion}/{token_id}", name="front_chat_save_message", options={"expose"=true}, methods={"POST"})
     */
    public function saveChatMessage(string $discussion, string $token_id, Request $request, ChatService $chatService, EntityManagerInterface $em)
    {
        if ($request->isXmlHttpRequest()) {

            $message = (string)$request->request->get('message');
            $user = $em->getRepository(User::class)->findOneBy(
                ['token' => $token_id]
            );
            $discussion = $em->getRepository(Discussion::class)->findOneBy(
                ['token' => $discussion]
            );
            if ($res = $chatService->saveMessage($discussion, $message, $user)) {
                $tokenUsers = [];
                foreach ($discussion->getUsers() as $dUser) {
                    $tokenUsers[] = $dUser->getToken();
                }

                return new JsonResponse([
                    'success' => $res, 'resultat' => [
                        'groupId' => $discussion->getToken(),
                        'groupUsers' => $tokenUsers,
                        'message' => $res->getMessage(),
                        'created_at' => $res->getCreatedAt(),
                        'id' => $user->getToken(),
                        'lastname' => $user->getFirstname(),
                        'firstname' => $user->getLastname(),
                        'email' => $user->getEmail(),
                        'avatar' => $this->getParameter('uploads_directory')."/" .$user->getAvatar(),
                        'token' => $user->getToken(),
                    ]
                ], 200);
            }
        }

        return new JsonResponse(['success' => false], 500);

    }

    /**
     * @Route("/load_message", name="front_load_message", options={"expose"=true}, methods={"POST"})
     */
    public function loadMessage(Request $request, ChatService $chatService)
    {
        if ($request->isXmlHttpRequest()) {
            $groupeSearching = (string)$request->request->get('groupe') ?: 0;
            $step = (int)$request->request->get('step') ?: 5;
            $order = (int)$request->request->get('order') ?: 0;

            if ($res = $chatService->getDiscussion($groupeSearching, $this->getUser(), $step, $order)) {

                return new JsonResponse(['success' => true, 'resultat' => $res['res'], 'groupeId' => $res['groupeId']], 200);
            }
        }

        return new JsonResponse(['success' => false], 500);
    }
}
