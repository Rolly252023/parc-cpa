<?php

namespace App\Entity;

use App\Repository\SgeReclamationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SgeReclamationsRepository::class)]
class SgeReclamations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $libelle_statut = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $code_statut = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $segment = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description_demande_precision = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_reception_reclamation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle_objet_demande = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $denomination_sociale_personnemorale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_commercial_personnemorale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_personnephysique = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom_personnephysique = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone1num_reclamant = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone2num_reclamant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse_email_reclamant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_interlocuteur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom_interlocuteur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle_reclamation = null;

    #[ORM\Column(length: 14, nullable: true)]
    private ?string $point_id_reclamation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $batiment_adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero_nom_voie_adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieu_dit_adresse = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $code_postal_adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle_commune = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle_site = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $code_insee_reclamation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle_motif_demande = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description_reclamation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reponse_directe_reclamant_reclamation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $saisine_mediateur_reclamation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $prejudice_client_reclamation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle_nature_prejudice = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentaire_sensibilite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code_processus = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero_reclamation = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $categorie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle_type_demande = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle_sous_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nature_demande_libelle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $recevabilite_etat_affaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prm_usage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $application_source = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $acteurtraitement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $id_traitement = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $trig_dr = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleStatut(): ?string
    {
        return $this->libelle_statut;
    }

    public function setLibelleStatut(?string $libelle_statut): static
    {
        $this->libelle_statut = $libelle_statut;

        return $this;
    }

    public function getCodeStatut(): ?string
    {
        return $this->code_statut;
    }

    public function setCodeStatut(?string $code_statut): static
    {
        $this->code_statut = $code_statut;

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

    public function getDescriptionDemandePrecision(): ?string
    {
        return $this->description_demande_precision;
    }

    public function setDescriptionDemandePrecision(?string $description_demande_precision): static
    {
        $this->description_demande_precision = $description_demande_precision;

        return $this;
    }

    public function getDateReceptionReclamation(): ?\DateTimeInterface
    {
        return $this->date_reception_reclamation;
    }

    public function setDateReceptionReclamation(?\DateTimeInterface $date_reception_reclamation): static
    {
        $this->date_reception_reclamation = $date_reception_reclamation;

        return $this;
    }

    public function getLibelleObjetDemande(): ?string
    {
        return $this->libelle_objet_demande;
    }

    public function setLibelleObjetDemande(?string $libelle_objet_demande): static
    {
        $this->libelle_objet_demande = $libelle_objet_demande;

        return $this;
    }

    public function getDenominationSocialePersonnemorale(): ?string
    {
        return $this->denomination_sociale_personnemorale;
    }

    public function setDenominationSocialePersonnemorale(?string $denomination_sociale_personnemorale): static
    {
        $this->denomination_sociale_personnemorale = $denomination_sociale_personnemorale;

        return $this;
    }

    public function getNomCommercialPersonnemorale(): ?string
    {
        return $this->nom_commercial_personnemorale;
    }

    public function setNomCommercialPersonnemorale(?string $nom_commercial_personnemorale): static
    {
        $this->nom_commercial_personnemorale = $nom_commercial_personnemorale;

        return $this;
    }

    public function getNomPersonnephysique(): ?string
    {
        return $this->nom_personnephysique;
    }

    public function setNomPersonnephysique(?string $nom_personnephysique): static
    {
        $this->nom_personnephysique = $nom_personnephysique;

        return $this;
    }

    public function getPrenomPersonnephysique(): ?string
    {
        return $this->prenom_personnephysique;
    }

    public function setPrenomPersonnephysique(?string $prenom_personnephysique): static
    {
        $this->prenom_personnephysique = $prenom_personnephysique;

        return $this;
    }

    public function getTelephone1numReclamant(): ?string
    {
        return $this->telephone1num_reclamant;
    }

    public function setTelephone1numReclamant(?string $telephone1num_reclamant): static
    {
        $this->telephone1num_reclamant = $telephone1num_reclamant;

        return $this;
    }

    public function getTelephone2numReclamant(): ?string
    {
        return $this->telephone2num_reclamant;
    }

    public function setTelephone2numReclamant(?string $telephone2num_reclamant): static
    {
        $this->telephone2num_reclamant = $telephone2num_reclamant;

        return $this;
    }

    public function getAdresseEmailReclamant(): ?string
    {
        return $this->adresse_email_reclamant;
    }

    public function setAdresseEmailReclamant(?string $adresse_email_reclamant): static
    {
        $this->adresse_email_reclamant = $adresse_email_reclamant;

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

    public function getNomInterlocuteur(): ?string
    {
        return $this->nom_interlocuteur;
    }

    public function setNomInterlocuteur(?string $nom_interlocuteur): static
    {
        $this->nom_interlocuteur = $nom_interlocuteur;

        return $this;
    }

    public function getPrenomInterlocuteur(): ?string
    {
        return $this->prenom_interlocuteur;
    }

    public function setPrenomInterlocuteur(?string $prenom_interlocuteur): static
    {
        $this->prenom_interlocuteur = $prenom_interlocuteur;

        return $this;
    }

    public function getLibelleReclamation(): ?string
    {
        return $this->libelle_reclamation;
    }

    public function setLibelleReclamation(?string $libelle_reclamation): static
    {
        $this->libelle_reclamation = $libelle_reclamation;

        return $this;
    }

    public function getPointIdReclamation(): ?string
    {
        return $this->point_id_reclamation;
    }

    public function setPointIdReclamation(?string $point_id_reclamation): static
    {
        $this->point_id_reclamation = $point_id_reclamation;

        return $this;
    }

    public function getBatimentAdresse(): ?string
    {
        return $this->batiment_adresse;
    }

    public function setBatimentAdresse(?string $batiment_adresse): static
    {
        $this->batiment_adresse = $batiment_adresse;

        return $this;
    }

    public function getNumeroNomVoieAdresse(): ?string
    {
        return $this->numero_nom_voie_adresse;
    }

    public function setNumeroNomVoieAdresse(?string $numero_nom_voie_adresse): static
    {
        $this->numero_nom_voie_adresse = $numero_nom_voie_adresse;

        return $this;
    }

    public function getLieuDitAdresse(): ?string
    {
        return $this->lieu_dit_adresse;
    }

    public function setLieuDitAdresse(?string $lieu_dit_adresse): static
    {
        $this->lieu_dit_adresse = $lieu_dit_adresse;

        return $this;
    }

    public function getCodePostalAdresse(): ?string
    {
        return $this->code_postal_adresse;
    }

    public function setCodePostalAdresse(?string $code_postal_adresse): static
    {
        $this->code_postal_adresse = $code_postal_adresse;

        return $this;
    }

    public function getLibelleCommune(): ?string
    {
        return $this->libelle_commune;
    }

    public function setLibelleCommune(?string $libelle_commune): static
    {
        $this->libelle_commune = $libelle_commune;

        return $this;
    }

    public function getLibelleSite(): ?string
    {
        return $this->libelle_site;
    }

    public function setLibelleSite(?string $libelle_site): static
    {
        $this->libelle_site = $libelle_site;

        return $this;
    }

    public function getCodeInseeReclamation(): ?string
    {
        return $this->code_insee_reclamation;
    }

    public function setCodeInseeReclamation(?string $code_insee_reclamation): static
    {
        $this->code_insee_reclamation = $code_insee_reclamation;

        return $this;
    }

    public function getLibelleMotifDemande(): ?string
    {
        return $this->libelle_motif_demande;
    }

    public function setLibelleMotifDemande(?string $libelle_motif_demande): static
    {
        $this->libelle_motif_demande = $libelle_motif_demande;

        return $this;
    }

    public function getDescriptionReclamation(): ?string
    {
        return $this->description_reclamation;
    }

    public function setDescriptionReclamation(?string $description_reclamation): static
    {
        $this->description_reclamation = $description_reclamation;

        return $this;
    }

    public function getReponseDirecteReclamantReclamation(): ?string
    {
        return $this->reponse_directe_reclamant_reclamation;
    }

    public function setReponseDirecteReclamantReclamation(?string $reponse_directe_reclamant_reclamation): static
    {
        $this->reponse_directe_reclamant_reclamation = $reponse_directe_reclamant_reclamation;

        return $this;
    }

    public function isSaisineMediateurReclamation(): ?bool
    {
        return $this->saisine_mediateur_reclamation;
    }

    public function setSaisineMediateurReclamation(?bool $saisine_mediateur_reclamation): static
    {
        $this->saisine_mediateur_reclamation = $saisine_mediateur_reclamation;

        return $this;
    }

    public function isPrejudiceClientReclamation(): ?bool
    {
        return $this->prejudice_client_reclamation;
    }

    public function setPrejudiceClientReclamation(?bool $prejudice_client_reclamation): static
    {
        $this->prejudice_client_reclamation = $prejudice_client_reclamation;

        return $this;
    }

    public function getLibelleNaturePrejudice(): ?string
    {
        return $this->libelle_nature_prejudice;
    }

    public function setLibelleNaturePrejudice(?string $libelle_nature_prejudice): static
    {
        $this->libelle_nature_prejudice = $libelle_nature_prejudice;

        return $this;
    }

    public function getCommentaireSensibilite(): ?string
    {
        return $this->commentaire_sensibilite;
    }

    public function setCommentaireSensibilite(?string $commentaire_sensibilite): static
    {
        $this->commentaire_sensibilite = $commentaire_sensibilite;

        return $this;
    }

    public function getCodeProcessus(): ?string
    {
        return $this->code_processus;
    }

    public function setCodeProcessus(?string $code_processus): static
    {
        $this->code_processus = $code_processus;

        return $this;
    }

    public function getNumeroReclamation(): ?string
    {
        return $this->numero_reclamation;
    }

    public function setNumeroReclamation(?string $numero_reclamation): static
    {
        $this->numero_reclamation = $numero_reclamation;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getLibelleTypeDemande(): ?string
    {
        return $this->libelle_type_demande;
    }

    public function setLibelleTypeDemande(?string $libelle_type_demande): static
    {
        $this->libelle_type_demande = $libelle_type_demande;

        return $this;
    }

    public function getLibelleSousType(): ?string
    {
        return $this->libelle_sous_type;
    }

    public function setLibelleSousType(?string $libelle_sous_type): static
    {
        $this->libelle_sous_type = $libelle_sous_type;

        return $this;
    }

    public function getNatureDemandeLibelle(): ?string
    {
        return $this->nature_demande_libelle;
    }

    public function setNatureDemandeLibelle(?string $nature_demande_libelle): static
    {
        $this->nature_demande_libelle = $nature_demande_libelle;

        return $this;
    }

    public function getRecevabiliteEtatAffaire(): ?string
    {
        return $this->recevabilite_etat_affaire;
    }

    public function setRecevabiliteEtatAffaire(?string $recevabilite_etat_affaire): static
    {
        $this->recevabilite_etat_affaire = $recevabilite_etat_affaire;

        return $this;
    }

    public function getPrmUsage(): ?string
    {
        return $this->prm_usage;
    }

    public function setPrmUsage(?string $prm_usage): static
    {
        $this->prm_usage = $prm_usage;

        return $this;
    }

    public function getApplicationSource(): ?string
    {
        return $this->application_source;
    }

    public function setApplicationSource(?string $application_source): static
    {
        $this->application_source = $application_source;

        return $this;
    }

    public function getActeurtraitement(): ?string
    {
        return $this->acteurtraitement;
    }

    public function setActeurtraitement(?string $acteurtraitement): static
    {
        $this->acteurtraitement = $acteurtraitement;

        return $this;
    }

    public function getIdTraitement(): ?string
    {
        return $this->id_traitement;
    }

    public function setIdTraitement(?string $id_traitement): static
    {
        $this->id_traitement = $id_traitement;

        return $this;
    }

    public function getTrigDr(): ?string
    {
        return $this->trig_dr;
    }

    public function setTrigDr(?string $trig_dr): static
    {
        $this->trig_dr = $trig_dr;

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
