<?php

namespace App\Entity;

use App\Repository\MatchesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchesRepository::class)]
class Matches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateMatch = null;

    #[ORM\Column(length: 50)]
    private ?string $statutMatch = null;

    #[ORM\ManyToOne(inversedBy: 'matches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cat $catOne = null;

    #[ORM\ManyToOne(inversedBy: 'matches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cat $catTwo = null;

    public function __construct()
    {
        $this->dateMatch = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMatch(): ?\DateTimeInterface
    {
        return $this->dateMatch;
    }

    public function setDateMatch(\DateTimeInterface $dateMatch): static
    {
        $this->dateMatch = $dateMatch;

        return $this;
    }

    public function getStatutMatch(): ?string
    {
        return $this->statutMatch;
    }

    public function setStatutMatch(string $statutMatch): static
    {
        $this->statutMatch = $statutMatch;

        return $this;
    }

    public function getCatOne(): ?Cat
    {
        return $this->catOne;
    }

    public function setCatOne(?Cat $catOne): static
    {
        $this->catOne = $catOne;

        return $this;
    }

    public function getCatTwo(): ?Cat
    {
        return $this->catTwo;
    }

    public function setCatTwo(?Cat $catTwo): static
    {
        $this->catTwo = $catTwo;

        return $this;
    }
}
