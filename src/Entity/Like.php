<?php

namespace App\Entity;

use App\Repository\LikeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikeRepository::class)]
#[ORM\Table(name: '`like`')]
class Like
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateLike = null;

    #[ORM\ManyToOne(inversedBy: 'likes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cat $catOne = null;

    #[ORM\ManyToOne(inversedBy: 'likes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cat $catTwo = null;


    public function __construct()
    {
        $this->dateLike = new \DateTime();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateLike(): ?\DateTimeInterface
    {
        return $this->dateLike;
    }

    public function setDateLike(\DateTimeInterface $dateLike): static
    {
        $this->dateLike = $dateLike;

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
