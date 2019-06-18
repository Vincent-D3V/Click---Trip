<?php

namespace App\Repository;

use App\Entity\Agency;
use App\Entity\Client;
use App\Entity\History;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method History|null find($id, $lockMode = null, $lockVersion = null)
 * @method History|null findOneBy(array $criteria, array $orderBy = null)
 * @method History[]    findAll()
 * @method History[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, History::class);
    }

    public function findAllHistoryInfos(User $user)
    {
        $qb = $this->createQueryBuilder('h');
        if ($user instanceof Agency) {
            $qb->where('h.agency = :agency')
            ->setParameter("agency", $user);
        }
        if ($user instanceof Client) {
            $qb->where('h.client = :client')
                ->setParameter("client", $user);
        }
        return $qb->getQuery()->getResult();
    }
}