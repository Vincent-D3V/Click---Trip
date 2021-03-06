<?php

namespace App\Repository;

use App\Entity\Size;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Size|null find($id, $lockMode = null, $lockVersion = null)
 * @method Size|null findOneBy(array $criteria, array $orderBy = null)
 * @method Size[]    findAll()
 * @method Size[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SizeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Size::class);
    }
}
