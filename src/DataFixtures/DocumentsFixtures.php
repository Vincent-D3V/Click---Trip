<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Documents;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
// use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DocumentsFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies(): array
    {
        return [StageFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i=0; $i<105; $i++) {
            for ($j=4*$i; $j<4*($i+1); $j++) {
                $documents= new Documents();
                $image='pexels-photo-'.strval($j).'.jpeg';
                if ($i==104) {
                    copy(
                        __DIR__.'/../../assets/fixturesImages/'.$image,
                        __DIR__.'/../../assets/fixturesImages/pexels-photo-'.strval($j-4*$i).'.jpeg'
                    );
                } else {
                    copy(
                        __DIR__.'/../../assets/fixturesImages/'.$image,
                        __DIR__.'/../../assets/fixturesImages/pexels-photo-'.strval($j+5).'.jpeg'
                    );
                }
                $file = new UploadedFile(
                    __DIR__.'/../../assets/fixturesImages/'.$image,
                    $image,
                    'image/jpeg',
                    null,
                    null,
                    true /*  Set test mode true !!!
                    " Local files are used in test mode hence
                    the code should not enforce HTTP uploads." */
                );
                $documents
                            ->setImageFile($file)
                            ->setStage($this->getReference('stage_'.strval($i)));
                $manager->persist($documents);
            }
        }
        rename(
            __DIR__.'/../../assets/fixturesImages/pexels-photo-420.jpeg',
            __DIR__.'/../../assets/fixturesImages/pexels-photo-4.jpeg'
        );
        $manager->flush();
    }
}
