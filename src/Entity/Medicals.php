<?php

namespace App\Entity;

use App\Repository\MedicalsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicalsRepository::class)]
class Medicals
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $PZN = null;

    #[ORM\Column(length: 255)]
    private ?string $darreichung = null;

    #[ORM\Column(length: 255)]
    private ?string $marke = null;

    #[ORM\Column(length: 255)]
    private ?string $details = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $preis = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPZN(): ?string
    {
        return $this->PZN;
    }

    public function setPZN(string $PZN): self
    {
        $this->PZN = $PZN;

        return $this;
    }

    public function getDarreichung(): ?string
    {
        return $this->darreichung;
    }

    public function setDarreichung(string $darreichung): self
    {
        $this->darreichung = $darreichung;

        return $this;
    }

    public function getMarke(): ?string
    {
        return $this->marke;
    }

    public function setMarke(string $marke): self
    {
        $this->marke = $marke;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getPreis(): ?string
    {
        return $this->preis;
    }

    public function setPreis(string $preis): self
    {
        $this->preis = $preis;

        return $this;
    }
}
