<?php

namespace App\Modules\Company\Queries;

final class ListCompaniesInput
{
    public function __construct(
        public int $page = 1,
        public int $limit = 15,
        public ?string $name = null,
        public ?string $federalUnit = null,
        public ?string $city = null,
    ) {
        $name = empty($name) ? null : trim(htmlspecialchars(substr($name, 0, 100)));
    }
}
