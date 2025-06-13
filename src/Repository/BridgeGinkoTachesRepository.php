<?php

namespace App\Repository;

use App\Entity\BridgeGinkoTaches;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BridgeGinkoTaches>
 *
 * @method BridgeGinkoTaches|null find($id, $lockMode = null, $lockVersion = null)
 * @method BridgeGinkoTaches|null findOneBy(array $criteria, array $orderBy = null)
 * @method BridgeGinkoTaches[]    findAll()
 * @method BridgeGinkoTaches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BridgeGinkoTachesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BridgeGinkoTaches::class);
    }

//    /**
//     * @return BridgeGinkoTaches[] Returns an array of BridgeGinkoTaches objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BridgeGinkoTaches
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
