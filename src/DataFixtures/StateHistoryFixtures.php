<?php

namespace App\DataFixtures;

use App\Entity\StateHistory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class StateHistoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $states=[
            'Attente admin',
            'Accepté par admin',
            'Refusé par admin',
            'Refusé par agence',
            'Attente paiement',
            'Payé',
            'Voyage effectué'
        ];
        foreach ($states as $key => $value) {
            $newState=new StateHistory();
            $newState->setState($value);
            $manager->persist($newState);
            $this->addReference('state_'.strval($key), $newState);
        }
        $manager->flush();
    }
}
