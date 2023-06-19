<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $vendorAddress = [];
        for ($i=0; $i<fake()->numberBetween(1, 5); $i++) {
            array_push($vendorAddress, fake()->address());
        }

        return [
            'vendor_id' => fake()->unique()->numerify(
                'VDR-' . fake()->numberBetween(2020, 2023) . '-00##'
            ),
            'vendor_name' => fake()->streetName(),
            'vendor_description' => fake()->text(50),
            'vendor_phone_number' => fake()->numerify('+628#-###-###-###'),
            'vendor_address' => $vendorAddress,
            'vendor_invoice_provider' => fake()->words(fake()->numberBetween(1, 5)),
        ];
    }
}
