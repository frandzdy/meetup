<?php

namespace App\DataFixtures;

use App\Entity\RefCivilite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCivilite extends Fixture
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        // Liste des noms de catégorie à ajouter
        $names = array(
            'Monsieur',
            'Madame',
            'Mademoiselle',
            'les deux'
        );

        foreach ($names as $name) {
            // On crée la catégorie
            $civilite = new RefCivilite();
            $civilite->setCivilite($name);

            // On la persiste
            $manager->persist($civilite);
        }

        // On déclenche l'enregistrement de toutes les catégories
        $manager->flush();
    }

    /**
     * @return int
     */

}
