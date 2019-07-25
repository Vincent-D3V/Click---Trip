<?php

namespace App\DataFixtures;

use App\Entity\Style;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class StyleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $list=[
            'Standard',
            "Chez l’habitant",
            "Charme",
            "Luxe",
            "Responsable"
        ];
        foreach ($list as $key => $name) {
            $style = new Style();
            $style->setStyle($name);
            $manager->persist($style);
            $this->addReference('style_'.$key, $style);
        };

        $manager->flush();
    }
}
