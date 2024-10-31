<?php

namespace App\Entity;

use App\Repository\VaccineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VaccineRepository::class)]
class Vaccine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $vaccineName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVaccineName(): ?string
    {
        return $this->vaccineName;
    }

    public function setVaccineName(string $vaccineName): static
    {
        $this->vaccineName = $vaccineName;

        return $this;
    }


}
