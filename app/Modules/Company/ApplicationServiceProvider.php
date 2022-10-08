<?php

declare(strict_types=1);

namespace App\Modules\Company;

use App\Modules\Company\Queries\ListCompaniesQuery;
use App\Queries\Company\ListCompaniesEloquentQuery;
use Illuminate\Support\ServiceProvider;

final class ApplicationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ListCompaniesQuery::class, ListCompaniesEloquentQuery::class);
    }
}
