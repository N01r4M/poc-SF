<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $status = new Status();
        $status->setName('A commencer');
        $status->setValue(1);
        $status->setSlug('to_start');
        $status->setColor('#DE1D1D');
        $manager->persist($status);
        $this->addReference('status_0', $status);
        
        $status = new Status();
        $status->setName('En cours');
        $status->setValue(2);
        $status->setSlug('running');
        $status->setColor('#DE7D1D');
        $manager->persist($status);
        $this->addReference('status_1', $status);
        
        $status = new Status();
        $status->setName('Terminé');
        $status->setValue(2);
        $status->setSlug('finished');
        $status->setColor('#32A852');
        $manager->persist($status);
        $this->addReference('status_2', $status);

        $manager->flush();
    }
}
