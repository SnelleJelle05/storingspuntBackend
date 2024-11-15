<?php

// src/Security/AccessTokenHandler.php
   namespace App\Security;

   use App\Repository\UserRepository;
   use Symfony\Component\Security\Core\Exception\BadCredentialsException;
   use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
   use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

   class AccessTokenHandlerAuthenticator implements AccessTokenHandlerInterface
   {
      public function __construct(
          private UserRepository $repository
      ) {
      }
         //SensitiveParameter = makes sure if error the access token is not logged
      public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
      {
         // e.g. query the "access token" database to search for this token
         $accessToken = $this->repository->findOneByValue($accessToken);
         if (null === $accessToken || !$accessToken->isValid()) {
            throw new BadCredentialsException('Invalid credentials.');
         }
         // and return a UserBadge object containing the user identifier from the found token
         // (this is the same identifier used in Security configuration; it can be an email,
         // a UUID, a username, a database ID, etc.)
         return new UserBadge($accessToken->getUserId());
      }
   }

