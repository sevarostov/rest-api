<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\Rubric;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->name(),
            'phones' => [fake()->phoneNumber(), fake()->phoneNumber(), fake()->phoneNumber()]
        ];
    }
}
