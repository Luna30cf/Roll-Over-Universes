<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Picture_profile = null;

    /**
     * @var Collection<int, Article>
     */
    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'Author')]
    private Collection $Publications;

    public function __construct()
    {
        $this->Publications = new ArrayCollection();
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

    public function getPictureProfile(): ?string
    {
        return $this->Picture_profile;
    }

    public function setPictureProfile(?string $Picture_profile): static
    {
        $this->Picture_profile = $Picture_profile;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getPublications(): Collection
    {
        return $this->Publications;
    }

    public function addPublication(Article $publication): static
    {
        if (!$this->Publications->contains($publication)) {
            $this->Publications->add($publication);
            $publication->setAuthor($this);
        }

        return $this;
    }

    public function removePublication(Article $publication): static
    {
        if ($this->Publications->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getAuthor() === $this) {
                $publication->setAuthor(null);
            }
        }

        return $this;
    }
}
