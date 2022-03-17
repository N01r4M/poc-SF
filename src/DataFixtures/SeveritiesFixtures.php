<?php

namespace App\DataFixtures;

use App\Entity\Severities;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SeveritiesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $severity = new Severities();

            $severity->setName('Severity ' . $i);

            $manager->persist($severity);
            $this->addReference('severity_' . $i, $severity);
        }

        $manager->flush();
    }
}
