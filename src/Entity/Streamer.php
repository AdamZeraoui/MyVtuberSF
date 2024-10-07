<?php

namespace App\Entity;

use App\Repository\StreamerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StreamerRepository::class)]
class Streamer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $pseudo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $stats = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $rarity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getStats(): ?string
    {
        return $this->stats;
    }

    public function setStats(?string $stats): static
    {
        $this->stats = $stats;

        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(?string $rarity): static
    {
        $this->rarity = $rarity;

        return $this;
    }
}
