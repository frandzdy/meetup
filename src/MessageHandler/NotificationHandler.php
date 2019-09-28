<?php
/**
 * Created by PhpStorm.
 * User: fsanon
 * Date: 01/10/2018
 * Time: 09:33
 */

namespace App\MessageHandler;


use App\Message\Notification;

class NotificationHandler
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(Notification $notification)
    {
        foreach ($notification->getDestinataires() as $destinataire) {
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('send@example.com')
                ->setTo($destinataire)
                ->setBody(
                    sprintf('Notification :<h1>%s</h1>', $notification->getMessage()),
                    'text/html'
                )
                // If you also want to include a plaintext version of the message
                ->addPart(
                   sprintf('Notification : %s', $notification->getMessage()),
                    'text/plain'
                )
            ;

            $this->mailer->send($message);
            dump(sprintf('Envoi de notification à [%s], envoyé ? : %d', $notification->getMessage(), $this->mailer->send($message)));
        }


    }
}