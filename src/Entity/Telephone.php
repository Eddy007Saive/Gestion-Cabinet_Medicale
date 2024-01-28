<?php

namespace App\Entity;

use App\Repository\TelephoneRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: TelephoneRepository::class)]
#[Broadcast]

class Telephone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $TELEPHONE = null;

    #[ORM\OneToOne(inversedBy: 'telephones', cascade: ['persist', 'remove'])]
    private ?Medecin $ID_MEDECIN = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Patient $ID_PATIENT = null;




   


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTELEPHONE(): ?string
    {
        return $this->TELEPHONE;
    }

    public function setTELEPHONE(string $TELEPHONE): static
    {
        $this->TELEPHONE = $TELEPHONE;

        return $this;
    }

    public function getIDMEDECIN(): ?Medecin
    {
        return $this->ID_MEDECIN;
    }

    public function setIDMEDECIN(?Medecin $ID_MEDECIN): self
    {
        $this->ID_MEDECIN = $ID_MEDECIN;

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

  

  

  
}
