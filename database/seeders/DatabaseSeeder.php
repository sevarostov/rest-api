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

        Building::factory()
            ->count(10)
            ->create();

        Rubric::factory()
            ->count(10)
            ->create();

        Rubric::factory()
              ->count(10)
              ->hasSubrubrics(2)
              ->create();

        Company::factory()
              ->count(10)
              ->hasBuilding(1)
              ->hasRubrics(2)
              ->create();
    }
}
