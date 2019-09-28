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
    private $destinataires;

    public function __construct(String $message = '', array $destinataires = [])
    {
        $this->message = $message;
        $this->destinataires = $destinataires;
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
    public function getDestinataires(): array
    {
        return $this->destinataires;
    }
}