<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DefectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DefectRepository::class)]
#[ApiResource]
class Defect
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * @var Collection<int, MediaObject>
     */
    #[ORM\OneToMany(targetEntity: MediaObject::class, mappedBy: 'defect')]
    private Collection $Photo;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    public function __construct()
    {
        $this->Photo = new ArrayCollection();
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

    /**
     * @return Collection<int, MediaObject>
     */
    public function getPhoto(): Collection
    {
        return $this->Photo;
    }

    public function addPhoto(MediaObject $photo): static
    {
        if (!$this->Photo->contains($photo)) {
            $this->Photo->add($photo);
            $photo->setDefect($this);
        }

        return $this;
    }

    public function removePhoto(MediaObject $photo): static
    {
        if ($this->Photo->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getDefect() === $this) {
                $photo->setDefect(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }
}
