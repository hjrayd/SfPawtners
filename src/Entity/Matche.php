<?php

namespace App\Entity;

use App\Repository\MatcheRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatcheRepository::class)]
class Matche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateMatch = null;

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

    public function getMatchDate(): string 
    {
        return $this->dateMatch->format('d.m.Y');
    }
}
