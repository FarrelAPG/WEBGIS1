<?php

namespace Database\Seeders;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Akun admin damkar untuk panel admin
        User::factory()->create([
            'name' => 'Admin Damkar',
            'email' => 'damkar@sigap.test',
            'role' => 'damkar',
        ]);

        $this->call(ZonaRawanSeeder::class);
        $this->call(PosDamkarSeeder::class);
        $this->call(KendaraanSeeder::class);

        // Tidak ada sampel laporan: laporan masuk dari form masyarakat (/lapor).
    }
}
