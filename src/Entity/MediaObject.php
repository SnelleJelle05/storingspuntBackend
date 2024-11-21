<?php

   declare(strict_types=1);
// api/src/Entity/MediaObject.php

   namespace App\Entity;

   use ApiPlatform\Metadata\ApiProperty;
   use ApiPlatform\Metadata\ApiResource;
   use ApiPlatform\Metadata\Delete;
   use ApiPlatform\Metadata\Get;
   use ApiPlatform\Metadata\GetCollection;
   use ApiPlatform\Metadata\Post;
   use ApiPlatform\OpenApi\Model;
   use App\Controller\MediaController;
   use App\State\MediaObjectProcessor;
   use Doctrine\ORM\Mapping as ORM;
   use Symfony\Component\HttpFoundation\File\File;
   use Symfony\Component\Validator\Constraints as Assert;
   use Vich\UploaderBundle\Mapping\Annotation as Vich;

   #[Vich\Uploadable]
   #[ORM\Entity]
   #[ApiResource(
       types: ['https://schema.org/MediaObject'],
       operations: [
           new GetCollection(
           ),
           new Get(
           ),
           new Delete(
           ),
           new Post(
               controller: MediaController::class,
               openapi: new Model\Operation(
                   requestBody: new Model\RequestBody(
                       content: new \ArrayObject([
                           'multipart/form-data' => [
                               'schema' => [
                                   'type' => 'object',
                                   'properties' => [
                                       'file' => [
                                           'type' => 'string',
                                           'format' => 'binary',
                                       ],
                                   ],
                               ],
                           ],
                       ])
                   )
               ),
               deserialize: false
           ),
       ],
   )]
   class MediaObject
   {
      // object to entity
      #[ORM\Id, ORM\Column, ORM\GeneratedValue]
      private ?int $id = null;
      #[ApiProperty(types: ['https://schema.org/contentUrl'])]
      public ?string $contentUrl = null;

      #[Vich\UploadableField(mapping: 'media_object', fileNameProperty: 'filePath')]
      #[Assert\File(maxSize: '1024k', extensions: ['png', 'JPEG', 'PDF', 'webp'])]
      public ?File $file = null;

      #[ORM\Column(nullable: true)]
      public ?string $filePath = null;

      #[ORM\ManyToOne(inversedBy: 'Photo')]
      private ?Defect $defect = null;

      public function getId(): ?int
      {
         return $this->id;
      }

      public function getDefect(): ?Defect
      {
          return $this->defect;
      }

      public function setDefect(?Defect $defect): static
      {
          $this->defect = $defect;

          return $this;
      }

   }
