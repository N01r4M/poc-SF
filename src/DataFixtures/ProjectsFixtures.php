<?php

namespace App\DataFixtures;

use App\Entity\Projects;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProjectsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $project = new Projects();

            $project->setName('project ' . $i);
            $project->setDescription(file_get_contents('http://loripsum.net/api/1/short'));
            $project->setCode($i);
            $project->setStartedAt(new DateTime());
            $project->setEndedAt(null);
            $project->setIsArchived(mt_rand(0, 1));
            $project->setTeamProject($this->getReference('team_' . mt_rand(0, 4)));
            $project->setTeamCustomers($this->getReference('team_' . mt_rand(0, 4)));
            $project->setStatus($this->getReference('status_' . mt_rand(0, 2)));
            $project->setPortfolio($this->getReference('portfolio_' . mt_rand(0, 2)));
            $project->setBudget($this->getReference('budget_' . $i));
            $project->addHighlight($this->getReference('highlight_' . $i));
            $project->addRisk($this->getReference('risk_' . $i));

            $manager->persist($project);
            $this->addReference('project_' . $i, $project);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TeamsFixtures::class,
            StatusFixtures::class,
            PortfoliosFixtures::class,
            BudgetsFixtures::class,
            HighlightsFixtures::class,
            RisksFixtures::class
        ];
    }
}
