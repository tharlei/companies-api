<?php

namespace App\Queries\Company;

use App\Models\Company as CompanyModel;
use App\Modules\Company\Queries\ListCompaniesInput;
use App\Modules\Company\Queries\ListCompaniesQuery;
use App\Utils\PaginateUtil;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class ListCompaniesEloquentQuery implements ListCompaniesQuery
{
    public function __construct(
        private readonly CompanyModel $companyModel,
        private readonly PaginateUtil $paginateUtil,
    ) {
    }

    public function handle(ListCompaniesInput $input): array
    {
        $key = "list-companies-{$input->page}-{$input->limit}-{$input->name}-{$input->federalUnit}-{$input->city}";
        $companies = Cache::remember($key, 20 * 60, function() use ($input) {
            return $this->executeQuery($input->page, $input)->toArray();
        });

        $companies['data'] = collect($companies['data'])->map(fn ($company) => [
            'id' => $company['id'],
            'name' => $company['name'],
            'phone' => $company['phone'],
            'description' => $company['description'],
            'email' => $company['email'],
        ])->toArray();

        return $this->paginateUtil->mapData($companies);
    }

    private function executeQuery(int $page, ListCompaniesInput $input): LengthAwarePaginator
    {
        $companies = $this->companyModel->select('*');

        if ($input->federalUnit) {
            $companies->where('federal_unit', $input->federalUnit);
        }

        if ($input->city) {
            $companies->where('city', $input->city);
        }

        if ($input->name) {
            $companies->where('name', 'like', "%{$input->name}%");
        }

        return $companies->paginate($input->limit);
    }
}
