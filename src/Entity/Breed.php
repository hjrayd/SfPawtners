<?php

namespace App\Entity;

use App\Repository\BreedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BreedRepository::class)]
class Breed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $breedName = null;

    /**
     * @var Collection<int, Cat>
     */
    #[ORM\ManyToMany(targetEntity: Cat::class, inversedBy: 'breeds')]
    private Collection $cats;

    public function __construct()
    {
        $this->cats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBreedName(): ?string
    {
        return $this->breedName;
    }

    public function setBreedName(string $breedName): static
    {
        $this->breedName = $breedName;

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
            $cat->addBreed($this);
        }

        return $this;
    }

    public function removeCat(Cat $cat): static
    {
        $this->cats->removeElement($cat);

        return $this;
    }

    public function __toString() 
    {
        return $this->breedName;
    }
}
