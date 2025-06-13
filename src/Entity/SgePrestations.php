<?php

namespace App\Entity;

use App\Repository\SgePrestationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SgePrestationsRepository::class)]
class SgePrestations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $code_statut_affaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle_statut_affaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle_etat_affaire = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $segment = null;

    #[ORM\Column(length: 14)]
    private ?string $prm = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rue_adresse = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $code_postal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commune = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etat_point = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_heure_demande = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $code_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle_type = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $code_option = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle_option = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_titulaire_contrat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom_titulaire_contrat = null;

    #[ORM\Column(length: 255)]
    private ?string $id_affaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $clientfinal_nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $clientfinal_prenom = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeStatutAffaire(): ?string
    {
        return $this->code_statut_affaire;
    }

    public function setCodeStatutAffaire(?string $code_statut_affaire): static
    {
        $this->code_statut_affaire = $code_statut_affaire;

        return $this;
    }

    public function getLibelleStatutAffaire(): ?string
    {
        return $this->libelle_statut_affaire;
    }

    public function setLibelleStatutAffaire(?string $libelle_statut_affaire): static
    {
        $this->libelle_statut_affaire = $libelle_statut_affaire;

        return $this;
    }

    public function getLibelleEtatAffaire(): ?string
    {
        return $this->libelle_etat_affaire;
    }

    public function setLibelleEtatAffaire(?string $libelle_etat_affaire): static
    {
        $this->libelle_etat_affaire = $libelle_etat_affaire;

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

    public function getPrm(): ?string
    {
        return $this->prm;
    }

    public function setPrm(string $prm): static
    {
        $this->prm = $prm;

        return $this;
    }

    public function getRueAdresse(): ?string
    {
        return $this->rue_adresse;
    }

    public function setRueAdresse(?string $rue_adresse): static
    {
        $this->rue_adresse = $rue_adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(?string $code_postal): static
    {
        $this->code_postal = $code_postal;

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

    public function getEtatPoint(): ?string
    {
        return $this->etat_point;
    }

    public function setEtatPoint(?string $etat_point): static
    {
        $this->etat_point = $etat_point;

        return $this;
    }

    public function getDateHeureDemande(): ?\DateTimeInterface
    {
        return $this->date_heure_demande;
    }

    public function setDateHeureDemande(?\DateTimeInterface $date_heure_demande): static
    {
        $this->date_heure_demande = $date_heure_demande;

        return $this;
    }

    public function getCodeType(): ?string
    {
        return $this->code_type;
    }

    public function setCodeType(?string $code_type): static
    {
        $this->code_type = $code_type;

        return $this;
    }

    public function getLibelleType(): ?string
    {
        return $this->libelle_type;
    }

    public function setLibelleType(?string $libelle_type): static
    {
        $this->libelle_type = $libelle_type;

        return $this;
    }

    public function getCodeOption(): ?string
    {
        return $this->code_option;
    }

    public function setCodeOption(?string $code_option): static
    {
        $this->code_option = $code_option;

        return $this;
    }

    public function getLibelleOption(): ?string
    {
        return $this->libelle_option;
    }

    public function setLibelleOption(?string $libelle_option): static
    {
        $this->libelle_option = $libelle_option;

        return $this;
    }

    public function getNomTitulaireContrat(): ?string
    {
        return $this->nom_titulaire_contrat;
    }

    public function setNomTitulaireContrat(?string $nom_titulaire_contrat): static
    {
        $this->nom_titulaire_contrat = $nom_titulaire_contrat;

        return $this;
    }

    public function getPrenomTitulaireContrat(): ?string
    {
        return $this->prenom_titulaire_contrat;
    }

    public function setPrenomTitulaireContrat(?string $prenom_titulaire_contrat): static
    {
        $this->prenom_titulaire_contrat = $prenom_titulaire_contrat;

        return $this;
    }

    public function getIdAffaire(): ?string
    {
        return $this->id_affaire;
    }

    public function setIdAffaire(string $id_affaire): static
    {
        $this->id_affaire = $id_affaire;

        return $this;
    }

    public function getClientfinalNom(): ?string
    {
        return $this->clientfinal_nom;
    }

    public function setClientfinalNom(?string $clientfinal_nom): static
    {
        $this->clientfinal_nom = $clientfinal_nom;

        return $this;
    }

    public function getClientfinalPrenom(): ?string
    {
        return $this->clientfinal_prenom;
    }

    public function setClientfinalPrenom(?string $clientfinal_prenom): static
    {
        $this->clientfinal_prenom = $clientfinal_prenom;

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
}
