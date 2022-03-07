<?php

namespace App\Entity;

use App\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilmRepository::class)]
class Film
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text')]
    private $summary;

    #[ORM\Column(type: 'string', length: 255)]
    private $director;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'films')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\OneToMany(mappedBy: 'film', targetEntity: Impression::class, orphanRemoval: true)]
    private $impressions;

    public function __construct()
    {
        $this->impressions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): self
    {
        $this->director = $director;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Impression>
     */
    public function getImpressions(): Collection
    {
        return $this->impressions;
    }

    public function addImpression(Impression $impression): self
    {
        if (!$this->impressions->contains($impression)) {
            $this->impressions[] = $impression;
            $impression->setFilm($this);
        }

        return $this;
    }

    public function removeImpression(Impression $impression): self
    {
        if ($this->impressions->removeElement($impression)) {
            // set the owning side to null (unless already changed)
            if ($impression->getFilm() === $this) {
                $impression->setFilm(null);
            }
        }

        return $this;
    }
}
