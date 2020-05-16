<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait TraitDate
 * @package App\Entity
 */
trait TraitFiltre
{
    /**
     * @return string
     */
    public function timeLeft()
    {
        $s = str_pad((new \DateTime('now'))->diff($this->createdAt)->s, 2, '0',STR_PAD_LEFT);
        $m = str_pad((new \DateTime('now'))->diff($this->createdAt)->i, 2, '0',STR_PAD_LEFT);
        $h = str_pad((new \DateTime('now'))->diff($this->createdAt)->h, 2, '0',STR_PAD_LEFT);
        $d = (new \DateTime('now'))->diff($this->createdAt)->d;
        $str = 'il y a : ' . $h . ':' . $m . ':' . $s;
        if ($d > 0 && $h > 0 && $m > 0 && $s > 0) {
            return 'Le ' . $this->createdAt->format('d-m-Y h:i:s');
        } else {
           return $str;
        }
    }
}
