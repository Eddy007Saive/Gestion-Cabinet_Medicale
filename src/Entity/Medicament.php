<?php

namespace App\Entity;

use App\Repository\MedicamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: MedicamentRepository::class)]
#[Broadcast]
class Medicament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $NOM = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DATE_EXP = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DATE_FAB = null;

    #[ORM\Column(length: 100)]
    private ?string $Dosage = null;

    #[ORM\Column]
    private ?int $PRIX = null;

    #[ORM\Column]
    private ?int $QT = null;

  

    #[ORM\Column(length: 100)]
    private ?string $PHOTOS = null;

    #[ORM\ManyToOne(inversedBy: 'medicaments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Forme $ID_FORME = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $INGREDIENT = null;

    #[ORM\ManyToMany(targetEntity: Consultation::class, mappedBy: 'MEDICAMENTS')]
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

    public function getDATEEXP(): ?\DateTimeInterface
    {
        return $this->DATE_EXP;
    }

    public function setDATEEXP(\DateTimeInterface $DATE_EXP): static
    {
        $this->DATE_EXP = $DATE_EXP;

        return $this;
    }

    public function getDATEFAB(): ?\DateTimeInterface
    {
        return $this->DATE_FAB;
    }

    public function setDATEFAB(\DateTimeInterface $DATE_FAB): static
    {
        $this->DATE_FAB = $DATE_FAB;

        return $this;
    }

   

    public function getDosage(): ?string
    {
        return $this->Dosage;
    }

    public function setDosage(string $Dosage): static
    {
        $this->Dosage = $Dosage;

        return $this;
    }

    public function getPRIX(): ?int
    {
        return $this->PRIX;
    }

    public function setPRIX(int $PRIX): static
    {
        $this->PRIX = $PRIX;

        return $this;
    }

    public function getQT(): ?int
    {
        return $this->QT;
    }

    public function setQT(int $QT): static
    {
        $this->QT = $QT;

        return $this;
    }


    public function getPHOTOS(): ?string
    {
        return $this->PHOTOS;
    }

    public function setPHOTOS(string $PHOTOS): static
    {
        $this->PHOTOS = $PHOTOS;

        return $this;
    }

    public function getIDFORME(): ?Forme
    {
        return $this->ID_FORME;
    }

    public function setIDFORME(?Forme $ID_FORME): static
    {
        $this->ID_FORME = $ID_FORME;

        return $this;
    }

    public function getINGREDIENT(): ?string
    {
        return $this->INGREDIENT;
    }

    public function setINGREDIENT(string $INGREDIENT): static
    {
        $this->INGREDIENT = $INGREDIENT;

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
            $consultation->addMEDICAMENT($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): static
    {
        if ($this->consultations->removeElement($consultation)) {
            $consultation->removeMEDICAMENT($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->NOM;;
    }
}
