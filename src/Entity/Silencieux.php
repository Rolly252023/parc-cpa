<?php

namespace App\Entity;

use App\Repository\SilencieuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SilencieuxRepository::class)]
#[ORM\Table(uniqueConstraints: [
    new ORM\UniqueConstraint(name: 'unique_prm_priorite_date', columns: ['prm', 'priorite', 'date_entree_cause_silence'])
])]
class Silencieux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $priorite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cause_silence = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $probabilite_defaillance = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $presence_da_c = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $presence_da_k = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $presence_dit_c = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $presence_dit_k = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $dr = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $affaire_l001 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $agence_intervention = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $base_op = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $code_insee = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $compteur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $constructeur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_ouverture_da_c = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_derniere_collecte = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $id_depart = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $accessibilite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cause_generale = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_ligne = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_jour_non_collecte = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_jour_non_collecte_23h59 = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $techno = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pdk_com = null;

    #[ORM\Column(length: 4, nullable: true)]
    private ?string $pdkc_egal_pdkr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pdk_ref = null;

    #[ORM\Column(nullable: true)]
    private ?int $priorite_pilprod = null;

    #[ORM\Column(length: 14, nullable: true)]
    private ?string $prm = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $regime = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut_contrat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tranche = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type_production = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_import = null;

    #[ORM\OneToMany(mappedBy: 'prm', targetEntity: SilencieuxActions::class)]
    private Collection $silencieuxActions;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etat_silence = null;

    #[ORM\OneToMany(mappedBy: 'prm', targetEntity: SilEmail::class)]
    private Collection $silEmails;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_entree_cause_silence = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Champs_t = null;

    #[ORM\Column(nullable: true)]
    private ?bool $traite = null;

    public function __construct()
    {
        $this->silencieuxActions = new ArrayCollection();
        $this->silEmails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriorite(): ?string
    {
        return $this->priorite;
    }

    public function setPriorite(string $priorite): static
    {
        $this->priorite = $priorite;

        return $this;
    }

    public function getCauseSilence(): ?string
    {
        return $this->cause_silence;
    }

    public function setCauseSilence(?string $cause_silence): static
    {
        $this->cause_silence = $cause_silence;

        return $this;
    }

    public function getProbabiliteDefaillance(): ?string
    {
        return $this->probabilite_defaillance;
    }

    public function setProbabiliteDefaillance(?string $probabilite_defaillance): static
    {
        $this->probabilite_defaillance = $probabilite_defaillance;

        return $this;
    }

    public function getPresenceDaC(): ?string
    {
        return $this->presence_da_c;
    }

    public function setPresenceDaC(?string $presence_da_c): static
    {
        $this->presence_da_c = $presence_da_c;

        return $this;
    }

    public function getPresenceDaK(): ?string
    {
        return $this->presence_da_k;
    }

    public function setPresenceDaK(?string $presence_da_k): static
    {
        $this->presence_da_k = $presence_da_k;

        return $this;
    }

    public function getPresenceDitC(): ?string
    {
        return $this->presence_dit_c;
    }

    public function setPresenceDitC(?string $presence_dit_c): static
    {
        $this->presence_dit_c = $presence_dit_c;

        return $this;
    }

    public function getPresenceDitK(): ?string
    {
        return $this->presence_dit_k;
    }

    public function setPresenceDitK(?string $presence_dit_k): static
    {
        $this->presence_dit_k = $presence_dit_k;

        return $this;
    }

    public function getDr(): ?string
    {
        return $this->dr;
    }

    public function setDr(?string $dr): static
    {
        $this->dr = $dr;

        return $this;
    }

    public function getAffaireL001(): ?string
    {
        return $this->affaire_l001;
    }

    public function setAffaireL001(?string $affaire_l001): static
    {
        $this->affaire_l001 = $affaire_l001;

        return $this;
    }

    public function getAgenceIntervention(): ?string
    {
        return $this->agence_intervention;
    }

    public function setAgenceIntervention(?string $agence_intervention): static
    {
        $this->agence_intervention = $agence_intervention;

        return $this;
    }

    public function getBaseOp(): ?string
    {
        return $this->base_op;
    }

    public function setBaseOp(?string $base_op): static
    {
        $this->base_op = $base_op;

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

    public function getCompteur(): ?string
    {
        return $this->compteur;
    }

    public function setCompteur(?string $compteur): static
    {
        $this->compteur = $compteur;

        return $this;
    }

    public function getConstructeur(): ?string
    {
        return $this->constructeur;
    }

    public function setConstructeur(?string $constructeur): static
    {
        $this->constructeur = $constructeur;

        return $this;
    }

    public function getDateOuvertureDaC(): ?\DateTimeInterface
    {
        return $this->date_ouverture_da_c;
    }

    public function setDateOuvertureDaC(?\DateTimeInterface $date_ouverture_da_c): static
    {
        $this->date_ouverture_da_c = $date_ouverture_da_c;

        return $this;
    }

    public function getDateDerniereCollecte(): ?\DateTimeInterface
    {
        return $this->date_derniere_collecte;
    }

    public function setDateDerniereCollecte(?\DateTimeInterface $date_derniere_collecte): static
    {
        $this->date_derniere_collecte = $date_derniere_collecte;

        return $this;
    }

    public function getIdDepart(): ?string
    {
        return $this->id_depart;
    }

    public function setIdDepart(?string $id_depart): static
    {
        $this->id_depart = $id_depart;

        return $this;
    }

    public function getAccessibilite(): ?string
    {
        return $this->accessibilite;
    }

    public function setAccessibilite(?string $accessibilite): static
    {
        $this->accessibilite = $accessibilite;

        return $this;
    }

    public function getCauseGenerale(): ?string
    {
        return $this->cause_generale;
    }

    public function setCauseGenerale(?string $cause_generale): static
    {
        $this->cause_generale = $cause_generale;

        return $this;
    }

    public function getNbLigne(): ?int
    {
        return $this->nb_ligne;
    }

    public function setNbLigne(?int $nb_ligne): static
    {
        $this->nb_ligne = $nb_ligne;

        return $this;
    }

    public function getNbJourNonCollecte(): ?int
    {
        return $this->nb_jour_non_collecte;
    }

    public function setNbJourNonCollecte(?int $nb_jour_non_collecte): static
    {
        $this->nb_jour_non_collecte = $nb_jour_non_collecte;

        return $this;
    }

    public function getNbJourNonCollecte23h59(): ?int
    {
        return $this->nb_jour_non_collecte_23h59;
    }

    public function setNbJourNonCollecte23h59(?int $nb_jour_non_collecte_23h59): static
    {
        $this->nb_jour_non_collecte_23h59 = $nb_jour_non_collecte_23h59;

        return $this;
    }

    public function getTechno(): ?string
    {
        return $this->techno;
    }

    public function setTechno(?string $techno): static
    {
        $this->techno = $techno;

        return $this;
    }

    public function getPdkCom(): ?string
    {
        return $this->pdk_com;
    }

    public function setPdkCom(?string $pdk_com): static
    {
        $this->pdk_com = $pdk_com;

        return $this;
    }

    public function getPdkcEgalPdkr(): ?string
    {
        return $this->pdkc_egal_pdkr;
    }

    public function setPdkcEgalPdkr(?string $pdkc_egal_pdkr): static
    {
        $this->pdkc_egal_pdkr = $pdkc_egal_pdkr;

        return $this;
    }

    public function getPdkRef(): ?string
    {
        return $this->pdk_ref;
    }

    public function setPdkRef(?string $pdk_ref): static
    {
        $this->pdk_ref = $pdk_ref;

        return $this;
    }

    public function getPrioritePilprod(): ?int
    {
        return $this->priorite_pilprod;
    }

    public function setPrioritePilprod(?int $priorite_pilprod): static
    {
        $this->priorite_pilprod = $priorite_pilprod;

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

    public function getRegime(): ?string
    {
        return $this->regime;
    }

    public function setRegime(?string $regime): static
    {
        $this->regime = $regime;

        return $this;
    }

    public function getStatutContrat(): ?string
    {
        return $this->statut_contrat;
    }

    public function setStatutContrat(?string $statut_contrat): static
    {
        $this->statut_contrat = $statut_contrat;

        return $this;
    }

    public function getTranche(): ?string
    {
        return $this->tranche;
    }

    public function setTranche(?string $tranche): static
    {
        $this->tranche = $tranche;

        return $this;
    }

    public function getTypeProduction(): ?string
    {
        return $this->type_production;
    }

    public function setTypeProduction(?string $type_production): static
    {
        $this->type_production = $type_production;

        return $this;
    }

    public function getDateImport(): ?\DateTimeInterface
    {
        return $this->date_import;
    }

    public function setDateImport(?\DateTimeInterface $date_import): static
    {
        $this->date_import = $date_import;

        return $this;
    }

    /**
     * @return Collection<int, SilencieuxActions>
     */
    public function getSilencieuxActions(): Collection
    {
        return $this->silencieuxActions;
    }

    public function addSilencieuxAction(SilencieuxActions $silencieuxAction): static
    {
        if (!$this->silencieuxActions->contains($silencieuxAction)) {
            $this->silencieuxActions->add($silencieuxAction);
            $silencieuxAction->setPrm($this);
        }

        return $this;
    }

    public function removeSilencieuxAction(SilencieuxActions $silencieuxAction): static
    {
        if ($this->silencieuxActions->removeElement($silencieuxAction)) {
            // set the owning side to null (unless already changed)
            if ($silencieuxAction->getPrm() === $this) {
                $silencieuxAction->setPrm(null);
            }
        }

        return $this;
    }

    public function getEtatSilence(): ?string
    {
        return $this->etat_silence;
    }

    public function setEtatSilence(?string $etat_silence): static
    {
        $this->etat_silence = $etat_silence;

        return $this;
    }

    /**
     * @return Collection<int, SilEmail>
     */
    public function getSilEmails(): Collection
    {
        return $this->silEmails;
    }

    public function addSilEmail(SilEmail $silEmail): static
    {
        if (!$this->silEmails->contains($silEmail)) {
            $this->silEmails->add($silEmail);
            $silEmail->setPrm($this);
        }

        return $this;
    }

    public function removeSilEmail(SilEmail $silEmail): static
    {
        if ($this->silEmails->removeElement($silEmail)) {
            // set the owning side to null (unless already changed)
            if ($silEmail->getPrm() === $this) {
                $silEmail->setPrm(null);
            }
        }

        return $this;
    }

    public function getDateEntreeCauseSilence(): ?\DateTimeInterface
    {
        return $this->date_entree_cause_silence;
    }

    public function setDateEntreeCauseSilence(?\DateTimeInterface $date_entree_cause_silence): static
    {
        $this->date_entree_cause_silence = $date_entree_cause_silence;

        return $this;
    }

    public function getChampsT(): ?string
    {
        return $this->Champs_t;
    }

    public function setChampsT(?string $Champs_t): static
    {
        $this->Champs_t = $Champs_t;

        return $this;
    }

    public function isTraite(): ?bool
    {
        return $this->traite;
    }

    public function setTraite(?bool $traite): static
    {
        $this->traite = $traite;

        return $this;
    }
}
