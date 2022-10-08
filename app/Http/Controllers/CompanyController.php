<?php

namespace App\Http\Controllers;

use App\Modules\Company\Queries\ListCompaniesInput;
use App\Modules\Company\Queries\ListCompaniesQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(
        private readonly ListCompaniesQuery $listCompaniesQuery,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $input = new ListCompaniesInput(
            page: (int) $request->get('page', 1),
            limit: (int) $request->get('limit', 15),
            name: $request->get('name'),
            federalUnit: $request->get('federal_unit'),
            city: $request->get('city'),
        );

        $companies = $this->listCompaniesQuery->handle($input);

        return response()->json($companies);
    }
}
