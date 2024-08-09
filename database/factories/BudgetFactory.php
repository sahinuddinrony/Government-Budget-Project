<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Charge;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Budget>
 */
class BudgetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startYear = fake()->numberBetween(2020, 2025); // Random start year between 2020 and 2025
        $fiscalYear = $startYear . '-' . ($startYear + 1); // Fiscal year format

        return [
            'uuid' => (string) Str::uuid(),
            'fiscal_year' => $fiscalYear,
            'allocation' => fake()->numberBetween(1, 400),
            'expenditure' => fake()->numberBetween(1, 200),
            'unused' => fake()->numberBetween(1, 500),
            'user_id' => User::factory(),
        ];
    }
}
