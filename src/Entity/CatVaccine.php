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
    private ?Cat $cats = null;

    #[ORM\ManyToOne(inversedBy: 'catVaccines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vaccine $vaccines = null;

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

    public function getCats(): ?Cat
    {
        return $this->cats;
    }

    public function setCats(?Cat $cats): static
    {
        $this->cats = $cats;

        return $this;
    }

    public function getVaccines(): ?Vaccine
    {
        return $this->vaccines;
    }

    public function setVaccines(?Vaccine $vaccines): static
    {
        $this->vaccines = $vaccines;

        return $this;
    }
}
