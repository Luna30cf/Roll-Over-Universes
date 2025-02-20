<?php

namespace App\Entity;

use App\Repository\ThemesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemesRepository::class)]
class Themes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    /**
     * @var Collection<int, Article>
     */
    #[ORM\ManyToMany(targetEntity: Article::class, mappedBy: 'Theme')]
    private Collection $Products;

    public function __construct()
    {
        $this->Products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getProducts(): Collection
    {
        return $this->Products;
    }

    public function addProduct(Article $product): static
    {
        if (!$this->Products->contains($product)) {
            $this->Products->add($product);
            $product->addTheme($this);
        }

        return $this;
    }

    public function removeProduct(Article $product): static
    {
        if ($this->Products->removeElement($product)) {
            $product->removeTheme($this);
        }

        return $this;
    }
}
