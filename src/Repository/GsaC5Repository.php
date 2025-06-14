<?php

namespace App\Repository;

use App\Entity\GsaC5;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GsaC5>
 *
 * @method GsaC5|null find($id, $lockMode = null, $lockVersion = null)
 * @method GsaC5|null findOneBy(array $criteria, array $orderBy = null)
 * @method GsaC5[]    findAll()
 * @method GsaC5[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GsaC5Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GsaC5::class);
    }

//    /**
//     * @return GsaC5[] Returns an array of GsaC5 objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GsaC5
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
