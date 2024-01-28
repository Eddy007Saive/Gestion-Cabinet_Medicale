<?php

namespace App\Entity;

use App\Repository\SpecialiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: SpecialiteRepository::class)]
#[Broadcast]
class Specialite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $SPECIALITE = null;

    #[ORM\OneToMany(mappedBy: 'SPECIALITE', targetEntity: Medecin::class)]
    private Collection $medecins;

    public function __construct()
    {
        $this->medecins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSPECIALITE(): ?string
    {
        return $this->SPECIALITE;
    }

    public function setSPECIALITE(string $SPECIALITE): static
    {
        $this->SPECIALITE = $SPECIALITE;

        return $this;
    }

    /**
     * @return Collection<int, Medecin>
     */
    public function getMedecins(): Collection
    {
        return $this->medecins;
    }

    public function addMedecin(Medecin $medecin): static
    {
        if (!$this->medecins->contains($medecin)) {
            $this->medecins->add($medecin);
            $medecin->setSPECIALITE($this);
        }

        return $this;
    }

    public function removeMedecin(Medecin $medecin): static
    {
        if ($this->medecins->removeElement($medecin)) {
            // set the owning side to null (unless already changed)
            if ($medecin->getSPECIALITE() === $this) {
                $medecin->setSPECIALITE(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->SPECIALITE;
    }
}
