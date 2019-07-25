<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Agency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AgencyFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        // Make agency accounts
        for ($i=1; $i<12; $i++) {
            $faker  =  Faker\Factory::create('fr_FR');
            $agency = new Agency();
            $agency->setAddress($faker->address())
                   ->setCity($faker->city())
                   ->setCompany($faker->company())
                   ->setCountry($faker->country())
                   ->setNameAgent($faker->firstNameMale())
                   ->setSurnameAgent($faker->lastname())
                   ->setYearCreation(2000+$i)
                   ->setDescription($faker->sentence(40))
                   ->setFlagship($faker->sentence(10))
                   ->setPresentation($faker->sentence(25))
                    ->setEmail($faker->freeEmail())
                    ->setPassword($this->passwordEncoder->encodePassword(
                        $agency,
                        'agencemdp'
                    ))
                    ->setRoles(['ROLE_AGENCY'])
                    ->setMobile($faker->phoneNumber());
            $image='agent-'.strval($i).'.jpg';
            if ($i==11) {
                copy(
                    __DIR__.'/../../assets/fixturesImages/'.$image,
                    __DIR__.'/../../assets/fixturesImages/agent-'.strval($i-10).'.jpg'
                );
                rename(
                    __DIR__.'/../../assets/fixturesImages/agent-12.jpg',
                    __DIR__.'/../../assets/fixturesImages/agent-2.jpg'
                );
            } else {
                copy(
                    __DIR__.'/../../assets/fixturesImages/'.$image,
                    __DIR__.'/../../assets/fixturesImages/agent-'.strval($i+2).'.jpg'
                );
            }
            $file = new UploadedFile(
                __DIR__.'/../../assets/fixturesImages/'.$image,
                $image,
                'image/jpg',
                null,
                null,
                true /*  Set test mode true !!!
                " Local files are used in test mode hence
                the code should not enforce HTTP uploads." */
            );
            $agency->setImageFile($file);
            $manager->persist($agency);
            $this->addReference('agency_'.strval($i), $agency);
        }
        $manager->flush();
    }
}
