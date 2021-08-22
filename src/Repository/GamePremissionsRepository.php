<?php

namespace App\Repository;

use App\Entity\GamePremissions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GamePremissions|null find($id, $lockMode = null, $lockVersion = null)
 * @method GamePremissions|null findOneBy(array $criteria, array $orderBy = null)
 * @method GamePremissions[]    findAll()
 * @method GamePremissions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GamePremissionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GamePremissions::class);
    }

    // /**
    //  * @return GamePremissions[] Returns an array of GamePremissions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GamePremissions
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
