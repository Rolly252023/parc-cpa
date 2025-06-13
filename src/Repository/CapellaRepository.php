<?php

namespace App\Repository;

use App\Entity\Capella;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Capella>
 *
 * @method Capella|null find($id, $lockMode = null, $lockVersion = null)
 * @method Capella|null findOneBy(array $criteria, array $orderBy = null)
 * @method Capella[]    findAll()
 * @method Capella[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CapellaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Capella::class);
    }

//    /**
//     * @return Capella[] Returns an array of Capella objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Capella
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
