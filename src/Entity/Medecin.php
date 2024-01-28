<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
#[Broadcast]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $NOM = null;

    #[ORM\Column(length: 200)]
    private ?string $PRENOM = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $PHOTOS = null;

    #[ORM\Column(length: 200)]
    private ?string $ADRESSE = null;

    #[ORM\ManyToOne(inversedBy: 'medecins')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Specialite $SPECIALITE = null;


    #[ORM\OneToOne(mappedBy: 'ID_MEDECIN', cascade: ['persist', 'remove'])]
    private ?Telephone $telephones = null;

    #[ORM\OneToMany(mappedBy: 'ID_MEDECIN', targetEntity: Consultation::class)]
    private Collection $consultations;

    public function __construct()
    {
        $this->consultations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNOM(): ?string
    {
        return $this->NOM;
    }

    public function setNOM(string $NOM): static
    {
        $this->NOM = $NOM;

        return $this;
    }

    public function getPRENOM(): ?string
    {
        return $this->PRENOM;
    }

    public function setPRENOM(string $PRENOM): static
    {
        $this->PRENOM = $PRENOM;

        return $this;
    }

    public function getPHOTOS(): ?string
    {
        return $this->PHOTOS;
    }

    public function getImageUrl(): ?string
    {
        return '/uploads/media/' . $this->getPHOTOS();
    }

    public function setPHOTOS(?string $PHOTOS): static
    {
        $this->PHOTOS = $PHOTOS;

        return $this;
    }

    public function getADRESSE(): ?string
    {
        return $this->ADRESSE;
    }

    public function setADRESSE(string $ADRESSE): static
    {
        $this->ADRESSE = $ADRESSE;

        return $this;
    }


    public function getSPECIALITE(): ?Specialite
    {
        return $this->SPECIALITE;
    }

    public function setSPECIALITE(?Specialite $SPECIALITE): static
    {
        $this->SPECIALITE = $SPECIALITE;

        return $this;
    }

    public function __toString()
    {
        return $this->SPECIALITE;
    }

    public function getTelephones(): ?Telephone
    {
        return $this->telephones;
    }

    public function setTelephones(?Telephone $telephones): static
    {
        // unset the owning side of the relation if necessary
        if ($telephones === null && $this->telephones !== null) {
            $this->telephones->setIDMEDECIN(null);
        }

        // set the owning side of the relation if necessary
        if ($telephones !== null && $telephones->getIDMEDECIN() !== $this) {
            $telephones->setIDMEDECIN($this);
        }

        $this->telephones = $telephones;

        return $this;
    }

    /**
     * @return Collection<int, Consultation>
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): static
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations->add($consultation);
            $consultation->setIDMEDECIN($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): static
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getIDMEDECIN() === $this) {
                $consultation->setIDMEDECIN(null);
            }
        }

        return $this;
    }


}
