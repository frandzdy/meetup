<?php
/**
 * Created by PhpStorm.
 * User: fsanon
 * Date: 01/10/2018
 * Time: 09:32
 */

namespace App\Message;


class Notification
{
    private $message;
    private $destinataire;

    public function __construct(?String $message, ?String $destinataire)
    {
        $this->message = $message;
        $this->destinataire = $destinataire;
    }

    /**
     * @return String
     */
    public function getMessage(): String
    {
        return $this->message;
    }
    /**
     * @return array
     */
    public function getDestinataire(): String
    {
        return $this->destinataire;
    }
}
