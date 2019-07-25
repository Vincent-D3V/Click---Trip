<?php

namespace App\DataFixtures;

use App\Entity\Price;
use App\Repository\StageRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use DateTime;

class PriceFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [StageFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        /* /!\ I had just put one price by stage instead of multiple for each specs (persons, season,...)
        which is the default price, so on the whole year*/
        for ($i=0; $i<105; $i++) {
            $price = new Price();
            $price->setStage($this->getReference('stage_'.strval($i)))
                  ->setPrice(200+(-1)**($i)*($i%14)*(1.3)**($i%8));
            $manager->persist($price);
        };
        $manager->flush();
    }
}
