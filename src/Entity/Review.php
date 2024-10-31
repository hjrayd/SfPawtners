<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $reviewContent = null;

    #[ORM\Column]
    private ?int $reviewRating = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $reviewer = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $reviewee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReviewContent(): ?string
    {
        return $this->reviewContent;
    }

    public function setReviewContent(string $reviewContent): static
    {
        $this->reviewContent = $reviewContent;

        return $this;
    }

    public function getReviewRating(): ?int
    {
        return $this->reviewRating;
    }

    public function setReviewRating(int $reviewRating): static
    {
        $this->reviewRating = $reviewRating;

        return $this;
    }

    public function getReviewer(): ?User
    {
        return $this->reviewer;
    }

    public function setReviewer(?User $reviewer): static
    {
        $this->reviewer = $reviewer;

        return $this;
    }

    public function getReviewee(): ?User
    {
        return $this->reviewee;
    }

    public function setReviewee(?User $reviewee): static
    {
        $this->reviewee = $reviewee;

        return $this;
    }
}
