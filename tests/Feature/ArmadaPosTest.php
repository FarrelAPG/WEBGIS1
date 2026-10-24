<?php

namespace Tests\Feature;

use App\Models\Kendaraan;
use App\Models\PosDamkar;
use App\Models\User;
use Database\Seeders\KendaraanSeeder;
use Database\Seeders\PosDamkarSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArmadaPosTest extends TestCase
{
    use RefreshDatabase;

    private function seedArmada(): void
    {
        $this->seed(PosDamkarSeeder::class);
        $this->seed(KendaraanSeeder::class);
    }

    public function test_seeder_membuat_20_unit_sesuai_csv_per_pos(): void
    {
        $this->seedArmada();

        $this->assertEquals(20, Kendaraan::count());
        $this->assertEquals(0, Kendaraan::whereNull('pos_damkar_id')->count());
        $this->assertEquals(9, Kendaraan::where('jenis', 'Fire Truck')->count());
        $this->assertEquals(9, Kendaraan::where('jenis', 'Fire Tanker')->count());
        $this->assertEquals(2, Kendaraan::where('jenis', 'Quick Response')->count());

        $perPos = PosDamkar::withCount('kendaraan')->orderBy('unit')->pluck('kendaraan_count', 'unit')->map(fn ($n) => (int) $n)->all();
        $this->assertEquals([
            'N001' => 1, 'N002' => 2, 'N003' => 2, 'N004' => 3,
            'N005' => 4, 'N006' => 2, 'N007' => 2, 'N008' => 4,
        ], $perPos);
    }

    public function test_seeder_aman_dijalankan_ulang_dan_tidak_mereset_status(): void
    {
        $this->seedArmada();
        Kendaraan::where('kode', 'Unit-23')->update(['status' => 'bergerak']);

        $this->seed(KendaraanSeeder::class);

        $this->assertEquals(20, Kendaraan::count());
        $this->assertSame('bergerak', Kendaraan::where('kode', 'Unit-23')->value('status'));
    }

    public function test_unit_lama_dengan_kode_sama_diperbarui_bukan_diduplikasi(): void
    {
        $this->seed(PosDamkarSeeder::class);
        Kendaraan::create(['kode' => 'Unit-23', 'nama' => 'Toyota Land Cruiser', 'status' => 'siaga']);

        $this->seed(KendaraanSeeder::class);

        $this->assertEquals(20, Kendaraan::count());
        $unit = Kendaraan::where('kode', 'Unit-23')->first();
        $this->assertSame('Fire Tanker Hino 500', $unit->nama);
        $this->assertSame('Pos Pemadam Kertapati', $unit->posDamkar->nama);
    }

    public function test_halaman_pos_menampilkan_armada_siaga_per_pos(): void
    {
        $this->seedArmada();
        Kendaraan::where('kode', 'Unit-01')->update(['status' => 'bergerak']); // Pos Kemuning: 3 unit, 1 keluar

        $damkar = User::factory()->create(['role' => 'damkar']);

        $this->actingAs($damkar)
            ->get(route('damkar.pos-damkar'))
            ->assertOk()
            ->assertSee('Pos Damkar Kemuning')
            ->assertSee('2 / 3 Unit')
            ->assertSee('4 / 4 Unit')       // Pos Merdeka
            ->assertSee('19 dari 20 unit')
            ->assertSee('Hino Dutro');
    }

    public function test_halaman_kendaraan_memakai_jenis_dari_data(): void
    {
        $this->seedArmada();
        $damkar = User::factory()->create(['role' => 'damkar']);

        $this->actingAs($damkar)
            ->get(route('damkar.kendaraan'))
            ->assertOk()
            ->assertSee('Quick Response');
    }
}
