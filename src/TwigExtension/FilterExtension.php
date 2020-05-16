<?php

namespace App\TwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class FilterExtension
 */
class FilterExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('timeleft', [$this, 'timeLeft'])
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('timeleft', [$this, 'timeLeft']),
        ];
    }

    /**
     * @param DateTime $dateCreation
     * @return string
     */
    public function timeLeft($dateCreation)
    {
        if ($dateCreation) {
            $s = str_pad((new \DateTime('now'))->diff($dateCreation)->s, 2, STR_PAD_LEFT);
            $m = str_pad((new \DateTime('now'))->diff($dateCreation)->i, 2, STR_PAD_LEFT);
            $h = str_pad((new \DateTime('now'))->diff($dateCreation)->h, 2, STR_PAD_LEFT);
            $d = (new \DateTime('now'))->diff($dateCreation)->d;

            if ($d == 0 && $h == 0 && $m == 0 && $s > 0) {
                return 'il y a : ' . $s . ' seconde(s)';
            } elseif ($d == 0 && $h == 0 && $m > 0 && $s > 0) {
                return 'il y a : ' . $m . ':' . $s . ' minutes(s)';
            } elseif ($d == 0 && $h > 0 && $m > 0 && $s > 0) {
                return 'il y a : ' . $h . ':' . $m . ':' . $s . ' minutes(s)';
            } elseif ($d > 0 && $h > 0 && $m > 0 && $s > 0) {
                return 'Le ' . $d . ' jours à ' . $h . ':' . $m . ':' . $s . ' minutes(s)';
            }
        }

        return '';
    }
}
