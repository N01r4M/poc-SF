<?php

namespace App\DataFixtures;

use App\Entity\Phases;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PhasesFixtures extends Fixture
{
    private array $names = ['Bilan', 'Cadrage', 'Finalisation', 'Intégration en production', 'Intégration en production', 'Intégration en recette', 'Lancement', 'Mise en production'];

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 8; $i++) {
            $phases = new Phases();

            $phases->setName($this->names[$i]);
            $phases->setValue($i);
            $phases->setSlug('phase_' . $i);
            $phases->setColor(sprintf('#%06X', mt_rand(0, 0xFFFFFF)));

            $manager->persist($phases);
            $this->addReference('phase_' . $i, $phases);
        }

        $manager->flush();
    }
}
