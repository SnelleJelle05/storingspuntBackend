<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsDecorator('api_platform.doctrine.orm.state.persist_processor')]
class PasswordHasherProcessor implements ProcessorInterface
{

   public function __construct(
       private readonly ProcessorInterface $processor,
       private readonly UserPasswordHasherInterface $userPasswordHasher
   ) {
   }
   public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
   {
      if ($data instanceof User) {
         if ($plainPassword = $data->getPlainPassword()) {
            $data->setRoles(["ROLE_USER"]);
            $data->setPassword($this->userPasswordHasher->hashPassword($data, $plainPassword));
            $data->eraseCredentials();

         }
      }
      return $this->processor->process($data, $operation, $uriVariables, $context);
   }

}
