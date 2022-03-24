<?php

namespace App\DataFixtures;

use App\Entity\Risks;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RisksFixtures extends Fixture implements DependentFixtureInterface
{
    private array $namesProba = ['Très peu probable', 'Peu probable', 'Probable', 'Très probable'];

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $risk = new Risks();

            $risk->setName('Risk ' . $i);
            $risk->setIdentifiedAt(new DateTime());
            $risk->setResolvedAt(null);
            $risk->setProbability($this->namesProba[random_int(0, 3)]);
            $risk->setSeverity($this->getReference('severity_' . random_int(0, 3)));

            $manager->persist($risk);
            $this->addReference('risk_' . $i, $risk);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeveritiesFixtures::class
        ];
    }
}
