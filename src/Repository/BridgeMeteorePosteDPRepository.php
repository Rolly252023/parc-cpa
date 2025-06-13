<?php

namespace App\Repository;

use App\Entity\BridgeMeteorePosteDP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BridgeMeteorePosteDP>
 *
 * @method BridgeMeteorePosteDP|null find($id, $lockMode = null, $lockVersion = null)
 * @method BridgeMeteorePosteDP|null findOneBy(array $criteria, array $orderBy = null)
 * @method BridgeMeteorePosteDP[]    findAll()
 * @method BridgeMeteorePosteDP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BridgeMeteorePosteDPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BridgeMeteorePosteDP::class);
    }

    /**
     * @return BridgeMeteorePosteDP[] Returns an array of BridgeMeteorePosteDP objects
     */
    public function findByType($value): array
    {
        return $this->createQueryBuilder('b')
            ->select('b.code_gdo, b.pos_geo_long_lat_wkt')
            ->andWhere('b.pos_geo_long_lat_wkt is not null')
            ->andWhere('b.base_oper LIKE :val')
            ->setParameter('val', $value)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
}
