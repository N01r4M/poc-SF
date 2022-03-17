<?php

namespace App\DataFixtures;

use App\Entity\Portfolios;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PortfoliosFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $portfolio = new Portfolios();
        $portfolio->setName('portfolio 0');
        $portfolio->setManager($this->getReference('user_0'));
        $manager->persist($portfolio);
        $this->addReference('portfolio_0', $portfolio);

        $portfolio = new Portfolios();
        $portfolio->setName('portfolio 1');
        $portfolio->setManager($this->getReference('user_3'));
        $manager->persist($portfolio);
        $this->addReference('portfolio_1', $portfolio);

        $portfolio = new Portfolios();
        $portfolio->setName('portfolio 2');
        $portfolio->setManager($this->getReference('user_6'));
        $manager->persist($portfolio);
        $this->addReference('portfolio_2', $portfolio);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class
        ];
    }
}
