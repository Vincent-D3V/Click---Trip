<?php

namespace App\Twig;

use App\Entity\Agency;
use App\Entity\Client;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class InstanceOfExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('instanceofClient', [$this, 'instanceOfClient']),
            new TwigFunction('instanceofAgency', [$this, 'instanceOfAgency']),
        ];
    }

    public function instanceOfClient($user)
    {
        return  $user instanceof Client;
    }
    
    public function instanceOfAgency($user)
    {
        return  $user instanceof Agency;
    }
}
