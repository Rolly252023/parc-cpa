<?php

namespace App\Repository;

use App\Entity\BridgeMeteoreDipoleBT;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BridgeMeteoreDipoleBT>
 *
 * @method BridgeMeteoreDipoleBT|null find($id, $lockMode = null, $lockVersion = null)
 * @method BridgeMeteoreDipoleBT|null findOneBy(array $criteria, array $orderBy = null)
 * @method BridgeMeteoreDipoleBT[]    findAll()
 * @method BridgeMeteoreDipoleBT[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BridgeMeteoreDipoleBTRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BridgeMeteoreDipoleBT::class);
    }

//    /**
//     * @return BridgeMeteoreDipoleBT[] Returns an array of BridgeMeteoreDipoleBT objects
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

//    public function findOneBySomeField($value): ?BridgeMeteoreDipoleBT
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
