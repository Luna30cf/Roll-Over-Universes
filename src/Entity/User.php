<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $balance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pictureProfile = null;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    #[ORM\OneToMany(targetEntity: Invoice::class, mappedBy: 'user')]
    private Collection $invoices;

    #[ORM\ManyToMany(targetEntity: Article::class, mappedBy: 'liked')]
    private Collection $liked;

    #[ORM\Column(nullable: true)]
    private ?int $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $deliveryAddress = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Cart $cart = null;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
        $this->liked = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): static
    {
        $this->balance = $balance;
        return $this;
    }

    public function getPictureProfile(): ?string
    {
        return $this->pictureProfile;
    }

    public function setPictureProfile(?string $pictureProfile): static
    {
        $this->pictureProfile = $pictureProfile;
        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function getLiked(): Collection
    {
        return $this->liked;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?string $deliveryAddress): static
    {
        $this->deliveryAddress = $deliveryAddress;
        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): static
    {
        if ($cart && $cart->getUser() !== $this) {
            $cart->setUser($this);
        }
        $this->cart = $cart;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Implement this method if storing sensitive data in the entity
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
