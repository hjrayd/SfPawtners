<?php

namespace App\Entity;

use App\Repository\CatVaccineRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatVaccineRepository::class)]
class CatVaccine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateVaccine = null;

    #[ORM\ManyToOne(inversedBy: 'catVaccines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cat $cat = null;

    #[ORM\ManyToOne(inversedBy: 'catVaccines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vaccine $vaccine = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVaccine(): ?\DateTimeInterface
    {
        return $this->dateVaccine;
    }

    public function setDateVaccine(\DateTimeInterface $dateVaccine): static
    {
        $this->dateVaccine = $dateVaccine;

        return $this;
    }

    public function getCat(): ?Cat
    {
        return $this->cat;
    }

    public function setCat(?Cat $cat): static
    {
        $this->cat = $cat;

        return $this;
    }

    public function getVaccine(): ?Vaccine
    {
        return $this->vaccine;
    }

    public function setVaccine(?Vaccine $vaccine): static
    {
        $this->vaccine = $vaccine;

        return $this;
    }

    public function __toString() 
    {
        return $this->dateVaccine;
    }

   
}
