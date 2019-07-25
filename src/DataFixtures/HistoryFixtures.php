<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use App\Entity\History;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class HistoryFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            ClientFixtures::class,
            AgencyFixtures::class,
            StageFixtures::class,
            StateHistoryFixtures::class
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<4; $i++) {
            $faker  =  Faker\Factory::create('fr_FR');
            $history = new History();
            $history->setDateEnd($faker->dateTime())
                ->setDateBegin($faker->dateTime())
                ->setState($this->getReference("state_".strval($i)))
                ->setClient($this->getReference("client_".strval($i)))
                ->setAgency($this->getReference("agency_".strval($i)))
                ->addStage($this->getReference("stage_".strval($i * 10 + 7)))
                ->addStage($this->getReference("stage_".strval($i * 10 + 8)))
                ->addStage($this->getReference("stage_".strval($i * 10 + 9)));

            $this->addReference('history_'.strval($i), $history);
            $manager->persist($history);
        };

        $manager->flush();
    }
}
