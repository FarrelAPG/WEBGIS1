<?php

namespace Tests\Feature;

use App\Models\Kendaraan;
use App\Models\Laporan;
use App\Models\PosDamkar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DamkarPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_masyarakat_cannot_access_damkar_dashboard(): void
    {
        $masyarakat = User::factory()->create(['role' => 'masyarakat']);

        $this->actingAs($masyarakat)
            ->get(route('damkar.dashboard'))
            ->assertForbidden();
    }

    public function test_tamu_diarahkan_ke_halaman_login(): void
    {
        $this->get(route('damkar.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_damkar_can_open_dashboard_with_statistics(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        Laporan::factory()->create(['alamat' => 'Jl. Baru No. 1', 'status' => 'pending']);
        Laporan::factory()->create(['status' => 'selesai']);

        $this->actingAs($damkar)
            ->get(route('damkar.dashboard'))
            ->assertOk()
            ->assertSee('Laporan Baru')
            ->assertSee('Operasional Lapangan')
            ->assertSee('Laporan Terbaru')
            // Laporan menunggu masuk ke antrean, yang selesai tidak
            ->assertSee('Jl. Baru No. 1');
    }

    public function test_damkar_can_view_vehicle_and_station_catalogs(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        Kendaraan::factory()->create(['kode' => 'UNIT-10', 'nama' => 'Fire Truck', 'status' => 'siaga']);
        PosDamkar::create([
            'nama' => 'Pos Damkar Kemuning',
            'unit' => 'N004',
            'alamat' => 'Jl. R. Sukamto, Palembang',
            'latitude' => -2.9525614,
            'longitude' => 104.7591222,
        ]);

        $this->actingAs($damkar)
            ->get(route('damkar.kendaraan'))
            ->assertOk()
            ->assertSee('Informasi Kendaraan')
            ->assertSee('UNIT-10')
            ->assertSee('Fire Truck');

        $this->actingAs($damkar)
            ->get(route('damkar.pos-damkar'))
            ->assertOk()
            ->assertSee('Daftar Pos Pemadam Kebakaran')
            ->assertSee('Pos Damkar Kemuning')
            ->assertSee('N004');
    }

    public function test_damkar_can_list_reports_with_status_filter(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        Laporan::factory()->create(['alamat' => 'Jl. Pending No. 1', 'status' => 'pending']);
        Laporan::factory()->create(['alamat' => 'Jl. Selesai No. 2', 'status' => 'selesai']);

        $this->actingAs($damkar)
            ->get(route('damkar.laporan.index'))
            ->assertOk()
            ->assertSee('Jl. Pending No. 1')
            ->assertSee('Jl. Selesai No. 2');

        $this->actingAs($damkar)
            ->get(route('damkar.laporan.index', ['status' => 'pending']))
            ->assertOk()
            ->assertSee('Jl. Pending No. 1')
            ->assertDontSee('Jl. Selesai No. 2');
    }

    public function test_damkar_can_view_report_detail_and_transition_options(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        $laporan = Laporan::factory()->create(['status' => 'pending']);

        $this->actingAs($damkar)
            ->get(route('damkar.laporan.show', $laporan))
            ->assertOk()
            ->assertSee($laporan->nomor_telepon)
            ->assertSee('Proses Lapangan')
            ->assertSee($laporan->alamat);
    }

    public function test_damkar_can_update_report_status(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        $laporan = Laporan::factory()->create(['status' => 'pending']);

        $this->actingAs($damkar)
            ->patch(route('damkar.laporan.status', $laporan), ['status' => 'diproses'])
            ->assertRedirect(route('damkar.laporan.show', $laporan))
            ->assertSessionHas('berhasil');

        $this->assertSame('diproses', $laporan->fresh()->status);
    }

    public function test_invalid_status_transition_is_rejected(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        $laporan = Laporan::factory()->create(['status' => 'pending']);

        // pending hanya boleh ke diproses
        $this->actingAs($damkar)
            ->patch(route('damkar.laporan.status', $laporan), ['status' => 'selesai'])
            ->assertStatus(422);

        $this->assertSame('pending', $laporan->fresh()->status);
    }

    public function test_masyarakat_cannot_update_report_status(): void
    {
        $masyarakat = User::factory()->create(['role' => 'masyarakat']);
        $laporan = Laporan::factory()->create(['status' => 'pending']);

        $this->actingAs($masyarakat)
            ->patch(route('damkar.laporan.status', $laporan), ['status' => 'diproses'])
            ->assertForbidden();

        $this->assertSame('pending', $laporan->fresh()->status);
    }

    public function test_damkar_can_assign_vehicle_and_is_redirected_to_route_navigation(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        $kendaraan = Kendaraan::factory()->create(['status' => 'siaga', 'kode' => 'UNIT-99']);
        $laporan = Laporan::factory()->create(['status' => 'pending']);

        $this->actingAs($damkar)
            ->get(route('damkar.laporan.penugasan-kendaraan', $laporan))
            ->assertOk()
            ->assertSee('Penugasan Kendaraan')
            ->assertSee('UNIT-99');

        $this->actingAs($damkar)
            ->patch(route('damkar.laporan.store-penugasan-kendaraan', $laporan), [
                'kendaraan_id' => $kendaraan->id,
            ])
            ->assertRedirect(route('damkar.laporan.navigasi-rute', $laporan))
            ->assertSessionHas('berhasil');

        $this->assertSame('diproses', $laporan->fresh()->status);
        $this->assertSame($kendaraan->id, $laporan->fresh()->kendaraan_id);
        $this->assertSame('bergerak', $kendaraan->fresh()->status);
    }

    public function test_damkar_can_access_navigation_and_tkp_handling(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        $kendaraan = Kendaraan::factory()->create(['status' => 'bergerak', 'kode' => 'UNIT-88']);
        $laporan = Laporan::factory()->create([
            'status' => 'diproses',
            'kendaraan_id' => $kendaraan->id,
            'alamat' => 'Jl. Sudirman No. 12',
        ]);

        $this->actingAs($damkar)
            ->get(route('damkar.laporan.navigasi-rute', $laporan))
            ->assertOk()
            ->assertSee('Navigasi Menuju TKP')
            ->assertSee('UNIT-88')
            ->assertSee('Jl. Sudirman No. 12')
            ->assertSee('Mulai Penanganan');

        $this->actingAs($damkar)
            ->get(route('damkar.laporan.penanganan-tkp', $laporan))
            ->assertOk()
            ->assertSee('Peta TKP')
            ->assertSee('Penyelesaian Insiden')
            ->assertSee('Selesaikan Penanganan & Buat Laporan', false);
    }

    public function test_damkar_can_complete_incident_and_save_final_report(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        $kendaraan = Kendaraan::factory()->create(['status' => 'bergerak']);
        $laporan = Laporan::factory()->create([
            'status' => 'diproses',
            'kendaraan_id' => $kendaraan->id,
            'alamat' => 'Jl. Merdeka No. 45',
        ]);

        // Selesaikan penanganan
        $this->actingAs($damkar)
            ->patch(route('damkar.laporan.selesai', $laporan))
            ->assertRedirect(route('damkar.laporan.hasil', $laporan))
            ->assertSessionHas('berhasil');

        $freshLaporan = $laporan->fresh();
        $this->assertSame('selesai', $freshLaporan->status);
        $this->assertSame('siaga', $kendaraan->fresh()->status);
        $this->assertNotNull($freshLaporan->tanggal_penanganan);
        $this->assertNotNull($freshLaporan->selesai_pukul);
        // Masyarakat belum boleh melihat "Selesai" sebelum laporan akhir dibuat
        $this->assertNull($freshLaporan->hasil_dibuat_pada);
        $this->assertSame(3, $freshLaporan->tahapMasyarakat());

        // Buka form hasil
        $this->actingAs($damkar)
            ->get(route('damkar.laporan.hasil', $laporan))
            ->assertOk()
            ->assertSee('Laporan Hasil Pemadaman & Penyelamatan')
            ->assertSee('Korsleting Listrik');

        // Simpan hasil
        $this->actingAs($damkar)
            ->patch(route('damkar.laporan.simpan-hasil', $laporan), [
                'tanggal_penanganan' => '2026-10-19',
                'wilayah' => 'Pos Damkar Pusat',
                'jam_terima' => '14:30 WIB',
                'tiba_tkp' => '14:40 WIB',
                'selesai_pukul' => '16:00 WIB',
                'dugaan_penyebab' => 'Korsleting Listrik',
                'kronologi_kejadian' => 'Api membakar lantai 2 dan berhasil dipadamkan regu pemadam.',
                'korban_jiwa' => 0,
                'korban_luka' => 1,
                'catatan_medis' => 'Luka ringan personel.',
            ])
            ->assertRedirect(route('damkar.laporan.berita'))
            ->assertSessionHas('berhasil');

        $laporanHasil = $laporan->fresh();
        $this->assertNotNull($laporanHasil->hasil_dibuat_pada);
        $this->assertSame(4, $laporanHasil->tahapMasyarakat());
        $this->assertSame('Korsleting Listrik', $laporanHasil->dugaan_penyebab);

        // Buka halaman berita laporan
        $this->actingAs($damkar)
            ->get(route('damkar.laporan.berita'))
            ->assertOk()
            ->assertSee('Berita Laporan')
            ->assertSee('Jl. Merdeka No. 45')
            ->assertSee('Korsleting Listrik')
            ->assertSee('Pos Damkar Pusat');
    }

    public function test_damkar_can_view_laporan_photo_without_storage_link(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        $damkar = User::factory()->create(['role' => 'damkar']);
        $foto = \Illuminate\Http\UploadedFile::fake()->image('kejadian.jpg');
        $path = $foto->store('laporan-foto', 'public');
        $laporan = \App\Models\Laporan::factory()->create(['foto' => $path]);

        $this->actingAs($damkar)
            ->get(route('damkar.laporan.foto', $laporan))
            ->assertOk();
    }

    public function test_laporan_photo_returns_404_when_file_missing(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        $damkar = User::factory()->create(['role' => 'damkar']);
        $laporan = \App\Models\Laporan::factory()->create(['foto' => 'laporan-foto/tidak-ada.jpg']);

        $this->actingAs($damkar)
            ->get(route('damkar.laporan.foto', $laporan))
            ->assertNotFound();
    }

    public function test_opening_penanganan_tkp_marks_start_of_handling_once(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        $kendaraan = Kendaraan::factory()->create(['status' => 'bergerak']);
        $laporan = Laporan::factory()->create(['status' => 'diproses', 'kendaraan_id' => $kendaraan->id]);

        $this->assertNull($laporan->mulai_penanganan_at);
        $this->assertSame(2, $laporan->tahapMasyarakat());

        $this->actingAs($damkar)->get(route('damkar.laporan.penanganan-tkp', $laporan))->assertOk();

        $mulai = $laporan->fresh()->mulai_penanganan_at;
        $this->assertNotNull($mulai);
        $this->assertSame(3, $laporan->fresh()->tahapMasyarakat());

        $this->travel(5)->minutes();
        $this->actingAs($damkar)->get(route('damkar.laporan.penanganan-tkp', $laporan))->assertOk();

        $this->assertTrue($laporan->fresh()->mulai_penanganan_at->equalTo($mulai));
    }

    public function test_damkar_can_reject_pending_report_with_reason(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        $laporan = Laporan::factory()->create(['status' => 'pending']);

        $this->actingAs($damkar)
            ->patch(route('damkar.laporan.tolak', $laporan), [
                'alasan' => 'Laporan palsu / iseng',
                'catatan' => 'Lokasi tidak ada kejadian.',
            ])
            ->assertRedirect(route('damkar.laporan.show', $laporan))
            ->assertSessionHas('berhasil');

        $fresh = $laporan->fresh();
        $this->assertSame('ditolak', $fresh->status);
        $this->assertSame('Laporan palsu / iseng — Lokasi tidak ada kejadian.', $fresh->alasan_penolakan);
        $this->assertNotNull($fresh->ditolak_pada);
    }

    public function test_reject_requires_a_valid_reason(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        $laporan = Laporan::factory()->create(['status' => 'pending']);

        $this->actingAs($damkar)
            ->patch(route('damkar.laporan.tolak', $laporan), [])
            ->assertSessionHasErrors('alasan');

        $this->actingAs($damkar)
            ->patch(route('damkar.laporan.status', $laporan), ['status' => 'ditolak'])
            ->assertSessionHasErrors('alasan');

        $this->assertSame('pending', $laporan->fresh()->status);
    }

    public function test_reject_releases_assigned_vehicle(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        $kendaraan = Kendaraan::factory()->create(['status' => 'bergerak']);
        $laporan = Laporan::factory()->create(['status' => 'diproses', 'kendaraan_id' => $kendaraan->id]);

        $this->actingAs($damkar)
            ->patch(route('damkar.laporan.tolak', $laporan), ['alasan' => 'Bukan kejadian kebakaran'])
            ->assertRedirect();

        $this->assertSame('ditolak', $laporan->fresh()->status);
        $this->assertSame('siaga', $kendaraan->fresh()->status);
    }

    public function test_report_cannot_be_rejected_after_handling_started_or_finished(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        $berjalan = Laporan::factory()->create(['status' => 'diproses', 'mulai_penanganan_at' => now()]);
        $selesai = Laporan::factory()->create(['status' => 'selesai']);

        foreach ([$berjalan, $selesai] as $laporan) {
            $this->actingAs($damkar)
                ->patch(route('damkar.laporan.tolak', $laporan), ['alasan' => 'Laporan palsu / iseng'])
                ->assertStatus(422);
        }

        $this->assertSame('diproses', $berjalan->fresh()->status);
        $this->assertSame('selesai', $selesai->fresh()->status);
    }

    public function test_masyarakat_cannot_reject_report(): void
    {
        $masyarakat = User::factory()->create(['role' => 'masyarakat']);
        $laporan = Laporan::factory()->create(['status' => 'pending']);

        $this->actingAs($masyarakat)
            ->patch(route('damkar.laporan.tolak', $laporan), ['alasan' => 'Laporan palsu / iseng'])
            ->assertForbidden();

        $this->assertSame('pending', $laporan->fresh()->status);
    }

    public function test_show_page_offers_reject_form_for_pending_report(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        $laporan = Laporan::factory()->create(['status' => 'pending']);

        $this->actingAs($damkar)
            ->get(route('damkar.laporan.show', $laporan))
            ->assertOk()
            ->assertSee('Tolak Laporan (palsu / iseng)');
    }
}
