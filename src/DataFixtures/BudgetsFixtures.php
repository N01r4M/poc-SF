<?php

namespace App\DataFixtures;

use App\Entity\Budgets;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BudgetsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $budget = new Budgets();

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

            $budget->setInitialValue(random_int(10000, 200000));
            $budget->setConsumedValue($consumed);
            $budget->setStillToDo($still);
            $budget->setLanding($landing);

            $manager->persist($budget);
            $this->addReference('budget_' . $i, $budget);
        }

        $manager->flush();
    }
}
