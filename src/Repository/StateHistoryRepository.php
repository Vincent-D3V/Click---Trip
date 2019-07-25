<?php

namespace App\Repository;

use App\Entity\StateHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StateHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method StateHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method StateHistory[]    findAll()
 * @method StateHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StateHistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StateHistory::class);
    }
}
