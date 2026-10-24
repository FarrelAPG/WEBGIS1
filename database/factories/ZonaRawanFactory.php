<?php

namespace Database\Factories;

use App\Models\ZonaRawan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ZonaRawan>
 */
class ZonaRawanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->unique()->randomElement([
                'Ilir Timur II', 'Seberang Ulu I', 'Sukarami', 'Bukit Besar', 'Kemuning Raya',
            ]),
            'ciri' => fake()->randomElement([
                'kawasan niaga padat', '14 gang sempit', 'deret pasarnya terbuka', 'permukiman rapat',
            ]),
            'latitude' => fake()->latitude(-2.93, -3.03),
            'longitude' => fake()->longitude(104.72, 104.80),
            'radius_m' => fake()->randomElement([400, 550, 700]),
            'jumlah_kejadian' => fake()->numberBetween(10, 80),
        ];
    }
}
