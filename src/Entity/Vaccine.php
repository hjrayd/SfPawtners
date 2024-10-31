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
     * @var Collection<int, CatVaccine>
     */
    #[ORM\OneToMany(targetEntity: CatVaccine::class, mappedBy: 'vaccine', orphanRemoval: true)]
    private Collection $catVaccines;

    public function __construct()
    {
        $this->catVaccines = new ArrayCollection();
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
     * @return Collection<int, CatVaccine>
     */
    public function getCatVaccines(): Collection
    {
        return $this->catVaccines;
    }

    public function addCatVaccine(CatVaccine $catVaccine): static
    {
        if (!$this->catVaccines->contains($catVaccine)) {
            $this->catVaccines->add($catVaccine);
            $catVaccine->setVaccine($this);
        }

        return $this;
    }

    public function removeCatVaccine(CatVaccine $catVaccine): static
    {
        if ($this->catVaccines->removeElement($catVaccine)) {
            // set the owning side to null (unless already changed)
            if ($catVaccine->getVaccine() === $this) {
                $catVaccine->setVaccine(null);
            }
        }

        return $this;
    }

   


}
