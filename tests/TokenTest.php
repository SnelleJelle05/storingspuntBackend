<?php

   namespace App\Tests;

   use function Zenstruck\Foundry\faker;

   class TokenTest extends BaseTestCase
   {

      public function testPostUser(): void{
         $username = faker()->email();
         $this->post("/api/users", ["email" => $username, "password" => $this->password]);
         self::assertResponseIsSuccessful();
         $this->postAuth($username, $this->password);


         $json = $this->jsonResponse();
         dump($json);
         self::assertResponseIsSuccessful();
      }
   }
