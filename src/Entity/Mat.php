<?php

namespace App\Entity;

use App\Repository\MatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatRepository::class)]
class Mat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    #[ORM\Column(nullable: true)]
    private ?bool $used = null;

    #[ORM\Column(nullable: true)]
    private ?int $view = null;

    #[ORM\ManyToOne(inversedBy: 'mat')]
    private ?Card $card = null;

    #[ORM\ManyToOne(inversedBy: 'mats')]
    private ?Deck $deck = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function isUsed(): ?bool
    {
        return $this->used;
    }

    public function setUsed(?bool $used): static
    {
        $this->used = $used;

        return $this;
    }

    public function getView(): ?int
    {
        return $this->view;
    }

    public function setView(?int $view): static
    {
        $this->view = $view;

        return $this;
    }

    public function getCard(): ?Card
    {
        return $this->card;
    }

    public function setCard(?Card $card): static
    {
        $this->card = $card;

        return $this;
    }

    public function getDeck(): ?Deck
    {
        return $this->deck;
    }

    public function setDeck(?Deck $deck): static
    {
        $this->deck = $deck;

        return $this;
    }
}
