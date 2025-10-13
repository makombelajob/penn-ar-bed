<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: \App\Repository\PartnerRepository::class)]
class Partner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180)]
    private string $organization = '';

    #[ORM\Column(type: 'string', length: 180)]
    private string $email = '';

    #[ORM\Column(type: 'string', length: 80)]
    private string $partnershipType = 'Autre';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrganization(): string
    {
        return $this->organization;
    }

    public function setOrganization(string $organization): self
    {
        $this->organization = $organization;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPartnershipType(): string
    {
        return $this->partnershipType;
    }

    public function setPartnershipType(string $partnershipType): self
    {
        $this->partnershipType = $partnershipType;
        return $this;
    }
}


