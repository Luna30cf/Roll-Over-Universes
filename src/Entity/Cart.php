<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'Carts')]
    private Collection $User;

    /**
     * @var Collection<int, Article>
     */
    #[ORM\ManyToMany(targetEntity: Article::class)]
    private Collection $Product;

    public function __construct()
    {
        $this->User = new ArrayCollection();
        $this->Product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): static
    {
        if (!$this->User->contains($user)) {
            $this->User->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->User->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getProduct(): Collection
    {
        return $this->Product;
    }

    public function addProduct(Article $product): static
    {
        if (!$this->Product->contains($product)) {
            $this->Product->add($product);
        }

        return $this;
    }

    public function removeProduct(Article $product): static
    {
        $this->Product->removeElement($product);

        return $this;
    }
}
