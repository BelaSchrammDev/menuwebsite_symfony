<?php

namespace App\Entity;

use App\Repository\KategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity(repositoryClass: KategorieRepository::class)]
class Kategorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Gericht::class, mappedBy: 'kategorie')]
    private Collection $gerichte;

    public function __construct()
    {
        $this->gerichte = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Gericht>
     */
    public function getGerichte(): Collection
    {
        return $this->gerichte;
    }

    public function addGericht(Gericht $gerichte): static
    {
        if (!$this->gerichte->contains($gerichte)) {
            $this->gerichte->add($gerichte);
            $gerichte->setKategorie($this);
        }

        return $this;
    }

    public function removeGericht(Gericht $gerichte): static
    {
        if ($this->gerichte->removeElement($gerichte)) {
            // set the owning side to null (unless already changed)
            if ($gerichte->getKategorie() === $this) {
                $gerichte->setKategorie(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function addGerichte(Gericht $gerichte): static
    {
        if (!$this->gerichte->contains($gerichte)) {
            $this->gerichte->add($gerichte);
            $gerichte->setKategorie($this);
        }

        return $this;
    }

    public function removeGerichte(Gericht $gerichte): static
    {
        if ($this->gerichte->removeElement($gerichte)) {
            // set the owning side to null (unless already changed)
            if ($gerichte->getKategorie() === $this) {
                $gerichte->setKategorie(null);
            }
        }

        return $this;
    }
}
