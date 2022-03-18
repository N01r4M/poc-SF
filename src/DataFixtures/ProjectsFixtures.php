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

            $initial = random_int(10000, 200000);
            $consumed = 200001;
            $still = 200001;

            while ($consumed > $initial) {
                $consumed = random_int(0, 200000);
            }

            while ($still > $initial) {
                $still = random_int(0, 150000);
            }

            $landing = $consumed + $still;

            $project->setName('project ' . $i);
            $project->setDescription(simplexml_load_file('http://www.lipsum.com/feed/xml?amount=1&what=paras&start=0')->lipsum);
            $project->setCode($i);
            $project->setStartedAt(new DateTime());
            $project->setEndedAt(null);
            $project->setIsArchived(mt_rand(0, 1));
            $project->setInitialValue(random_int(10000, 200000));
            $project->setConsumedValue($consumed);
            $project->setStillToDo($still);
            $project->setLanding($landing);
            $project->setTeamProject($this->getReference('team_' . mt_rand(0, 4)));
            $project->setTeamCustomers($this->getReference('team_' . mt_rand(0, 4)));
            $project->setStatus($this->getReference('status_' . mt_rand(0, 2)));
            $project->setPortfolio($this->getReference('portfolio_' . mt_rand(0, 2)));
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
            HighlightsFixtures::class,
            RisksFixtures::class
        ];
    }
}
