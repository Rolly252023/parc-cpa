<?php

namespace App\Repository;

use App\Entity\SgeReclamations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SgeReclamations>
 *
 * @method SgeReclamations|null find($id, $lockMode = null, $lockVersion = null)
 * @method SgeReclamations|null findOneBy(array $criteria, array $orderBy = null)
 * @method SgeReclamations[]    findAll()
 * @method SgeReclamations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SgeReclamationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SgeReclamations::class);
    }

    public function save(SgeReclamations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SgeReclamations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
} 