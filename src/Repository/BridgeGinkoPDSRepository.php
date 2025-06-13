<?php

namespace App\Repository;

use App\Entity\BridgeGinkoPDS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BridgeGinkoPDS>
 *
 * @method BridgeGinkoPDS|null find($id, $lockMode = null, $lockVersion = null)
 * @method BridgeGinkoPDS|null findOneBy(array $criteria, array $orderBy = null)
 * @method BridgeGinkoPDS[]    findAll()
 * @method BridgeGinkoPDS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BridgeGinkoPDSRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BridgeGinkoPDS::class);
    }

//    /**
//     * @return BridgeGinkoPDS[] Returns an array of BridgeGinkoPDS objects
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

//    public function findOneBySomeField($value): ?BridgeGinkoPDS
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
