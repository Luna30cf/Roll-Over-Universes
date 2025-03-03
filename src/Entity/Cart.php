<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\User;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'cart')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: CartArticle::class, cascade: ['persist', 'remove'])]
    private Collection $cartArticles;

    public function __construct()
    {
        $this->cartArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getCartArticles(): Collection
    {
        return $this->cartArticles;
    }

    public function addCartArticle(CartArticle $cartArticle): self
    {
        if (!$this->cartArticles->contains($cartArticle)) {
            $this->cartArticles->add($cartArticle);
            $cartArticle->setCart($this);
        }
        return $this;
    }

    public function removeCartArticle(CartArticle $cartArticle): self
    {
        if ($this->cartArticles->removeElement($cartArticle)) {
            if ($cartArticle->getCart() === $this) {
                $cartArticle->setCart(null);
            }
        }
        return $this;
    }
}
