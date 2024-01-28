<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $NOM = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $PRENOM = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $photos = null;

    #[ORM\Column(length: 200)]
    private ?string $ADRESSE = null;

    #[ORM\OneToMany(mappedBy: 'ID_PATIENT', targetEntity: Consultation::class)]
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

    public function setPRENOM(?string $PRENOM): static
    {
        $this->PRENOM = $PRENOM;

        return $this;
    }

    public function getPhotos(): ?string
    {
        return $this->photos;
    }

    public function setPhotos(?string $photos): static
    {
        $this->photos = $photos;

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
    public function getImageUrl(): ?string
    {
        return '/uploads/media/' . $this->getPhotos();
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
            $consultation->setIDPATIENT($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): static
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getIDPATIENT() === $this) {
                $consultation->setIDPATIENT(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->NOM ." ". $this->PRENOM;
    }



}
