<?php
/**
 * Created by PhpStorm.
 * User: fsanon
 * Date: 01/10/2018
 * Time: 09:33
 */

namespace App\MessageHandler;


use App\Message\Inscription;

class InscriptionHandler
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(Inscription $inscription)
    {
        $inscription->getPerson()->getNom();
         dump(sprintf('Cette personne s\'est inscrit'));
    }
}