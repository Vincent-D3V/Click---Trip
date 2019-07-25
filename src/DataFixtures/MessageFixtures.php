<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Message;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            SizeFixtures::class,
            StyleFixtures::class,
            ThemeFixtures::class,
            ClientFixtures::class,
            HistoryFixtures::class
        ];
    }
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 400; $i++) {
            $faker = Factory::create('fr_FR');
            $message = new Message();
            $type=['client', 'agency'];
            $rand=rand(0, 1);
            $history=$this->getReference("history_".strval(rand(1, 3)));
            $message->setSendAt($faker->dateTime())
                    ->setHistories($history)
                    ->setClient($this->getReference('client_'.rand(1, 4)))
                    ->setAgency($history->getAgency());
            if ($i%7==0) {
                $sender = $rand>0?'user':$type[array_rand($type)];
                $receiver = $rand>0?$type[array_rand($type)]:'user';
                $message->setAdmin(true)
                        ->setSender($sender)
                        ->setReceiver($receiver)
                        ->setContent('message in Admin conv, sent by:'.$sender.' to:'.$receiver);
            } else {
                $message->setSender($type[$rand])
                        ->setReceiver($type[abs($rand-1)])
                        ->setContent('message not for admin number: '.strval($i));
            }
            $manager->persist($message);
        }
        $manager->flush();
    }
}
