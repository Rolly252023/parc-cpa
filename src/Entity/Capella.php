<?php

namespace App\Entity;

use App\Repository\CapellaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CapellaRepository::class)]
class Capella
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $dossier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_creation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $createur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $entity_suivi = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bureau_suivi = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_cloture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $canal_echange = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sens_canal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $identifiant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $segment = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $client = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $code_insee = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $processus = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sous_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nni_cloture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_cloture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bureau_traitement = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDossier(): ?string
    {
        return $this->dossier;
    }

    public function setDossier(string $dossier): static
    {
        $this->dossier = $dossier;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(?\DateTimeInterface $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getCreateur(): ?string
    {
        return $this->createur;
    }

    public function setCreateur(?string $createur): static
    {
        $this->createur = $createur;

        return $this;
    }

    public function getEntitySuivi(): ?string
    {
        return $this->entity_suivi;
    }

    public function setEntitySuivi(?string $entity_suivi): static
    {
        $this->entity_suivi = $entity_suivi;

        return $this;
    }

    public function getBureauSuivi(): ?string
    {
        return $this->bureau_suivi;
    }

    public function setBureauSuivi(?string $bureau_suivi): static
    {
        $this->bureau_suivi = $bureau_suivi;

        return $this;
    }

    public function getDateCloture(): ?\DateTimeInterface
    {
        return $this->date_cloture;
    }

    public function setDateCloture(?\DateTimeInterface $date_cloture): static
    {
        $this->date_cloture = $date_cloture;

        return $this;
    }

    public function getCanalEchange(): ?string
    {
        return $this->canal_echange;
    }

    public function setCanalEchange(?string $canal_echange): static
    {
        $this->canal_echange = $canal_echange;

        return $this;
    }

    public function getSensCanal(): ?string
    {
        return $this->sens_canal;
    }

    public function setSensCanal(?string $sens_canal): static
    {
        $this->sens_canal = $sens_canal;

        return $this;
    }

    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(?string $identifiant): static
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    public function getSegment(): ?string
    {
        return $this->segment;
    }

    public function setSegment(?string $segment): static
    {
        $this->segment = $segment;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(?string $client): static
    {
        $this->client = $client;

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

    public function getProcessus(): ?string
    {
        return $this->processus;
    }

    public function setProcessus(?string $processus): static
    {
        $this->processus = $processus;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSousType(): ?string
    {
        return $this->sous_type;
    }

    public function setSousType(?string $sous_type): static
    {
        $this->sous_type = $sous_type;

        return $this;
    }

    public function getNniCloture(): ?string
    {
        return $this->nni_cloture;
    }

    public function setNniCloture(?string $nni_cloture): static
    {
        $this->nni_cloture = $nni_cloture;

        return $this;
    }

    public function getNomCloture(): ?string
    {
        return $this->nom_cloture;
    }

    public function setNomCloture(?string $nom_cloture): static
    {
        $this->nom_cloture = $nom_cloture;

        return $this;
    }

    public function getBureauTraitement(): ?string
    {
        return $this->bureau_traitement;
    }

    public function setBureauTraitement(?string $bureau_traitement): static
    {
        $this->bureau_traitement = $bureau_traitement;

        return $this;
    }
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

}
