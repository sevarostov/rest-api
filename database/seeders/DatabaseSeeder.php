<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Company;
use App\Models\Rubric;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->count(10)
            ->create();

        for ($i = 0; $i < 10; $i++) {
            $rubrics   = Rubric::factory()
                              ->count(1)
                              ->hasSubrubrics(2)
                              ->create()
            ;
            $building = Building::factory()->create();
            Company::factory()->hasRubrics(2)->create([ 'building_id' => $building->id ]);

            Company::all()->each(function ($company) use ($rubrics) {
                $company->rubrics()->attach(
                    $rubrics->pluck('id')->toArray()
                );
            });
        }
    }
}
