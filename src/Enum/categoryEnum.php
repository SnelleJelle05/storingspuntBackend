<?php

   namespace App\Enum;

   enum categoryEnum: string
   {
      case algemeen = 'algemeen';
         case Hardwaredefecten = 'Hardware';
         case Softwarefouten  = 'Software';
         case Systeemstoringen = 'Systeem';
   }
