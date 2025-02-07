<?php

namespace App\Entity;


use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CatRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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
    #[Assert\LessThan('today', message: "La date de naissance ne peut pas être future.")]
    private ?\DateTimeInterface $dateBirth = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $city = null;

    #[ORM\Column]
    private ?bool $litter = null;    

    #[ORM\ManyToOne(inversedBy: 'cats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'cat', orphanRemoval: true)]
    private Collection $images;

    /**
     * @var Collection<int, Breed>
     */
    #[ORM\ManyToMany(targetEntity: Breed::class, mappedBy: 'cats', cascade: ['persist'])]
    private Collection $breeds;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateProfile = null;

    #[ORM\Column]
    private ?bool $vaccinated = null;

    /**
     * @var Collection<int, Matche>
     */
    #[ORM\OneToMany(targetEntity: Matche::class, mappedBy: 'catOne', orphanRemoval: true)]
    private Collection $matches;

    /**
     * @var Collection<int, Like>
     */
    #[ORM\OneToMany(targetEntity: Like::class, mappedBy: 'catOne', orphanRemoval: true)]
    private Collection $likes;

    /**
     * @var Collection<int, Coat>
     */
    #[ORM\ManyToMany(targetEntity: Coat::class, mappedBy: 'cats')]
    private Collection $coats;

  

    public function __construct()
    {
        $this->dateProfile = new \DateTime();
        $this->images = new ArrayCollection();
        $this->breeds = new ArrayCollection();
        $this->matches = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->coats = new ArrayCollection();
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

    public function getLitterStatut(): string
    {
        if ($this->litter === true) 
        {
            return 'Oui';
        } else {
            return 'Non';
        }
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

  
    public function getDateProfile(): ?\DateTimeInterface
    {
        return $this->dateProfile;
    }

    public function setDateProfile(\DateTimeInterface $dateProfile): static
    {
        $this->dateProfile = $dateProfile;

        return $this;
    }

    public function getAge(): ?int //Fonction pour calculer l'âge et l'utiliser dans des calculs
    {
        $now = new \DateTime();
        $interval = $this->dateBirth->diff($now);

        return $interval->y;
    }

    public function getAgeFormatted(): ?string //Fonction qui renvoie l'âge sous forme de chaîne de caractères
    {
        //interval entre la date d'aujourd'hui et la date de naissance du chat pour calculer l'âge
       $now = new \DateTime();
       $interval = $this->dateBirth->diff($now);
       
       $year = $interval->y;
       $month = $interval->m;

       //chaine de caractère qui renverra l'âge
       $newAge = '';

       //si le chat a plus d'un an
       if ($year > 1) {
        $newAge .= $year. " ans"; //on met au pluriel
       } else if ($year === 1) {
        $newAge .=$year. " an"; //si le chat a un an tout pile on met au singulier
       }

       //si le chat a un ou plusieurs mois
       if ($month > 0) {
        //si la chaîne de caractère newAge n'est pas vide on ajout "et"
        if ($newAge !== '') {
            $newAge .= " et ";
        }
        $newAge .= $month. " mois";
        
       }

       return $newAge;
    }

    public function __toString() 
    {
        return $this->name;
    }

    public function isVaccinated(): ?bool
    {
        return $this->vaccinated;
    }

    public function setVaccinated(bool $vaccinated): static
    {
        $this->vaccinated = $vaccinated;

        return $this;
    }

    public function getVaccinatedStatut(): string
    {
        if ($this->vaccinated === true) 
        {
            return 'Oui';
        } else {
            return 'Non';
        }
    }

        /**
     * @return Collection<int, Match>
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }

    public function addMatche(Matche $matche): static
    {
        if (!$this->matches->contains($matche)) {
            $this->matches->add($matche);
            $matche->setCatOne($this);
        }

        return $this;
    }

    public function removeMatche(Matche $matche): static
    {
        if ($this->matches->removeElement($matche)) {
            // set the owning side to null (unless already changed)
            if ($matche->getCatOne() === $this) {
                $matche->setCatOne(null);
            }
        }

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
            $like->setCatOne($this);
        }

        return $this;
    }

    public function removeLike(Like $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getCatOne() === $this) {
                $like->setCatOne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Coat>
     */
    public function getCoats(): Collection
    {
        return $this->coats;
    }

    public function addCoat(Coat $coat): static
    {
        if (!$this->coats->contains($coat)) {
            $this->coats->add($coat);
            $coat->addCat($this);
        }

        return $this;
    }

    public function removeCoat(Coat $coat): static
    {
        if ($this->coats->removeElement($coat)) {
            $coat->removeCat($this);
        }

        return $this;
    }


}
