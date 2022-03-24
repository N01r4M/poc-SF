<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    private array $names = ['Abandonné', 'Absences', 'En cours', 'Gelé', 'Prévu', 'Terminé'];

    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 6; $i++) {
            $status = new Status();

            $status->setName($this->names[$i]);
            $status->setValue($i);
            $status->setSlug('status_' . $i);
            $status->setColor(sprintf('#%06X', mt_rand(0, 0xFFFFFF)));

            $manager->persist($status);
            $this->addReference('status_' . $i, $status);
        }

        $manager->flush();
    }
}
