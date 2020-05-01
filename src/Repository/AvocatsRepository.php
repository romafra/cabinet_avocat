<?php

namespace App\Repository;

use App\Entity\Avocats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Avocats|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avocats|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avocats[]    findAll()
 * @method Avocats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvocatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avocats::class);
    }

    // /**
    //  * @return Avocats[] Returns an array of Avocats objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Avocats
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
