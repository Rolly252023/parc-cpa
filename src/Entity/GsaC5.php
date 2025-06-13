<?php

namespace App\Entity;

use App\Repository\GsaC5Repository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GsaC5Repository::class)]
class GsaC5
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $centre = null;

    #[ORM\Column(length: 14, nullable: true)]
    private ?string $prm = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $statut_client = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $etat_rattachement = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_fils = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $option_tarifaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $branche_activite = null;

    #[ORM\Column(nullable: true)]
    private ?int $puissance_souscrite = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $residence_secondaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_client = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $num_rue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_rue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $compl_adresse = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $code_insee = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $troncon_rattachement = null;

    #[ORM\Column(nullable: true)]
    private ?string $distance_rattachement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $position_x = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $position_y = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gdo_ligne_bt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gdo_poste = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_poste = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type_poste = null;

    #[ORM\Column(length: 14, nullable: true)]
    private ?string $id_prm = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commune = null;

    #[ORM\Column(nullable: true)]
    private ?string $liaison_reseau_id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCentre(): ?string
    {
        return $this->centre;
    }

    public function setCentre(?string $centre): static
    {
        $this->centre = $centre;

        return $this;
    }

    public function getPrm(): ?string
    {
        return $this->prm;
    }

    public function setPrm(?string $prm): static
    {
        $this->prm = $prm;

        return $this;
    }

    public function getStatutClient(): ?string
    {
        return $this->statut_client;
    }

    public function setStatutClient(?string $statut_client): static
    {
        $this->statut_client = $statut_client;

        return $this;
    }

    public function getEtatRattachement(): ?string
    {
        return $this->etat_rattachement;
    }

    public function setEtatRattachement(?string $etat_rattachement): static
    {
        $this->etat_rattachement = $etat_rattachement;

        return $this;
    }

    public function getNbFils(): ?int
    {
        return $this->nb_fils;
    }

    public function setNbFils(?int $nb_fils): static
    {
        $this->nb_fils = $nb_fils;

        return $this;
    }

    public function getOptionTarifaire(): ?string
    {
        return $this->option_tarifaire;
    }

    public function setOptionTarifaire(?string $option_tarifaire): static
    {
        $this->option_tarifaire = $option_tarifaire;

        return $this;
    }

    public function getBrancheActivite(): ?string
    {
        return $this->branche_activite;
    }

    public function setBrancheActivite(?string $branche_activite): static
    {
        $this->branche_activite = $branche_activite;

        return $this;
    }

    public function getPuissanceSouscrite(): ?int
    {
        return $this->puissance_souscrite;
    }

    public function setPuissanceSouscrite(?int $puissance_souscrite): static
    {
        $this->puissance_souscrite = $puissance_souscrite;

        return $this;
    }

    public function getResidenceSecondaire(): ?string
    {
        return $this->residence_secondaire;
    }

    public function setResidenceSecondaire(?string $residence_secondaire): static
    {
        $this->residence_secondaire = $residence_secondaire;

        return $this;
    }

    public function getNomClient(): ?string
    {
        return $this->nom_client;
    }

    public function setNomClient(?string $nom_client): static
    {
        $this->nom_client = $nom_client;

        return $this;
    }

    public function getNumRue(): ?string
    {
        return $this->num_rue;
    }

    public function setNumRue(?string $num_rue): static
    {
        $this->num_rue = $num_rue;

        return $this;
    }

    public function getNomRue(): ?string
    {
        return $this->nom_rue;
    }

    public function setNomRue(?string $nom_rue): static
    {
        $this->nom_rue = $nom_rue;

        return $this;
    }

    public function getComplAdresse(): ?string
    {
        return $this->compl_adresse;
    }

    public function setComplAdresse(?string $compl_adresse): static
    {
        $this->compl_adresse = $compl_adresse;

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

    public function getTronconRattachement(): ?string
    {
        return $this->troncon_rattachement;
    }

    public function setTronconRattachement(?string $troncon_rattachement): static
    {
        $this->troncon_rattachement = $troncon_rattachement;

        return $this;
    }

    public function getDistanceRattachement(): ?string
    {
        return $this->distance_rattachement;
    }

    public function setDistanceRattachement(?string $distance_rattachement): static
    {
        $this->distance_rattachement = $distance_rattachement;

        return $this;
    }

    public function getPositionX(): ?string
    {
        return $this->position_x;
    }

    public function setPositionX(?string $position_x): static
    {
        $this->position_x = $position_x;

        return $this;
    }

    public function getPositionY(): ?string
    {
        return $this->position_y;
    }

    public function setPositionY(?string $position_y): static
    {
        $this->position_y = $position_y;

        return $this;
    }

    public function getGdoLigneBt(): ?string
    {
        return $this->gdo_ligne_bt;
    }

    public function setGdoLigneBt(?string $gdo_ligne_bt): static
    {
        $this->gdo_ligne_bt = $gdo_ligne_bt;

        return $this;
    }

    public function getGdoPoste(): ?string
    {
        return $this->gdo_poste;
    }

    public function setGdoPoste(?string $gdo_poste): static
    {
        $this->gdo_poste = $gdo_poste;

        return $this;
    }

    public function getNomPoste(): ?string
    {
        return $this->nom_poste;
    }

    public function setNomPoste(?string $nom_poste): static
    {
        $this->nom_poste = $nom_poste;

        return $this;
    }

    public function getTypePoste(): ?string
    {
        return $this->type_poste;
    }

    public function setTypePoste(?string $type_poste): static
    {
        $this->type_poste = $type_poste;

        return $this;
    }

    public function getIdPrm(): ?string
    {
        return $this->id_prm;
    }

    public function setIdPrm(?string $id_prm): static
    {
        $this->id_prm = $id_prm;

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

    public function getLiaisonReseauId(): ?string
    {
        return $this->liaison_reseau_id;
    }

    public function setLiaisonReseauId(?string $liaison_reseau_id): static
    {
        $this->liaison_reseau_id = $liaison_reseau_id;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

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
