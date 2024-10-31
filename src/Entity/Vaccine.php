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

    /**
     * @var Collection<int, Cat>
     */
    #[ORM\ManyToMany(targetEntity: Cat::class, mappedBy: 'vaccines')]
    private Collection $cats;

    public function __construct()
    {
        $this->cats = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Cat>
     */
    public function getCats(): Collection
    {
        return $this->cats;
    }

    public function addCat(Cat $cat): static
    {
        if (!$this->cats->contains($cat)) {
            $this->cats->add($cat);
            $cat->addVaccine($this);
        }

        return $this;
    }

    public function removeCat(Cat $cat): static
    {
        if ($this->cats->removeElement($cat)) {
            $cat->removeVaccine($this);
        }

        return $this;
    }
}
