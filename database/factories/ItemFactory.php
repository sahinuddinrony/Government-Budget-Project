<?php

namespace Database\Factories;

use App\Models\Budget;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'item_name' => fake()->sentence(),
            'item_code' => fake()->numberBetween(1, 200),
            'item_allocation' => fake()->numberBetween(1, 400),
            'item_expenditure' => fake()->numberBetween(1, 200),
            'item_unused' => fake()->numberBetween(1, 500),
            'budget_id' => Budget::factory()
        ];
    }
}
