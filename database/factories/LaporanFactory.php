<?php

namespace Database\Factories;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Laporan>
 */
class LaporanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nomor_telepon' => fake()->numerify('08##########'),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'alamat' => fake()->address(),
            'foto' => fake()->word().'.jpg',
            'keterangan' => fake()->sentence(),
            'status' => 'pending',
        ];
    }
}
