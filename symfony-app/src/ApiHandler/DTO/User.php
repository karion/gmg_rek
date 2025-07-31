<?php

namespace GMG\ApiHandler\DTO;

use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\SerializedName;

class User
{
   
    public function __construct(
        #[SerializedName('id')]
        public readonly int $id,
        #[SerializedName('first_name')]
        public readonly string $firstname,
        #[SerializedName('last_name')]
        public readonly string $lastname,
        #[SerializedName('gender')]
        public readonly string $gender,
        #[SerializedName('birthdate')]
        public readonly DateTimeImmutable $birthdate,
    ) {
       
    }

}