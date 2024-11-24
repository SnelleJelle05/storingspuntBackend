<?php

   namespace App\Entity;

   use ApiPlatform\Metadata\ApiResource;
   use App\Repository\DefectRepository;
   use Doctrine\Common\Collections\ArrayCollection;
   use Doctrine\Common\Collections\Collection;
   use Doctrine\ORM\Mapping as ORM;
   use Symfony\Component\Serializer\Attribute\Groups;

   #[ORM\Entity(repositoryClass: DefectRepository::class)]
   #[ApiResource(
       normalizationContext: ['groups' => ['defect:read']],
       denormalizationContext: ['groups' => ['defect:write']]
   )]
   class Defect
   {
      #[ORM\Id]
      #[ORM\GeneratedValue]
      #[ORM\Column]
      #[Groups(['defect:read'])]
      private ?int $id = null;

      #[ORM\Column(length: 255)]
      #[Groups(['defect:read', 'defect:write'])]
      private ?string $title = null;
            #[ORM\Column(length: 255, nullable: true)]
      #[Groups(['defect:read', 'defect:write'])]
      private ?string $description = null;

      #[ORM\Column(length: 255, nullable: true)]
      #[Groups(['defect:read', 'defect:write'])]
      private ?string $location = null;

      #[ORM\Column(length: 255, nullable: true)]
      #[Groups(['defect:read', 'defect:write'])]
      private ?string $contentUrl = null;

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

      public function getContentUrl(): ?string
      {
         return $this->contentUrl;
      }

      public function setContentUrl(?string $contentUrl): static
      {
         $this->contentUrl = $contentUrl;

         return $this;
      }
   }
