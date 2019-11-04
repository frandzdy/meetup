<?php

namespace App\Command;


use App\Entity\RefInstallation;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResInstallationCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ResCommand constructor.
     * @param string|null $name
     */
    public function __construct(string $name = null, EntityManagerInterface $em)
    {
        parent::__construct($name);
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setName('meet:res-installation')
            ->setDescription('Mise à jour des installations de terrains de sports');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Mise à jour des terrains de sports');

//        $file = file_get_contents('https://www.data.gouv.fr/fr/datasets/r/c3ab5533-d93c-486a-879a-a30659029f73');
//        file_put_contents('/var/www/tennis/res/import/import.zip', $file);
//        $zip = new \ZipArchive();
//        $output->writeln('Ouverture du fichier zip');
//        if ($zip->open('/var/www/tennis/res/import/import.zip') === TRUE) {
//            $output->writeln('Extraction du fichier zip');
//            $zip->extractTo('/var/www/tennis/res/');
//            $filename = $zip->getNameIndex(0);
//            $zip->close();
//        }
        $row = 1;
        $output->writeln('Overture du fichier dans le zip');
        if (($handle = fopen("/var/www/tennis/res/20180110_RES_FichesInstallations.csv", "r")) !== FALSE) {
            $connection = $this->em->getConnection();
            $connection->beginTransaction();
            $output->writeln('Nettoyage de la base de données');
            try {
                $connection->query('SET FOREIGN_KEY_CHECKS=0');
                $connection->query('TRUNCATE TABLE sm_ref_installation');
                $connection->query('ALTER TABLE sm_ref_installation AUTO_INCREMENT=1');
                $connection->query('SET FOREIGN_KEY_CHECKS=1');
                $connection->commit();
                $this->em->flush();
            } catch (\Exception $e) {
                try {
                    fwrite(STDERR, print_r('Can\'t truncate table sm_event_place. Reason: ' . $e->getMessage(), TRUE));
                    $connection->rollback();
                    return false;
                } catch (ConnectionException $connectionException) {
                    fwrite(STDERR, print_r('Can\'t rollback truncating table sm_event_place. Reason: ' . $connectionException->getMessage(), TRUE));
                    return false;
                }
            }
            $output->writeln('Début insertion des informations du fichier en base');
            $this->em->getConnection()->beginTransaction();
            while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                if ($row == 1) {
                    $row++;
                    continue;
                }

                if (!empty((string)$data[4])) {
                    if (!empty($data[6]) && !empty($data[7])) {
                        $adresse = $data[6] . ' ' . $data[7];
                    } elseif (empty($data[6]) && !empty($data[7])) {
                        $adresse = $data[7];
                    } elseif (!empty($data[6]) && empty($data[7])) {
                        $adresse = $data[6];
                    } else {
                        $adresse = '';
                    }

                    $eventInstallation = (new RefInstallation())
                        ->setIdInstallation((string)$data[4])
                        ->setName($this->removeEmoji($data[5]))
                        ->setAddress($adresse)
                        ->setAddressComplement($this->removeEmoji($data[8]))
                        ->setCodePostal(strlen($data[9]) == 4 ? (string)'0'.$data[9] : (int)$data[9])
                        ->setCity((string)$data[3])
                        ->setNbPlaceParking((int)$data[19])
                        ->setNbPlaceParkingHandi((int)$data[20]);

                    $output->writeln('Insertion en base de : ' . $this->removeEmoji($data[5]));
                    $this->em->persist($eventInstallation);
                }
                $row++;
            }
            try{
                $this->em->flush();
                $this->em->getConnection()->commit();
            } catch (\Exception $exception) {
                $this->em->getConnection()->rollBack();
                echo '<pre>';
                dump($exception->getMessage());
                echo '</pre>';
                echo 'Methode : '.__METHOD__.' Ligne : '.__LINE__;
                die;
            }
            fclose($handle);
        }
        $output->writeln('Fin de l\'importation');
    }

    /**
     * Fonction qui permet de retirer les emojis d'une chaine
     *
     * @param $text
     * @return string|string[]|null
     *
     * @@author Sanon Frandzdy <fsanon@webnet.fr>
     */
    function removeEmoji($text)
    {
        $cleanText = "";

        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $cleanText = preg_replace($regexEmoticons, '', $text);

        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $cleanText = preg_replace($regexSymbols, '', $cleanText);

        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $cleanText = preg_replace($regexTransport, '', $cleanText);

        return $cleanText;
    }
}
