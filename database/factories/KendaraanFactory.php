<?php

namespace Database\Factories;

use App\Models\Kendaraan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kendaraan>
 */
class KendaraanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kode' => fake()->unique()->randomElement(['Unit-23', 'Unit-19', 'Unit-20', 'Unit-11', 'Unit-08']),
            'nama' => fake()->randomElement(['Toyota Land Cruiser', 'Mitsubishi Colt Diesel', 'Isuzu Elf']),
            'status' => fake()->randomElement(['siaga', 'bergerak']),
            'latitude' => fake()->latitude(-2.93, -3.03),
            'longitude' => fake()->longitude(104.72, 104.80),
        ];
    }
}
