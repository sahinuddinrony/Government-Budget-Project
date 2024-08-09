<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Budget;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Charge>
 */
class ChargeFactory extends Factory
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
            'fiscal_year' => $fiscalYear,
            'bank_charge' => fake()->numberBetween(1, 500),
            'check_fee' => fake()->numberBetween(1, 100),
            'unspent_refund' => fake()->numberBetween(1, 1500),
            'user_id' => User::factory(),
            // 'budget_id' => Budget::factory()
        ];
    }
}
