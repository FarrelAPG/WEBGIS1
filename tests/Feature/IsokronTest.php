<?php

namespace Tests\Feature;

use App\Models\PosDamkar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class IsokronTest extends TestCase
{
    use RefreshDatabase;

    private function buatPos(): PosDamkar
    {
        return PosDamkar::create([
            'nama' => 'Pos Induk Ampera',
            'unit' => 'Unit 1',
            'alamat' => 'Jl. Merdeka, Palembang',
            'latitude' => -2.9910,
            'longitude' => 104.7600,
        ]);
    }

    private function fiturValhalla(int $menit): array
    {
        // Bentuk bukan kotak/lingkaran: segi banyak tidak beraturan seperti hasil jaringan jalan
        return [
            'type' => 'Feature',
            'properties' => ['contour' => $menit, 'metric' => 'time'],
            'geometry' => [
                'type' => 'Polygon',
                'coordinates' => [[
                    [104.76, -2.99 + $menit * 0.002],
                    [104.76 + $menit * 0.003, -2.99],
                    [104.76 + $menit * 0.001, -2.99 - $menit * 0.004],
                    [104.76 - $menit * 0.002, -2.99 - $menit * 0.001],
                    [104.76, -2.99 + $menit * 0.002],
                ]],
            ],
        ];
    }

    private function jawabanValhalla(): array
    {
        // Valhalla biasanya mengembalikan dari kontur terbesar; urutan sengaja diacak
        return ['type' => 'FeatureCollection', 'features' => [
            $this->fiturValhalla(10),
            $this->fiturValhalla(5),
            $this->fiturValhalla(15),
        ]];
    }

    public function test_isokron_dikembalikan_berurutan_dari_terbesar(): void
    {
        Http::fake(['*' => Http::response($this->jawabanValhalla())]);
        $damkar = User::factory()->create(['role' => 'damkar']);
        $pos = $this->buatPos();

        $this->actingAs($damkar)
            ->getJson(route('damkar.peta.isokron', $pos))
            ->assertOk()
            ->assertJsonCount(3, 'features')
            ->assertJsonPath('features.0.properties.menit', 15)
            ->assertJsonPath('features.1.properties.menit', 10)
            ->assertJsonPath('features.2.properties.menit', 5)
            ->assertJsonPath('features.0.geometry.type', 'Polygon');
    }

    public function test_hasil_di_cache_sehingga_mesin_rute_dipanggil_sekali(): void
    {
        Http::fake(['*' => Http::response($this->jawabanValhalla())]);
        $damkar = User::factory()->create(['role' => 'damkar']);
        $pos = $this->buatPos();

        $this->actingAs($damkar)->getJson(route('damkar.peta.isokron', $pos))->assertOk();
        $this->actingAs($damkar)->getJson(route('damkar.peta.isokron', $pos))->assertOk();

        Http::assertSentCount(1);
    }

    public function test_bentuk_tidak_valid_dibuang(): void
    {
        Http::fake(['*' => Http::response(['features' => [
            $this->fiturValhalla(5),
            ['type' => 'Feature', 'properties' => ['contour' => 10], 'geometry' => ['type' => 'Point', 'coordinates' => [104.76, -2.99]]],
            ['type' => 'Feature', 'properties' => ['contour' => 99], 'geometry' => $this->fiturValhalla(5)['geometry']],
        ]])]);
        $damkar = User::factory()->create(['role' => 'damkar']);

        $this->actingAs($damkar)
            ->getJson(route('damkar.peta.isokron', $this->buatPos()))
            ->assertOk()
            ->assertJsonCount(1, 'features')
            ->assertJsonPath('features.0.properties.menit', 5);
    }

    public function test_gagal_dari_mesin_rute_menjadi_502_dan_tidak_di_cache(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        $pos = $this->buatPos();

        Http::fake(['*' => Http::response('error', 500)]);
        $this->actingAs($damkar)
            ->getJson(route('damkar.peta.isokron', $pos))
            ->assertStatus(502)
            ->assertJsonStructure(['pesan']);

        // Setelah layanan pulih, permintaan berikutnya berhasil (kegagalan tidak tersimpan)
        Http::fake(['*' => Http::response($this->jawabanValhalla())]);
        $this->actingAs($damkar)->getJson(route('damkar.peta.isokron', $pos))->assertOk();
    }

    public function test_kunci_openrouteservice_memakai_ors_dan_menit_dikonversi_dari_detik(): void
    {
        config(['services.isokron.ors_key' => 'kunci-rahasia']);
        $ors = ['type' => 'FeatureCollection', 'features' => array_map(function (int $detik) {
            $f = $this->fiturValhalla((int) ($detik / 60));
            $f['properties'] = ['value' => $detik];

            return $f;
        }, [300, 600, 900])];
        Http::fake(['api.openrouteservice.org/*' => Http::response($ors)]);
        $damkar = User::factory()->create(['role' => 'damkar']);

        $this->actingAs($damkar)
            ->getJson(route('damkar.peta.isokron', $this->buatPos()))
            ->assertOk()
            ->assertJsonPath('features.0.properties.menit', 15)
            ->assertJsonPath('features.2.properties.menit', 5);

        Http::assertSent(fn ($request) => $request->hasHeader('Authorization', 'kunci-rahasia'));
    }

    public function test_masyarakat_dan_tamu_tidak_bisa_mengakses_isokron(): void
    {
        $pos = $this->buatPos();

        $this->getJson(route('damkar.peta.isokron', $pos))->assertUnauthorized();

        $masyarakat = User::factory()->create(['role' => 'masyarakat']);
        $this->actingAs($masyarakat)->getJson(route('damkar.peta.isokron', $pos))->assertForbidden();
    }

    public function test_halaman_peta_tidak_menggambar_lingkaran_dan_menunggu_pos_dipilih(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        $this->buatPos();

        $this->actingAs($damkar)
            ->get(route('damkar.peta'))
            ->assertOk()
            ->assertSee('Pilih pos untuk melihat jangkauan')
            ->assertSee('Pos Induk Ampera')
            ->assertDontSee('L.circle', false);
    }
}
