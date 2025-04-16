<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;

class NewUserDescriptionData extends Data
{
    public function __construct(
        public string $nom,
        public string $prenom,
        public string $email,
        public ?string $unite,
   ) {}

   public static function make(    
                string $nom,
                string $prenom,
                string $email,
                ?string $unite = null)
   {
        return new static($nom, $prenom, $email, $unite);
   }
}