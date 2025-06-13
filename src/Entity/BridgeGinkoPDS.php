<?php

namespace App\Entity;

use App\Repository\BridgeGinkoPDSRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BridgeGinkoPDSRepository::class)]
class BridgeGinkoPDS
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_pds = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $id_pds_ginko = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?int $edl_id = null;

    #[ORM\Column(length: 255)]
    private ?string $edl_reference = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $edl_typespace = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sousetat = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $coupe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motif_coupure = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coupure_accessible = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $nature = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeinjection = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $limitation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $puissancelimitation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieulimitation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motiflimitation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $puissancelimitetechnique = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $communicabilite = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $normecommunicationcpl = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $ccpiaccessible = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emplacementcompteur = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $accescompteur = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $accesdisjoncteur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $modereleve = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typetension = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $ahautrisquevital = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $teleoperable = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateteleoperable = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datebasculecommactive = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datecreation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $releveagent_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datemodification = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateetat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateetatlimitation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datemodifniveaucomm = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datemiseenservice = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $commentaireintervenant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $niveauouvertureservice = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $utilisation = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $centre_code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $positiongps_lat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $positiongps_lgt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse_compl = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $codepostal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commune = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $codeinsee = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPds(): ?int
    {
        return $this->id_pds;
    }

    public function setIdPds(int $id_pds): static
    {
        $this->id_pds = $id_pds;

        return $this;
    }

    public function getIdPdsGinko(): ?string
    {
        return $this->id_pds_ginko;
    }

    public function setIdPdsGinko(?string $id_pds_ginko): static
    {
        $this->id_pds_ginko = $id_pds_ginko;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getEdlId(): ?int
    {
        return $this->edl_id;
    }

    public function setEdlId(int $edl_id): static
    {
        $this->edl_id = $edl_id;

        return $this;
    }

    public function getEdlReference(): ?string
    {
        return $this->edl_reference;
    }

    public function setEdlReference(string $edl_reference): static
    {
        $this->edl_reference = $edl_reference;

        return $this;
    }

    public function getEdlTypespace(): ?string
    {
        return $this->edl_typespace;
    }

    public function setEdlTypespace(?string $edl_typespace): static
    {
        $this->edl_typespace = $edl_typespace;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getSousetat(): ?string
    {
        return $this->sousetat;
    }

    public function setSousetat(?string $sousetat): static
    {
        $this->sousetat = $sousetat;

        return $this;
    }

    public function getCoupe(): ?string
    {
        return $this->coupe;
    }

    public function setCoupe(?string $coupe): static
    {
        $this->coupe = $coupe;

        return $this;
    }

    public function getMotifCoupure(): ?string
    {
        return $this->motif_coupure;
    }

    public function setMotifCoupure(?string $motif_coupure): static
    {
        $this->motif_coupure = $motif_coupure;

        return $this;
    }

    public function getCoupureAccessible(): ?string
    {
        return $this->coupure_accessible;
    }

    public function setCoupureAccessible(?string $coupure_accessible): static
    {
        $this->coupure_accessible = $coupure_accessible;

        return $this;
    }

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function setNature(?string $nature): static
    {
        $this->nature = $nature;

        return $this;
    }

    public function getTypeinjection(): ?string
    {
        return $this->typeinjection;
    }

    public function setTypeinjection(?string $typeinjection): static
    {
        $this->typeinjection = $typeinjection;

        return $this;
    }

    public function getLimitation(): ?string
    {
        return $this->limitation;
    }

    public function setLimitation(?string $limitation): static
    {
        $this->limitation = $limitation;

        return $this;
    }

    public function getPuissancelimitation(): ?string
    {
        return $this->puissancelimitation;
    }

    public function setPuissancelimitation(?string $puissancelimitation): static
    {
        $this->puissancelimitation = $puissancelimitation;

        return $this;
    }

    public function getLieulimitation(): ?string
    {
        return $this->lieulimitation;
    }

    public function setLieulimitation(?string $lieulimitation): static
    {
        $this->lieulimitation = $lieulimitation;

        return $this;
    }

    public function getMotiflimitation(): ?string
    {
        return $this->motiflimitation;
    }

    public function setMotiflimitation(?string $motiflimitation): static
    {
        $this->motiflimitation = $motiflimitation;

        return $this;
    }

    public function getPuissancelimitetechnique(): ?string
    {
        return $this->puissancelimitetechnique;
    }

    public function setPuissancelimitetechnique(?string $puissancelimitetechnique): static
    {
        $this->puissancelimitetechnique = $puissancelimitetechnique;

        return $this;
    }

    public function getCommunicabilite(): ?string
    {
        return $this->communicabilite;
    }

    public function setCommunicabilite(?string $communicabilite): static
    {
        $this->communicabilite = $communicabilite;

        return $this;
    }

    public function getNormecommunicationcpl(): ?string
    {
        return $this->normecommunicationcpl;
    }

    public function setNormecommunicationcpl(?string $normecommunicationcpl): static
    {
        $this->normecommunicationcpl = $normecommunicationcpl;

        return $this;
    }

    public function getCcpiaccessible(): ?string
    {
        return $this->ccpiaccessible;
    }

    public function setCcpiaccessible(?string $ccpiaccessible): static
    {
        $this->ccpiaccessible = $ccpiaccessible;

        return $this;
    }

    public function getEmplacementcompteur(): ?string
    {
        return $this->emplacementcompteur;
    }

    public function setEmplacementcompteur(?string $emplacementcompteur): static
    {
        $this->emplacementcompteur = $emplacementcompteur;

        return $this;
    }

    public function getAccescompteur(): ?string
    {
        return $this->accescompteur;
    }

    public function setAccescompteur(?string $accescompteur): static
    {
        $this->accescompteur = $accescompteur;

        return $this;
    }

    public function getAccesdisjoncteur(): ?string
    {
        return $this->accesdisjoncteur;
    }

    public function setAccesdisjoncteur(?string $accesdisjoncteur): static
    {
        $this->accesdisjoncteur = $accesdisjoncteur;

        return $this;
    }

    public function getModereleve(): ?string
    {
        return $this->modereleve;
    }

    public function setModereleve(?string $modereleve): static
    {
        $this->modereleve = $modereleve;

        return $this;
    }

    public function getTypetension(): ?string
    {
        return $this->typetension;
    }

    public function setTypetension(?string $typetension): static
    {
        $this->typetension = $typetension;

        return $this;
    }

    public function getAhautrisquevital(): ?string
    {
        return $this->ahautrisquevital;
    }

    public function setAhautrisquevital(?string $ahautrisquevital): static
    {
        $this->ahautrisquevital = $ahautrisquevital;

        return $this;
    }

    public function getTeleoperable(): ?string
    {
        return $this->teleoperable;
    }

    public function setTeleoperable(?string $teleoperable): static
    {
        $this->teleoperable = $teleoperable;

        return $this;
    }

    public function getDateteleoperable(): ?\DateTimeInterface
    {
        return $this->dateteleoperable;
    }

    public function setDateteleoperable(?\DateTimeInterface $dateteleoperable): static
    {
        $this->dateteleoperable = $dateteleoperable;

        return $this;
    }

    public function getDatebasculecommactive(): ?\DateTimeInterface
    {
        return $this->datebasculecommactive;
    }

    public function setDatebasculecommactive(?\DateTimeInterface $datebasculecommactive): static
    {
        $this->datebasculecommactive = $datebasculecommactive;

        return $this;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(?\DateTimeInterface $datecreation): static
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getReleveagentDate(): ?\DateTimeInterface
    {
        return $this->releveagent_date;
    }

    public function setReleveagentDate(?\DateTimeInterface $releveagent_date): static
    {
        $this->releveagent_date = $releveagent_date;

        return $this;
    }

    public function getDatemodification(): ?\DateTimeInterface
    {
        return $this->datemodification;
    }

    public function setDatemodification(?\DateTimeInterface $datemodification): static
    {
        $this->datemodification = $datemodification;

        return $this;
    }

    public function getDateetat(): ?\DateTimeInterface
    {
        return $this->dateetat;
    }

    public function setDateetat(?\DateTimeInterface $dateetat): static
    {
        $this->dateetat = $dateetat;

        return $this;
    }

    public function getDateetatlimitation(): ?\DateTimeInterface
    {
        return $this->dateetatlimitation;
    }

    public function setDateetatlimitation(?\DateTimeInterface $dateetatlimitation): static
    {
        $this->dateetatlimitation = $dateetatlimitation;

        return $this;
    }

    public function getDatemodifniveaucomm(): ?\DateTimeInterface
    {
        return $this->datemodifniveaucomm;
    }

    public function setDatemodifniveaucomm(?\DateTimeInterface $datemodifniveaucomm): static
    {
        $this->datemodifniveaucomm = $datemodifniveaucomm;

        return $this;
    }

    public function getDatemiseenservice(): ?\DateTimeInterface
    {
        return $this->datemiseenservice;
    }

    public function setDatemiseenservice(?\DateTimeInterface $datemiseenservice): static
    {
        $this->datemiseenservice = $datemiseenservice;

        return $this;
    }

    public function getCommentaireintervenant(): ?string
    {
        return $this->commentaireintervenant;
    }

    public function setCommentaireintervenant(?string $commentaireintervenant): static
    {
        $this->commentaireintervenant = $commentaireintervenant;

        return $this;
    }

    public function getNiveauouvertureservice(): ?string
    {
        return $this->niveauouvertureservice;
    }

    public function setNiveauouvertureservice(?string $niveauouvertureservice): static
    {
        $this->niveauouvertureservice = $niveauouvertureservice;

        return $this;
    }

    public function getUtilisation(): ?string
    {
        return $this->utilisation;
    }

    public function setUtilisation(?string $utilisation): static
    {
        $this->utilisation = $utilisation;

        return $this;
    }

    public function getCentreCode(): ?string
    {
        return $this->centre_code;
    }

    public function setCentreCode(?string $centre_code): static
    {
        $this->centre_code = $centre_code;

        return $this;
    }

    public function getPositiongpsLat(): ?string
    {
        return $this->positiongps_lat;
    }

    public function setPositiongpsLat(?string $positiongps_lat): static
    {
        $this->positiongps_lat = $positiongps_lat;

        return $this;
    }

    public function getPositiongpsLgt(): ?string
    {
        return $this->positiongps_lgt;
    }

    public function setPositiongpsLgt(?string $positiongps_lgt): static
    {
        $this->positiongps_lgt = $positiongps_lgt;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getAdresseCompl(): ?string
    {
        return $this->adresse_compl;
    }

    public function setAdresseCompl(?string $adresse_compl): static
    {
        $this->adresse_compl = $adresse_compl;

        return $this;
    }

    public function getCodepostal(): ?string
    {
        return $this->codepostal;
    }

    public function setCodepostal(?string $codepostal): static
    {
        $this->codepostal = $codepostal;

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

    public function getCodeinsee(): ?string
    {
        return $this->codeinsee;
    }

    public function setCodeinsee(?string $codeinsee): static
    {
        $this->codeinsee = $codeinsee;

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
