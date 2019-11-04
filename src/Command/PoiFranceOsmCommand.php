<?php

namespace App\Command;


use App\Entity\RefEquipement;
use App\Entity\RefInstallation;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PoiFranceOsmCommand extends Command
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
            ->setName('meet:poi-update')
            ->setDescription('Importation des données issue de la base de données Opensteetmap');
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

        $string = \file_get_contents("/var/www/tennis/res/poi.json");
        $json_a = \json_decode($string,true);
echo '<pre>';
dump($json_a);
echo '</pre>';
echo 'Methode : '.__METHOD__.' Ligne : '.__LINE__;
die;
        foreach ($json_a as $key => $value){
            echo  $key . ':' . $value;
        }
        die;




        if (($handle = fopen("/var/www/tennis/res/poi.json", "r")) !== FALSE) {
            $connection = $this->em->getConnection();
            $connection->beginTransaction();
            $output->writeln('Nettoyage de la base de données');
            try {
                $connection->query('SET FOREIGN_KEY_CHECKS=0');
                $connection->query('TRUNCATE TABLE sm_ref_equipement');
                $connection->query('ALTER TABLE sm_ref_equipement AUTO_INCREMENT=1');
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
            $connection->beginTransaction();
            while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                if ($row == 1) {
                    $row++;
                    continue;
                }

                if (!empty($data[4])) {
                    $refEquipement = (new RefEquipement())
                        ->setName($data[5])
                        ->setNameEquipement($data[7])
                        ->setNbEquipement($data[9])
                        ->setTypeEquipement($data[11])
                        ->setGestionnairePrincipal($data[12])
                        ->setProprietairePrincipal($data[13])
                        ->setGestionnaireSecond($data[14])
                        ->setProprietaireSecond($data[15])
                        ->setNatureSol((int)$data[35])
                        ->setInterieur((int)$data[36])
                        ->setNbCouloir((int)$data[42])
                        ->setNbVestiaire((int)$data[43])
                        ->setHasAccessHandi((int)$data[69])
                        ->setGpsX($data[195])
                        ->setGpsY($data[196])
                        ->setEventInstallation($this->em->getRepository(RefInstallation::class)->findOneBy(['idInstallation' => (string)$data[4]]))
                    ;
                    $output->writeln('Insertion en base de : ' . $this->removeEmoji($data[5]));
                    $this->em->persist($refEquipement);
                }
                $row++;
            }
            try{
                $this->em->flush();
                $this->em->getConnection()->commit();
            } catch (\Exception $exception) {
                $this->em->getConnection()->rollBack();
            }
            fclose($handle);
        }
        echo 'Methode : ' . __METHOD__ . ' Ligne : ' . __LINE__;
        die;
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
