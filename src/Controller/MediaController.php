<?php

namespace App\Controller;

use App\Entity\MediaObject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Vich\UploaderBundle\Handler\UploadHandler;

class MediaController extends AbstractController
{
   private UploadHandler $uploadHandler;
    private EntityManagerInterface $entityManager;

    public function __construct(UploadHandler $uploadHandler, EntityManagerInterface $entityManager)
{
   $this->uploadHandler = $uploadHandler;
   $this->entityManager = $entityManager;
}

    public function __invoke(Request $request): Response
{
   $uploadedFile = $request->files->get('file');

   if (!$uploadedFile) {
      return new JsonResponse(['error' => 'No file uploaded'], Response::HTTP_BAD_REQUEST);
   }

   $mediaObject = new MediaObject();
   $mediaObject->file = $uploadedFile;
   $this->uploadHandler->upload($mediaObject, 'file');

   // Persist and flush the entity to the database
   $this->entityManager->persist($mediaObject);
   $this->entityManager->flush();

   // Return a JSON response with the media object details
   return new JsonResponse([
       'id' => $mediaObject->getId(),
       'file' => $mediaObject->filePath,
   ], Response::HTTP_CREATED);
}
}