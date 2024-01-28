<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DATE_CONS = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $ID_PATIENT = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $SYMPTOME = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $DIAGNOSTIC = null;

    #[ORM\ManyToMany(targetEntity: Medicament::class, inversedBy: 'consultations')]
    private Collection $MEDICAMENTS;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Medecin $ID_MEDECIN = null;

    public function __construct()
    {
        $this->MEDICAMENTS = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDATECONS(): ?\DateTimeInterface
    {
        return $this->DATE_CONS;
    }

    public function setDATECONS(\DateTimeInterface $DATE_CONS): static
    {
        $this->DATE_CONS = $DATE_CONS;

        return $this;
    }

    public function getIDPATIENT(): ?Patient
    {
        return $this->ID_PATIENT;
    }

    public function setIDPATIENT(?Patient $ID_PATIENT): static
    {
        $this->ID_PATIENT = $ID_PATIENT;

        return $this;
    }

    public function getSYMPTOME(): ?string
    {
        return $this->SYMPTOME;
    }

    public function setSYMPTOME(string $SYMPTOME): static
    {
        $this->SYMPTOME = $SYMPTOME;

        return $this;
    }

    public function getDIAGNOSTIC(): ?string
    {
        return $this->DIAGNOSTIC;
    }

    public function setDIAGNOSTIC(string $DIAGNOSTIC): static
    {
        $this->DIAGNOSTIC = $DIAGNOSTIC;

        return $this;
    }

    /**
     * @return Collection<int, Medicament>
     */
    public function getMEDICAMENTS(): Collection
    {
        return $this->MEDICAMENTS;
    }

    public function addMEDICAMENT(Medicament $mEDICAMENT): static
    {
        if (!$this->MEDICAMENTS->contains($mEDICAMENT)) {
            $this->MEDICAMENTS->add($mEDICAMENT);
        }

        return $this;
    }

    public function removeMEDICAMENT(Medicament $mEDICAMENT): static
    {
        $this->MEDICAMENTS->removeElement($mEDICAMENT);

        return $this;
    }

    public function getIDMEDECIN(): ?Medecin
    {
        return $this->ID_MEDECIN;
    }

    public function setIDMEDECIN(?Medecin $ID_MEDECIN): static
    {
        $this->ID_MEDECIN = $ID_MEDECIN;

        return $this;
    }


}
