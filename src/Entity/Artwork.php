<?php

namespace App\Entity;

use App\Repository\ArtworkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtworkRepository::class)]
#[ORM\Index(name: 'idx_artwork_title', columns: ['title'])]
#[ORM\Index(name: 'idx_artwork_creation_date', columns: ['creation_date'])]
class Artwork
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $creationDate = null;

    #[ORM\Column(length: 255)]
    private ?string $imageUrl = null;
    
    #[ORM\ManyToOne(inversedBy: 'artworks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artist $artist = null;

    /**
     * @var Collection<int, VirtualTour>
     */
    #[ORM\ManyToMany(targetEntity: VirtualTour::class, mappedBy: 'artworks')]
    private Collection $VirtualTours;

    public function __construct()
    {
        $this->VirtualTours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreationDate(): ?\DateTime
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTime $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): static
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * @return Collection<int, VirtualTour>
     */
    public function getVirtualTours(): Collection
    {
        return $this->VirtualTours;
    }

    public function addVirtualTour(VirtualTour $virtualTour): static
    {
        if (!$this->VirtualTours->contains($virtualTour)) {
            $this->VirtualTours->add($virtualTour);
            $virtualTour->addArtwork($this);
        }

        return $this;
    }

    public function removeVirtualTour(VirtualTour $virtualTour): static
    {
        if ($this->VirtualTours->removeElement($virtualTour)) {
            $virtualTour->removeArtwork($this);
        }

        return $this;
    }
}
