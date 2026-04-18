<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Patient>
 */
class PatientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cedula' => fake()->unique()->numerify('########'),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'birth_date' => fake()->date('Y-m-d', '-18 years'), 
            'gender' => fake()->randomElement(['Masculino', 'Femenino', 'Otro']),
            'phone' => fake()->numerify('##############'),
            'blood_type' => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'user_id' => \App\Models\User::first()->id ?? \App\Models\User::factory(),
        ];
    }
}
