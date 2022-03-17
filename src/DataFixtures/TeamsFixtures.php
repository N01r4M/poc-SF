<?php

namespace App\DataFixtures;

use App\Entity\Teams;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeamsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $team = new Teams();
        $team->setName('Team 0');
        $team->setParentTeam(null);
        $manager->persist($team);
        $this->addReference('team_0', $team);

        $team = new Teams();
        $team->setName('Team 1');
        $team->setParentTeam(null);
        $manager->persist($team);
        $this->addReference('team_1', $team);

        $team = new Teams();
        $team->setName('Team 2');
        $team->setParentTeam(null);
        $manager->persist($team);
        $this->addReference('team_2', $team);

        $team = new Teams();
        $team->setName('Team 3');
        $team->setParentTeam(null);
        $manager->persist($team);
        $this->addReference('team_3', $team);

        $team = new Teams();
        $team->setName('Team 4');
        $team->setParentTeam(null);
        $manager->persist($team);
        $this->addReference('team_4', $team);

        $manager->flush();
    }
}
