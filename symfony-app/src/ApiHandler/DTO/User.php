<?php

namespace GMG\ApiHandler\DTO;

use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class User
{
   
    public function __construct(
        #[SerializedName('id')]
        public readonly int $id,

        #[SerializedName('first_name')]
        #[Groups(['user:write'])]
        public readonly string $firstname,

        #[SerializedName('last_name')]
        #[Groups(['user:write'])]   
        public readonly string $lastname,

        #[SerializedName('gender')]
        #[Groups(['user:write'])]
        public readonly string $gender,

        #[SerializedName('birthdate')]
        #[Groups(['user:write'])]
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        public readonly DateTimeImmutable $birthdate,
    ) {
       
    }

}