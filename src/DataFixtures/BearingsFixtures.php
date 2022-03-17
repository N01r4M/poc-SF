<?php

namespace App\DataFixtures;

use App\Entity\Bearings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BearingsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $bearing = new Bearings();

            $bearing->setName('Bearing ' . $i);
            $bearing->setValue($i);
            $bearing->setIsMandatory(random_int(0, 1));

            $manager->persist($bearing);
            $this->addReference('bearing_' . $i, $bearing);
        }

        $manager->flush();
    }
}
