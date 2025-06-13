<?php

namespace App\Entity;

use App\Repository\BridgeGinkoTachesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BridgeGinkoTachesRepository::class)]
class BridgeGinkoTaches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $reference_tache = null;

    #[ORM\Column(length: 15)]
    private ?string $reference_pds = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_creation_tache = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $extrait_tache = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut_tache = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_debut_tache = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $liste_gestion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $famille_tache = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $groupe_travail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle_nature_tache = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description_nature_tache = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commune = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $code_insee = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $code_centre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code_affaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference_affaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nature_intervention = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $objet_affaire = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference_sge = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferenceTache(): ?int
    {
        return $this->reference_tache;
    }

    public function setReferenceTache(int $reference_tache): static
    {
        $this->reference_tache = $reference_tache;

        return $this;
    }

    public function getReferencePds(): ?string
    {
        return $this->reference_pds;
    }

    public function setReferencePds(string $reference_pds): static
    {
        $this->reference_pds = $reference_pds;

        return $this;
    }

    public function getDateCreationTache(): ?\DateTimeInterface
    {
        return $this->date_creation_tache;
    }

    public function setDateCreationTache(\DateTimeInterface $date_creation_tache): static
    {
        $this->date_creation_tache = $date_creation_tache;

        return $this;
    }

    public function getExtraitTache(): ?string
    {
        return $this->extrait_tache;
    }

    public function setExtraitTache(?string $extrait_tache): static
    {
        $this->extrait_tache = $extrait_tache;

        return $this;
    }

    public function getStatutTache(): ?string
    {
        return $this->statut_tache;
    }

    public function setStatutTache(?string $statut_tache): static
    {
        $this->statut_tache = $statut_tache;

        return $this;
    }

    public function getDateDebutTache(): ?\DateTimeInterface
    {
        return $this->date_debut_tache;
    }

    public function setDateDebutTache(?\DateTimeInterface $date_debut_tache): static
    {
        $this->date_debut_tache = $date_debut_tache;

        return $this;
    }

    public function getListeGestion(): ?string
    {
        return $this->liste_gestion;
    }

    public function setListeGestion(?string $liste_gestion): static
    {
        $this->liste_gestion = $liste_gestion;

        return $this;
    }

    public function getFamilleTache(): ?string
    {
        return $this->famille_tache;
    }

    public function setFamilleTache(?string $famille_tache): static
    {
        $this->famille_tache = $famille_tache;

        return $this;
    }

    public function getGroupeTravail(): ?string
    {
        return $this->groupe_travail;
    }

    public function setGroupeTravail(?string $groupe_travail): static
    {
        $this->groupe_travail = $groupe_travail;

        return $this;
    }

    public function getLibelleNatureTache(): ?string
    {
        return $this->libelle_nature_tache;
    }

    public function setLibelleNatureTache(?string $libelle_nature_tache): static
    {
        $this->libelle_nature_tache = $libelle_nature_tache;

        return $this;
    }

    public function getDescriptionNatureTache(): ?string
    {
        return $this->description_nature_tache;
    }

    public function setDescriptionNatureTache(?string $description_nature_tache): static
    {
        $this->description_nature_tache = $description_nature_tache;

        return $this;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(?string $commune): static
    {
        $this->commune = $commune;

        return $this;
    }

    public function getCodeInsee(): ?string
    {
        return $this->code_insee;
    }

    public function setCodeInsee(?string $code_insee): static
    {
        $this->code_insee = $code_insee;

        return $this;
    }

    public function getCodeCentre(): ?string
    {
        return $this->code_centre;
    }

    public function setCodeCentre(?string $code_centre): static
    {
        $this->code_centre = $code_centre;

        return $this;
    }

    public function getCodeAffaire(): ?string
    {
        return $this->code_affaire;
    }

    public function setCodeAffaire(?string $code_affaire): static
    {
        $this->code_affaire = $code_affaire;

        return $this;
    }

    public function getReferenceAffaire(): ?string
    {
        return $this->reference_affaire;
    }

    public function setReferenceAffaire(?string $reference_affaire): static
    {
        $this->reference_affaire = $reference_affaire;

        return $this;
    }

    public function getNatureIntervention(): ?string
    {
        return $this->nature_intervention;
    }

    public function setNatureIntervention(?string $nature_intervention): static
    {
        $this->nature_intervention = $nature_intervention;

        return $this;
    }

    public function getObjetAffaire(): ?string
    {
        return $this->objet_affaire;
    }

    public function setObjetAffaire(?string $objet_affaire): static
    {
        $this->objet_affaire = $objet_affaire;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getReferenceSge(): ?string
    {
        return $this->reference_sge;
    }

    public function setReferenceSge(?string $reference_sge): static
    {
        $this->reference_sge = $reference_sge;

        return $this;
    }
}
