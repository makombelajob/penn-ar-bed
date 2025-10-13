<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: \App\Repository\ContactMessageRepository::class)]
class ContactMessage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 180, nullable: true)]
    private ?string $subject = null;

    #[ORM\Column(type: 'text')]
    private string $message = '';

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $reply = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $repliedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(?string $email): self { $this->email = $email; return $this; }

    public function getSubject(): ?string { return $this->subject; }
    public function setSubject(?string $subject): self { $this->subject = $subject; return $this; }

    public function getMessage(): string { return $this->message; }
    public function setMessage(string $message): self { $this->message = $message; return $this; }

    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }

    public function getReply(): ?string { return $this->reply; }
    public function setReply(?string $reply): self { $this->reply = $reply; return $this; }

    public function getRepliedAt(): ?\DateTimeImmutable { return $this->repliedAt; }
    public function setRepliedAt(?\DateTimeImmutable $repliedAt): self { $this->repliedAt = $repliedAt; return $this; }
}


