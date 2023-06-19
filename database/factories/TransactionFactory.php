<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'transaction_code' => fake()->unique()->numerify(
                'TRF-' . fake()->numberBetween(2020, 2023) . '-####'
            ),
            'description' => fake()->text(50),
        ];
    }
}
