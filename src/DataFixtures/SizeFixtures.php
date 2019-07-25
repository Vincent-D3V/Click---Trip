<?php

namespace App\DataFixtures;

use App\Entity\Size;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SizeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $list=[
            'Solo',
            'En couple',
            'En famille',
            'Entre amis',
            'En Groupe'
        ];
        foreach ($list as $key => $name) {
            $size = new Size();
            $size->setPeople($name);
            $manager->persist($size);
            $this->addReference('size_'.$key, $size);
        };

        $manager->flush();
    }
}
