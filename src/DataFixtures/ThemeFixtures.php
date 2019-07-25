<?php

namespace App\DataFixtures;

use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ThemeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $list=[
            'Culture & Traditions',
            'Sport & aventure',
            'Bien être & Spiritualité',
            'Nature & Vie sauvage',
            'Fêtes et Festivals',
            'Iles & Plages de rêves',
            'Responsable'
        ];
        foreach ($list as $key => $name) {
            $theme = new Theme();
            $theme->setTheme($name);
            $manager->persist($theme);
            $this->addReference('theme_'.$key, $theme);
        };

        $manager->flush();
    }
}
