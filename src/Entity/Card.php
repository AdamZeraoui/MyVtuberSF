<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardRepository::class)]
class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $stats = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $rarity = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'recrute')]
    private Collection $users;

    /**
     * @var Collection<int, Mat>
     */
    #[ORM\OneToMany(targetEntity: Mat::class, mappedBy: 'card')]
    private Collection $mat;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->mat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addRecrute($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeRecrute($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Mat>
     */
    public function getMat(): Collection
    {
        return $this->mat;
    }

    public function addMat(Mat $mat): static
    {
        if (!$this->mat->contains($mat)) {
            $this->mat->add($mat);
            $mat->setCard($this);
        }

        return $this;
    }

    public function removeMat(Mat $mat): static
    {
        if ($this->mat->removeElement($mat)) {
            // set the owning side to null (unless already changed)
            if ($mat->getCard() === $this) {
                $mat->setCard(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
