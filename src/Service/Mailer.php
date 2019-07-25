<?php

namespace App\Service;

class Mailer
{
    private $mailer;
    private $environment;

    public function __construct(\Swift_Mailer $mailer, \Twig\Environment $environment)
    {
        $this->mailer = $mailer;
        $this->environment = $environment;
    }

    public function sendMail(string $subject, string $to): void
    {
        $message = (new \Swift_Message($subject))
                ->setFrom($_ENV['MAILER_FROM_ADDRESS'])
                ->setTo($to)
                ->setBody($this->environment->render('email/articleAdded.html.twig'), 'text/html');
        $this->mailer->send($message);
    }
}
