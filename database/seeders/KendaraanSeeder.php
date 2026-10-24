<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kendaraan = [
            [
                'kode' => 'Unit-23',
                'nama' => 'Toyota Land Cruiser',
                'status' => 'siaga',
                'latitude' => -2.978000,
                'longitude' => 104.762000,
            ],
            [
                'kode' => 'Unit-19',
                'nama' => 'Mitsubishi Colt Diesel',
                'status' => 'siaga',
                'latitude' => -2.998000,
                'longitude' => 104.752000,
            ],
            [
                'kode' => 'Unit-20',
                'nama' => 'Isuzu Elf',
                'status' => 'siaga',
                'latitude' => -2.987000,
                'longitude' => 104.770000,
            ],
        ];

        foreach ($kendaraan as $item) {
            Kendaraan::create($item);
        }
    }
}
