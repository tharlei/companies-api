<?php

namespace App\Modules\Company\Domain;

final class CompanyDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $phone,
        public string $federalUnit,
        public string $city,
        public ?string $description,
    ) {
    }
}
