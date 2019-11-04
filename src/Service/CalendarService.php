<?php


namespace App\Service;


use App\Entity\Events;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;

class CalendarService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * CalendarService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, Filesystem $filesystem, $uploadDirectory)
    {
        $this->em = $em;
        $this->filesystem = $filesystem;
        $this->uploadDirectory = $filesystem;
    }

    /**
     * @param Events $event
     */
    public function createIosCalendar(Events $event)
    {
        //Evenèment au format ICS
        $timeTrigger = $event->getStartDate()->modify('-1 hours');
        $ics = "BEGIN:VCALENDAR\n";
        $ics .= "VERSION:2.0\n";
        $ics .= "PRODID:-//hacksw/handcal//NONSGML v1.0//EN\n";
        $ics .= "BEGIN:VEVENT\n";
        $ics .= "X-WR-TIMEZONE:Europe/Paris\n";
        $ics .= "DTSTART:" . $event->getStartDate()->format('Ymd') . "T" . $event->getStartDate()->format('His') . "\n";
        $ics .= "DTEND:" . $event->getEndDate()->format('Ymd') . "T" . $event->getEndDate()->format('His') . "\n";
        $ics .= "SUMMARY:" . $event->getTitle() . "\n";
        $ics .= "LOCATION:" . $event->getEventsPlace()->getEventInstallation()->getAddress() . "\n";
        $ics .= "DESCRIPTION:" . $event->getEventsPlace()->getNameEquipement() . ' ' . $event->getEventsPlace()->getTypeEquipement() . "\n";
        $ics .= "BEGIN:VALARM";
        $ics .= "ACTION:AUDIO";
        $ics .= "TRIGGER:" . $event->getStartDate()->format('Ymd') . "T" . $timeTrigger->format('Ymd');
        $ics .= "ATTACH;FMTTYPE=audio/basic:http://host.com/pub/audio-files/ssbanner.aud";
        $ics .= "REPEAT:4";
        $ics .= "DURATION:PT1H";
        $ics .= "END:VALARM";
        $ics .= "END:VEVENT\n";
        $ics .= "END:VCALENDAR\n";

        $fichier = $event->getId().'_' . $event->getTitle() . '.ics';
        $f = fopen($fichier, 'w+');
        file_put_contents($f, $ics);
    }

    /**
     * @param Events $event
     */
    public function createAndroidCalendar(Events $event)
    {

    }
}
