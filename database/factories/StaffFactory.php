<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'staff_name' => fake()->name(),
            'designation' => fake()->jobTitle(),
            'contact_number' => fake()->phoneNumber(),
            'email_address' => fake()->unique()->safeEmail(),
            'company_id' => Company::factory(),
            'qr_code_path' => null, // Replace with actual QR code path generation logic
        ];
    }
}
