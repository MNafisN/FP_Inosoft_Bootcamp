<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instruction>
 */
class InstructionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $file = \Illuminate\Http\UploadedFile::fake()->create('dummy.pdf', 2)->store('storage/app/public');
        $instructionId = fake()->randomElement(['LI', 'SI']);
        if ($instructionId == 'LI') {
            $instructionType = 'Logistic Instruction';
        } else {
            $instructionType = 'Service Instruction';
        }


        return [
            'instruction_id' => fake()->unique()->numerify(
                $instructionId . '-' . fake()->numberBetween(2020, 2023) . '-####'
            ),
            'instruction_type' => $instructionType,
            'vendor_id' => fake()->unique()->numerify(
                'VDR-' . fake()->numberBetween(2020, 2023) . '-####'
            ),
            'attention_of' => fake()->name(),
            'quotation_no' => fake()->numberBetween(10000, 99999),
            'cust_id' => fake()->unique()->numerify(
                'CUST-' . fake()->numberBetween(2020, 2023) . '-####'
            ),
            'cust_po_number' => fake()->regexify('[A-Z0-9]{10}'),
            'cost_detail' => [],
            'attachment' => [],
            'notes' => fake()->text(50),
            'transaction_code' => fake()->unique()->numerify(
                'TRF-' . fake()->numberBetween(2020, 2023) . '-####'
            ),
            'invoices' => [],
            'termination' => [],
            'instruction_status' => 'Draft',
        ];
    }
}
