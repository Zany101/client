<?php

namespace App\Repository;

use App\Entity\Paths;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Paths|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paths|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paths[]    findAll()
 * @method Paths[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PathsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paths::class);
    }

    // /**
    //  * @return Paths[] Returns an array of Paths objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Paths
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
