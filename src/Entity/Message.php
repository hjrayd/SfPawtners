<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $messageDate = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $messageContent = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $sender = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $receiver = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessageDate(): ?\DateTimeInterface
    {
        return $this->messageDate;
    }

    public function setMessageDate(\DateTimeInterface $messageDate): static
    {
        $this->messageDate = $messageDate;

        return $this;
    }

    public function getMessageContent(): ?string
    {
        return $this->messageContent;
    }

    public function setMessageContent(string $messageContent): static
    {
        $this->messageContent = $messageContent;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): static
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): static
    {
        $this->receiver = $receiver;

        return $this;
    }


}
