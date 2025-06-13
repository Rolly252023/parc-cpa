<?php

namespace App\Entity;

use App\Repository\BridgeMeteoreDipoleBTRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BridgeMeteoreDipoleBTRepository::class)]
class BridgeMeteoreDipoleBT
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $gdo = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $code_gdo_ds = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_creation_sig = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_maj = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGdo(): ?string
    {
        return $this->gdo;
    }

    public function setGdo(?string $gdo): static
    {
        $this->gdo = $gdo;

        return $this;
    }

    public function getCodeGdoDs(): ?string
    {
        return $this->code_gdo_ds;
    }

    public function setCodeGdoDs(?string $code_gdo_ds): static
    {
        $this->code_gdo_ds = $code_gdo_ds;

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

    public function getDateCreationSig(): ?\DateTimeInterface
    {
        return $this->date_creation_sig;
    }

    public function setDateCreationSig(?\DateTimeInterface $date_creation_sig): static
    {
        $this->date_creation_sig = $date_creation_sig;

        return $this;
    }

    public function getDateMaj(): ?\DateTimeInterface
    {
        return $this->date_maj;
    }

    public function setDateMaj(?\DateTimeInterface $date_maj): static
    {
        $this->date_maj = $date_maj;

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
