<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Cover = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $Price = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Publication_date = null;

    #[ORM\Column]
    private ?int $Items_stored = null;

    /**
     * @var Collection<int, Themes>
     */
    #[ORM\ManyToMany(targetEntity: Themes::class, inversedBy: 'Products')]
    private Collection $Theme;

    #[ORM\ManyToOne(inversedBy: 'Products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $Category = null;

    #[ORM\ManyToOne(inversedBy: 'Publications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $Author = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'Liked')]
    private Collection $Liked;

    

    public function __construct()
    {
        $this->Theme = new ArrayCollection();
        $this->Liked = new ArrayCollection();
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

    public function getCover(): ?string
    {
        return $this->Cover;
    }

    public function setCover(?string $Cover): static
    {
        $this->Cover = $Cover;
        return $this;
    }
    

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->Price;
    }

    public function setPrice(string $Price): static
    {
        $this->Price = $Price;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->Publication_date;
    }

    public function setPublicationDate(\DateTimeInterface $Publication_date): static
    {
        $this->Publication_date = $Publication_date;

        return $this;
    }

    public function getItemsStored(): ?int
    {
        return $this->Items_stored;
    }

    public function setItemsStored(int $Items_stored): static
    {
        $this->Items_stored = $Items_stored;

        return $this;
    }

    /**
     * @return Collection<int, Themes>
     */
    public function getTheme(): Collection
    {
        return $this->Theme;
    }

    public function addTheme(Themes $theme): static
    {
        if (!$this->Theme->contains($theme)) {
            $this->Theme->add($theme);
        }

        return $this;
    }

    public function removeTheme(Themes $theme): static
    {
        $this->Theme->removeElement($theme);

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->Category;
    }

    public function setCategory(?Categories $category): static
    {
        $this->Category = $category;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->Author;
    }

    public function setAuthor(?Author $Author): static
    {
        $this->Author = $Author;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLiked(): Collection
    {
        return $this->Liked;
    }

    public function addLiked(User $liked): static
    {
        if (!$this->Liked->contains($liked)) {
            $this->Liked->add($liked);
        }

        return $this;
    }

    public function removeLiked(User $liked): static
    {
        $this->Liked->removeElement($liked);

        return $this;
    }

    
}
