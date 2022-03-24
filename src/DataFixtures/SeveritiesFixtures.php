<?php

namespace App\DataFixtures;

use App\Entity\Severities;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SeveritiesFixtures extends Fixture
{
    private array $names = ['Insignifiant', 'Mineur', 'Modéré', 'Majeur'];

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 4; $i++) {
            $severity = new Severities();

            $severity->setName($this->names[$i]);

            $manager->persist($severity);
            $this->addReference('severity_' . $i, $severity);
        }

        $manager->flush();
    }
}
