<?php

namespace App\Entity;

use App\Repository\CatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatRepository::class)]
class Cat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $gender = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateBirth = null;

    #[ORM\Column(length: 50)]
    private ?string $coat = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $city = null;

    #[ORM\Column]
    private ?bool $litter = null;    
    
    //on instancie l'objet avec cette valeur comme étant fausse
    #[ORM\Column]
    private ?bool $isLiked = false;

    #[ORM\ManyToOne(inversedBy: 'cats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'cat', orphanRemoval: true)]
    private Collection $images;

    /**
     * @var Collection<int, CatVaccine>
     */
    #[ORM\OneToMany(targetEntity: CatVaccine::class, mappedBy: 'cat', orphanRemoval: true)]
    private Collection $catVaccines;



    /**
     * @var Collection<int, Like>
     */
    #[ORM\OneToMany(targetEntity: Like::class, mappedBy: 'cat', orphanRemoval: true)]
    private Collection $likes;

    /**
     * @var Collection<int, Breed>
     */
    #[ORM\ManyToMany(targetEntity: Breed::class, mappedBy: 'cats')]
    private Collection $breeds;


    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->catVaccines = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->breeds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getDateBirth(): ?\DateTimeInterface
    {
        return $this->dateBirth;
    }

    public function setDateBirth(\DateTimeInterface $dateBirth): static
    {
        $this->dateBirth = $dateBirth;

        return $this;
    }

    public function getCoat(): ?string
    {
        return $this->coat;
    }

    public function setCoat(string $coat): static
    {
        $this->coat = $coat;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function isLitter(): ?bool
    {
        return $this->litter;
    }

    public function setLitter(bool $litter): static
    {
        $this->litter = $litter;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setCat($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getCat() === $this) {
                $image->setCat(null);
            }
        }

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
            $catVaccine->setCat($this);
        }

        return $this;
    }

    public function removeCatVaccine(CatVaccine $catVaccine): static
    {
        if ($this->catVaccines->removeElement($catVaccine)) {
            // set the owning side to null (unless already changed)
            if ($catVaccine->getCat() === $this) {
                $catVaccine->setCat(null);
            }
        }

        return $this;
    }

    public function isLiked(): ?bool
    {
        return $this->isLiked;
    }

    public function setLiked(bool $isLiked): static
    {
        $this->isLiked = $isLiked;

        return $this;
    }

    /**
     * @return Collection<int, Like>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): static
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setCat($this);
        }

        return $this;
    }

    public function removeLike(Like $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getCat() === $this) {
                $like->setCat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Breed>
     */
    public function getBreeds(): Collection
    {
        return $this->breeds;
    }

    public function addBreed(Breed $breed): static
    {
        if (!$this->breeds->contains($breed)) {
            $this->breeds->add($breed);
            $breed->addCat($this);
        }

        return $this;
    }

    public function removeBreed(Breed $breed): static
    {
        if ($this->breeds->removeElement($breed)) {
            $breed->removeCat($this);
        }

        return $this;
    }

}
