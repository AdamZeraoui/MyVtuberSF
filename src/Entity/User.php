<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USENAME', fields: ['usename'])]
#[UniqueEntity(fields: ['usename'], message: 'There is already an account with this usename')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $usename = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private bool $isVerified = false;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Agence $agence = null;

    /**
     * @var Collection<int, Streamer>
     */
    #[ORM\ManyToMany(targetEntity: Streamer::class, inversedBy: 'users')]
    private Collection $recrute;

    /**
     * @var Collection<int, Succes>
     */
    #[ORM\ManyToMany(targetEntity: Succes::class, inversedBy: 'users')]
    private Collection $debloque;

    public function __construct()
    {
        $this->recrute = new ArrayCollection();
        $this->debloque = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsename(): ?string
    {
        return $this->usename;
    }

    public function setUsename(string $usename): static
    {
        $this->usename = $usename;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->usename;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(Agence $agence): static
    {
        $this->agence = $agence;

        return $this;
    }

    /**
     * @return Collection<int, Streamer>
     */
    public function getRecrute(): Collection
    {
        return $this->recrute;
    }

    public function addRecrute(Streamer $recrute): static
    {
        if (!$this->recrute->contains($recrute)) {
            $this->recrute->add($recrute);
        }

        return $this;
    }

    public function removeRecrute(Streamer $recrute): static
    {
        $this->recrute->removeElement($recrute);

        return $this;
    }

    /**
     * @return Collection<int, Succes>
     */
    public function getDebloque(): Collection
    {
        return $this->debloque;
    }

    public function addDebloque(Succes $debloque): static
    {
        if (!$this->debloque->contains($debloque)) {
            $this->debloque->add($debloque);
        }

        return $this;
    }

    public function removeDebloque(Succes $debloque): static
    {
        $this->debloque->removeElement($debloque);

        return $this;
    }
}
