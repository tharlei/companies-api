<?php

namespace App\Modules\Company\Domain;

use Illuminate\Support\Str;

class CompanyFactory
{
    public function new(
        string $name,
        string $email,
        string $phone,
        string $federalUnit,
        string $city,
        ?string $description = null,
    ): CompanyDTO {
        return new CompanyDTO(
            Str::uuid(),
            $name,
            $email,
            $phone,
            $federalUnit,
            $city,
            $description
        );
    }

    public function restore(
        string $id,
        string $name,
        string $email,
        string $phone,
        string $description,
        string $federalUnit,
        string $city
    ): CompanyDTO {
        return new CompanyDTO(
            $id,
            $name,
            $email,
            $phone,
            $federalUnit,
            $city,
            $description
        );
    }
}
