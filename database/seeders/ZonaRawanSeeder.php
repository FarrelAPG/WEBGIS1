<?php

namespace Database\Seeders;

use App\Models\ZonaRawan;
use Illuminate\Database\Seeder;

class ZonaRawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zona = [
            [
                'nama' => 'Seberang Ulu I',
                'ciri' => '14 gang sempit',
                'latitude' => -2.9920,
                'longitude' => 104.7575,
                'radius_m' => 700,
                'jumlah_kejadian' => 68,
            ],
            [
                'nama' => 'Ilir Timur II',
                'ciri' => 'kawasan niaga padat',
                'latitude' => -2.9745,
                'longitude' => 104.7815,
                'radius_m' => 550,
                'jumlah_kejadian' => 52,
            ],
            [
                'nama' => 'Sukarami',
                'ciri' => 'deret pasarnya terbuka',
                'latitude' => -2.9510,
                'longitude' => 104.7350,
                'radius_m' => 400,
                'jumlah_kejadian' => 31,
            ],
        ];

        foreach ($zona as $item) {
            ZonaRawan::create($item);
        }
    }
}
