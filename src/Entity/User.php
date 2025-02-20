<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Username = null;

    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[ORM\Column(length: 255)]
    private ?string $Password = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $Balance = null;

    #[ORM\Column(length: 255)]
    private ?string $Picture_profile = null;

    #[ORM\Column(length: 255)]
    private ?string $Role = null;

    /**
     * @var Collection<int, Cart>
     */
    #[ORM\ManyToMany(targetEntity: Cart::class, mappedBy: 'User')]
    private Collection $Carts;

    /**
     * @var Collection<int, Invoice>
     */
    #[ORM\OneToMany(targetEntity: Invoice::class, mappedBy: 'User')]
    private Collection $Invoices;

    /**
     * @var Collection<int, Article>
     */
    #[ORM\ManyToMany(targetEntity: Article::class, mappedBy: 'Liked')]
    private Collection $Liked;

    public function __construct()
    {
        $this->Carts = new ArrayCollection();
        $this->Invoices = new ArrayCollection();
        $this->Liked = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(string $Username): static
    {
        $this->Username = $Username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): static
    {
        $this->Password = $Password;

        return $this;
    }

    public function getBalance(): ?string
    {
        return $this->Balance;
    }

    public function setBalance(string $Balance): static
    {
        $this->Balance = $Balance;

        return $this;
    }

    public function getPictureProfile(): ?string
    {
        return $this->Picture_profile;
    }

    public function setPictureProfile(string $Picture_profile): static
    {
        $this->Picture_profile = $Picture_profile;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): static
    {
        $this->Role = $Role;

        return $this;
    }

    /**
     * @return Collection<int, Cart>
     */
    public function getCarts(): Collection
    {
        return $this->Carts;
    }

    public function addCart(Cart $cart): static
    {
        if (!$this->Carts->contains($cart)) {
            $this->Carts->add($cart);
            $cart->addUser($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): static
    {
        if ($this->Carts->removeElement($cart)) {
            $cart->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Invoice>
     */
    public function getInvoices(): Collection
    {
        return $this->Invoices;
    }

    public function addInvoice(Invoice $invoice): static
    {
        if (!$this->Invoices->contains($invoice)) {
            $this->Invoices->add($invoice);
            $invoice->setUser($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): static
    {
        if ($this->Invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getUser() === $this) {
                $invoice->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getLiked(): Collection
    {
        return $this->Liked;
    }

    public function addLiked(Article $liked): static
    {
        if (!$this->Liked->contains($liked)) {
            $this->Liked->add($liked);
            $liked->addLiked($this);
        }

        return $this;
    }

    public function removeLiked(Article $liked): static
    {
        if ($this->Liked->removeElement($liked)) {
            $liked->removeLiked($this);
        }

        return $this;
    }
}
