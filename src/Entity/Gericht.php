<?php

namespace App\Entity;

use App\Repository\GerichtRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GerichtRepository::class)]
class Gericht
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $beschreibung = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(nullable: true)]
    private ?float $preis = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setName(string $name): static
    {
        $this->name = $name;
        
        return $this;
    }
    
    public function getBeschreibung(): ?string
    {
        return $this->beschreibung;
    }
    
    public function setBeschreibung(?string $beschreibung): static
    {
        $this->beschreibung = $beschreibung;
        
        return $this;
    }
    
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPreis(): ?float
    {
        return $this->preis;
    }

    public function setPreis(?float $preis): static
    {
        $this->preis = $preis;

        return $this;
    }
}
