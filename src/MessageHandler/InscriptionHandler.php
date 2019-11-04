<?php
/**
 * Created by PhpStorm.
 * User: fsanon
 * Date: 01/10/2018
 * Time: 09:33
 */

namespace App\MessageHandler;


use App\Message\Inscription;
use App\Message\Notification;
use App\Service\MailerService;

class InscriptionHandler
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var \Twig\Template
     */
    private $template;
    /**
     * @var MailerService
     */
    private $mailerService;

    public function __construct(\Swift_Mailer $mailer, $template, \Twig\Environment $twig, MailerService $mailerService)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->mailerService = $mailerService;
    }

    public function __invoke(Notification $notification)
    {
        $destinataire = $notification->getDestinataire();
        $context = ['message' => $notification->getMessage(), 'subject' => 'inscription :)'];
        $res = $this->mailerService->sendEmail($destinataire,'emails/inscription.html.twig', $context);
        dump(sprintf('Envoi de notification à [%s], envoyé : %d', $destinataire, $res));
    }
}
