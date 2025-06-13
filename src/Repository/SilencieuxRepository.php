<?php

namespace App\Repository;

use App\Entity\Silencieux;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Silencieux>
 *
 * @method Silencieux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Silencieux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Silencieux[]    findAll()
 * @method Silencieux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SilencieuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Silencieux::class);
    }

    public function getSilencieuxEnCours()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.etat_silence != :etat')
            ->setParameter('etat', 'archive')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function getSilencieuxByFilters($prio, $etat, $traitement)
    {
        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.silencieuxActions', 'sa')
            ->addSelect('sa');

        if ($prio !== null && $prio !== '') {
            $qb->andWhere('s.priorite = :prio')
                ->setParameter('prio', $prio);
        }

        if (!empty($etat)) {
            $qb->andWhere('s.etat_silence IN (:etat)')
                ->setParameter('etat', $etat);
        }

        // Filtre par traitement si défini
        if ($traitement !== null) {
            if ($traitement == 1) {
                $qb->andWhere('s.traite = :traitement')
                    ->setParameter('traitement', true);
            } else {
                $qb->andWhere('s.traite IS NULL OR s.traite = :traitement')
                    ->setParameter('traitement', false);
            }
        }

        return $qb->getQuery()->getResult();
    }



    public function updateEtatSilenceToHisto(string  $date)
    {
        return $this->createQueryBuilder('s')
            ->update(Silencieux::class, 's')
            ->set('s.etat_silence', ':newEtat')
            ->where('s.etat_silence != :etatArchive')
            ->andWhere('s.date_import < :date')
            ->setParameter('newEtat', 'archive')
            ->setParameter('etatArchive', 'archive')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    public function initTraitement()
    {
        return $this->createQueryBuilder('s')
            ->update(Silencieux::class, 's')
            ->set('s.traite', ':init')
            ->where('s.etat_silence != :etatArchive')
            ->setParameter('init', '')
            ->setParameter('etatArchive', 'archive')
            ->getQuery()
            ->getResult();
    }

    public function getLastDateImport(): ?DateTimeInterface
    {
        $result = $this->createQueryBuilder('s')
            ->select('s.date_import')
            ->orderBy('s.date_import', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $result['date_import'] ?? null;
    }


    public function findSilencieuxWithRelanceDate(\DateTime $dateRelance, $agent)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.silencieuxActions', 'sa') // Assurez-vous d'utiliser le nom correct de la relation dans l'entité Silencieux
            ->andWhere('sa.date_relance < :dateRelance')
            ->setParameter('dateRelance', $dateRelance)
            ->andWhere('sa.agent = :agent')
            ->setParameter('agent', $agent)
            ->getQuery()
            ->getResult();
    }

    public function findEmailByGrappe($pdk)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.silEmail', 'sa') // Assurez-vous d'utiliser le nom correct de la relation dans l'entité Silencieux
            ->andWhere('sa.pdk = :pdk')
            ->setParameter('pdk', $pdk)
            ->getQuery()
            ->getResult();
    }

    public function searchByQuery($query)
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s')
            ->andWhere('s.prm LIKE :query OR s.pdk_ref LIKE :query OR s.pdk_com LIKE :query')
            ->setParameter('query', '%' . $query . '%');
            return $qb->getQuery()->getArrayResult();
    }

    /**
     * Récupère les silencieux avec les données GsaC5 associées
     */
    public function findWithGsaC5(): array
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('App\Entity\GsaC5', 'g', 'WITH', 's.prm = g.id_prm')
            ->addSelect('g.position_x as lon, g.position_y as lat')
            ->setMaxResults(100)
            ->getQuery()
            ->getArrayResult();
    }
}
