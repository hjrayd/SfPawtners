<?php

namespace App\Entity;

use App\Repository\CoatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoatRepository::class)]
class Coat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $CoatName = null;

    /**
     * @var Collection<int, Cat>
     */
    #[ORM\ManyToMany(targetEntity: Cat::class, inversedBy: 'coats')]
    private Collection $cats;

    public function __construct()
    {
        $this->cats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoatName(): ?string
    {
        return $this->CoatName;
    }

    public function setCoatName(string $CoatName): static
    {
        $this->CoatName = $CoatName;

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
        }

        return $this;
    }

    public function removeCat(Cat $cat): static
    {
        $this->cats->removeElement($cat);

        return $this;
    }
}
