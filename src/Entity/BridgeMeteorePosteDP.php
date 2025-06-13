<?php

namespace App\Entity;

use App\Repository\BridgeMeteorePosteDPRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BridgeMeteorePosteDPRepository::class)]
class BridgeMeteorePosteDP
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $base_oper = null;

    #[ORM\Column(length: 10)]
    private ?string $code_gdo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fctn_poste_sig_orig = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fonction = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $detail_emplacement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_crea_sig = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_mise_en_exploitation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_maj_sig = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_mise_hors_expl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dossier_sig_crea = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dossier_sig_modif = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?array $pos_geo_long_lat_wkt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseOper(): ?string
    {
        return $this->base_oper;
    }

    public function setBaseOper(?string $base_oper): static
    {
        $this->base_oper = $base_oper;

        return $this;
    }

    public function getCodeGdo(): ?string
    {
        return $this->code_gdo;
    }

    public function setCodeGdo(string $code_gdo): static
    {
        $this->code_gdo = $code_gdo;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getFctnPosteSigOrig(): ?string
    {
        return $this->fctn_poste_sig_orig;
    }

    public function setFctnPosteSigOrig(?string $fctn_poste_sig_orig): static
    {
        $this->fctn_poste_sig_orig = $fctn_poste_sig_orig;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(?string $fonction): static
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getDetailEmplacement(): ?string
    {
        return $this->detail_emplacement;
    }

    public function setDetailEmplacement(?string $detail_emplacement): static
    {
        $this->detail_emplacement = $detail_emplacement;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDateCreaSig(): ?\DateTimeInterface
    {
        return $this->date_crea_sig;
    }

    public function setDateCreaSig(?\DateTimeInterface $date_crea_sig): static
    {
        $this->date_crea_sig = $date_crea_sig;

        return $this;
    }

    public function getDateMiseEnExploitation(): ?\DateTimeInterface
    {
        return $this->date_mise_en_exploitation;
    }

    public function setDateMiseEnExploitation(?\DateTimeInterface $date_mise_en_exploitation): static
    {
        $this->date_mise_en_exploitation = $date_mise_en_exploitation;

        return $this;
    }

    public function getDateMajSig(): ?\DateTimeInterface
    {
        return $this->date_maj_sig;
    }

    public function setDateMajSig(?\DateTimeInterface $date_maj_sig): static
    {
        $this->date_maj_sig = $date_maj_sig;

        return $this;
    }

    public function getDateMiseHorsExpl(): ?\DateTimeInterface
    {
        return $this->date_mise_hors_expl;
    }

    public function setDateMiseHorsExpl(?\DateTimeInterface $date_mise_hors_expl): static
    {
        $this->date_mise_hors_expl = $date_mise_hors_expl;

        return $this;
    }

    public function getDossierSigCrea(): ?string
    {
        return $this->dossier_sig_crea;
    }

    public function setDossierSigCrea(?string $dossier_sig_crea): static
    {
        $this->dossier_sig_crea = $dossier_sig_crea;

        return $this;
    }

    public function getDossierSigModif(): ?string
    {
        return $this->dossier_sig_modif;
    }

    public function setDossierSigModif(?string $dossier_sig_modif): static
    {
        $this->dossier_sig_modif = $dossier_sig_modif;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPosGeoLongLatWkt(): ?array
    {
        return $this->pos_geo_long_lat_wkt;
    }

    public function setPosGeoLongLatWkt(?array $pos_geo_long_lat_wkt): static
    {
        $this->pos_geo_long_lat_wkt = $pos_geo_long_lat_wkt;

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
