<?php
/**
 * Created by PhpStorm.
 * User: fsanon
 * Date: 01/10/2018
 * Time: 09:32
 */

namespace App\Message;

use App\Entity\Person;

class Inscription
{
    private $person;

    public function __construct(Person $person)
    {
        $this->person = $person;

    }

    /**
     * @return mixed
     */
    public function getPerson()
    {
        return $this->person;
    }

}