<?php

namespace Database\Seeders;

use App\Models\Company;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = $this->getLocations();

        Company::factory(1000)->state(function() use ($locations) {
            $location = $locations->random();
            return [
                'federal_unit' => $location['federalUnit'],
                'city' => $location['cities']->random(),
            ];
        })->create();
    }

    private function getLocations(): Collection
    {
        $response = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/municipios');

        if ($response->failed()) {
            throw new Exception('Não foi possível obter as localidades');
        }

        $locations = $response->collect()->reduce(function ($locations, $location) {
            $federalUnit = $location['microrregiao']['mesorregiao']['UF']['sigla'];
            $city = $location['nome'];

            $location = $locations->firstWhere('federalUnit', $federalUnit);

            if (empty($location)) {
                $locations->add([
                    'federalUnit' => $federalUnit,
                    'cities' => collect([]),
                ]);

                $location = $locations->firstWhere('federalUnit', $federalUnit);
            }

            $location['cities']->add($city);

            return $locations;
        }, collect([]))->sort()->values();

        return $locations;
    }
}
