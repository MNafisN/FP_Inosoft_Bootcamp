<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cust_id' => fake()->unique()->numerify(
                'CUST-' . fake()->numberBetween(2020, 2023) . '-####'
            ),
            'cust_name' => fake()->name(),
            'cust_address' => fake()->address(),
        ];
    }
}
