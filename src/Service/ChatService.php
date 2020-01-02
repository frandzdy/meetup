<?php


namespace App\Service;


use App\Entity\Discussion;
use App\Entity\Message;
use App\Entity\RefTypeGroupe;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;

class ChatService
{
    /**
     * ChatService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Discussion $discussion
     * @param String $message
     * @param User $from
     * @return Message|null
     */
    public function saveMessage(Discussion $discussion, String $message, User $from): ?Message
    {
        try {
            $msg = (new Message())
                ->setMessage($message)
                ->setSender($from)
                ->setCreatedAt((new \DateTime('now')))
                ->setDiscussion($discussion);
            $this->em->persist($msg);
            $this->em->flush();

            return $msg;
        } catch (\Exception $exception) {

            return null;
        }

    }

    /**
     * @param string $userSearchingToken
     * @param User $me
     * @return array
     */
    public function getDiscussion(string $groupeSearchingToken, User $me, int $step, int $order)
    {
        $groupe = $this->em->getRepository(Discussion::class)->findOneBy(
            ['token' => $groupeSearchingToken]
        );
        if ($groupe) {
            return [
                'res' => $this->em->getRepository(Message::class)->getAllMessageFromGroupe(
                    $groupe,
                    $step,
                    $order),
                'groupeId' => $groupe->getToken()
            ];
        }

        return ['res' => [], 'groupeId' => null];
    }
}
