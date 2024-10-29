<?php

namespace App\Entity;

use App\Repository\DeckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeckRepository::class)]
class Deck
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $ranking = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $grade = null;

    #[ORM\OneToOne(mappedBy: 'deck', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    /**
     * @var Collection<int, Mat>
     */
    #[ORM\OneToMany(targetEntity: Mat::class, mappedBy: 'deck')]
    private Collection $mats;

    public function __construct()
    {
        $this->mats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRanking(): ?int
    {
        return $this->ranking;
    }

    public function setRanking(int $ranking): static
    {
        $this->ranking = $ranking;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(?string $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        // set the owning side of the relation if necessary
        if ($user->getDeck() !== $this) {
            $user->setDeck($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Mat>
     */
    public function getMats(): Collection
    {
        return $this->mats;
    }

    public function addMat(Mat $mat): static
    {
        if (!$this->mats->contains($mat)) {
            $this->mats->add($mat);
            $mat->setDeck($this);
        }

        return $this;
    }

    public function removeMat(Mat $mat): static
    {
        if ($this->mats->removeElement($mat)) {
            // set the owning side to null (unless already changed)
            if ($mat->getDeck() === $this) {
                $mat->setDeck(null);
            }
        }

        return $this;
    }
}
