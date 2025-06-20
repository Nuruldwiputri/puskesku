<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name('male'), // Dokter pria
            'specialization' => fake()->randomElement(['Umum', 'Gigi', 'Anak', 'Penyakit Dalam', 'Mata', 'THT']),
            'phone_number' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
