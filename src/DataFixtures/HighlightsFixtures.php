<?php

namespace App\DataFixtures;

use App\Entity\Highlights;
use App\DataFixtures\BearingsFixtures;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class HighlightsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $highlight = new Highlights();

            $highlight->setCreatedAt(new DateTime());
            $highlight->setName('Highlight ' . $i);
            $highlight->setDescription(simplexml_load_file('http://www.lipsum.com/feed/xml?amount=1&what=paras&start=0')->lipsum);
            $highlight->setBearing($this->getReference('bearing_' . random_int(0, 4)));

            $manager->persist($highlight);
            $this->addReference('highlight_' . $i, $highlight);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            BearingsFixtures::class
        ];
    }
}
