<?php

namespace Database\Factories;

use App\Models\Cat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cat>
 */
class CatFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->firstName(),
            'found_at' => fake()->randomElement(['Parkiran Gedung C', 'Kantin Utama', 'Depan Perpustakaan', 'Masjid Kampus']),
            'breed' => fake()->randomElement(Cat::BREEDS),
            'temper' => fake()->randomElement(Cat::TEMPERS),
            'age' => fake()->numberBetween(1, 60),
            'vaccinated' => fake()->boolean(),
        ];
    }
}
