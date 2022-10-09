<?php

namespace App\Modules\Company\Queries;

interface ListCompaniesQuery
{
    public function handle(ListCompaniesInput $input): array;
}
