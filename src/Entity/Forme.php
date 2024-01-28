<?php

namespace App\Entity;

use App\Repository\FormeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: FormeRepository::class)]
#[Broadcast]
class Forme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $FORME = null;

    #[ORM\OneToMany(mappedBy: 'ID_FORME', targetEntity: Medicament::class)]
    private Collection $medicaments;

    public function __construct()
    {
        $this->medicaments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFORME(): ?string
    {
        return $this->FORME;
    }

    public function setFORME(string $FORME): static
    {
        $this->FORME = $FORME;

        return $this;
    }

    /**
     * @return Collection<int, Medicament>
     */
    public function getMedicaments(): Collection
    {
        return $this->medicaments;
    }

    public function addMedicament(Medicament $medicament): static
    {
        if (!$this->medicaments->contains($medicament)) {
            $this->medicaments->add($medicament);
            $medicament->setIDFORME($this);
        }

        return $this;
    }

    public function removeMedicament(Medicament $medicament): static
    {
        if ($this->medicaments->removeElement($medicament)) {
            // set the owning side to null (unless already changed)
            if ($medicament->getIDFORME() === $this) {
                $medicament->setIDFORME(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
       return $this->FORME;   
    }
}
