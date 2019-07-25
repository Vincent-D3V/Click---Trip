<?php

namespace App\Service;

use DateTime;
use App\Entity\Message;
use App\Service\Mailer;
use App\Repository\AgencyRepository;
use App\Repository\ClientRepository;
use App\Repository\HistoryRepository;
use Doctrine\Common\Persistence\ObjectManager;

class SendToMailbox
{
    private $environment;
    private $clientRepo;
    private $agencyRepo;
    private $historyRepo;
    private $mailer;
    private $manager;

    public function __construct(
        \Twig\Environment $environment,
        AgencyRepository $agencyRepo,
        ClientRepository $clientRepo,
        HistoryRepository $historyRepo,
        Mailer $mailer,
        ObjectManager $manager
    ) {
        $this->environment = $environment;
        $this->clientRepo = $clientRepo;
        $this->agencyRepo = $agencyRepo;
        $this->historyRepo = $historyRepo;
        $this->mailer = $mailer;
        $this->manager = $manager;
    }

    /*
        give $array as an array w/ the following structures
        [
            'idHistory' => int,
            'content' => string,
            'adminBool' => boolean,
            'from' => ['id' => int, 'type' => "agency"/"client"/"admin"],
            'to' =>' => ['id' => int, 'type' => "agency"/"client"/"admin"]
        ]
    */
    public function sendMessage($array): void
    {
        $message= new Message();
        $message->setHistories($this->historyRepo->findOneBy(['id' => $array['idHistory']]))
                ->setAdmin($array['adminBool'])
                ->setSendAt(new DateTime(date("Y-m-d H:i:s")))
                ->setContent($array['content']);

        $to=[$array['to']['id'], $array['to']['type']];
        $from=[$array['from']['id'], $array['from']['type']];

        if ($from[1]=='agency') {
            $message->setSender('agency')
                          ->setAgency($this->agencyRepo->findOneBy(['id' => $from[0]]));
            if ($to[1]=='user') {
                $message->setReceiver('user')
                              ->setClient($message->getHistories()->getClient());
                $toMail=$_ENV['MAILER_ADDRESS'];
            } else {
                $client=$this->clientRepo->findOneBy(['id' => $to[0]]);
                $message->setReceiver('client')
                              ->setClient($client);
                $toMail=$client->getEmail();
            }
        } elseif ($from[1]=='client') {
            $message->setSender('client')
                          ->setClient($this->clientRepo->findOneBy(['id' => $from[0]]));
            if ($to[1]=='user') {
                $message->setReceiver('user')
                              ->setAgency($message->getHistories()->getAgency());
                $toMail=$_ENV['MAILER_ADDRESS'];
            } else {
                $agency=$this->agencyRepo->findOneBy(['id' => $to[0]]);
                $message->setReceiver('agency')
                              ->setAgency($agency);
                $toMail=$agency->getEmail();
            }
        } else {
            $message->setSender('user');
            if ($to[1]=='client') {
                $client=$this->clientRepo->findOneBy(['id' => $to[0]]);
                $message->setReceiver('client')
                              ->setClient($client)
                              ->setAgency($message->getHistories()->getAgency());
                $toMail=$client->getEmail();
            } else {
                $agency=$this->agencyRepo->findOneBy(['id' => $to[0]]);
                $message->setReceiver('agency')
                              ->setAgency($agency)
                              ->setClient($message->getHistories()->getClient());
                $toMail=$agency->getEmail();
            }
        }

        $this->manager->persist($message);
        $this->manager->flush();

        $this->mailer->sendMail('Vous avez reçu un nouveau message Click And Trip', $toMail);
    }
}
