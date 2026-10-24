<?php

namespace Tests\Feature;

use App\Models\Laporan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_page_is_accessible(): void
    {
        $this->get(route('lapor.create'))
            ->assertOk();
    }

    public function test_laporan_saya_page_is_accessible(): void
    {
        $this->get(route('laporan.saya'))
            ->assertOk()
            ->assertSee('Aktivitas Laporan')
            ->assertSee('Buat Laporan Baru');
    }

    public function test_lacak_page_displays_laporan_details(): void
    {
        $laporan = Laporan::factory()->create();

        $this->get(route('laporan.lacak', $laporan))
            ->assertOk()
            ->assertSee($laporan->alamat)
            ->assertSee('Hubungi Komandan Unit 03')
            ->assertSee('L.map(\'map\'', false);
    }

    public function test_store_saves_laporan_and_redirects_to_sukses_page(): void
    {
        Storage::fake('public');
        $foto = UploadedFile::fake()->create('kejadian.jpg', 100, 'image/jpeg');

        $response = $this->post(route('lapor.store'), [
            'nomor_telepon' => '081234567890',
            'latitude' => '-6.2088',
            'longitude' => '106.8456',
            'alamat' => 'Jl. Kebakaran No. 1, Jakarta',
            'foto' => $foto,
            'keterangan' => 'Asap tebal membubung dari lantai 2.',
        ]);

        $laporan = Laporan::first();

        $response->assertRedirect(route('lapor.sukses', $laporan));

        $this->assertNotNull($laporan);
        $this->assertSame('081234567890', $laporan->nomor_telepon);
        $this->assertSame('pending', $laporan->status);
        $this->assertNull($laporan->user_id);
        Storage::disk('public')->assertExists($laporan->foto);
    }

    public function test_sukses_page_displays_the_reporter_telephone(): void
    {
        $laporan = Laporan::factory()->create();

        $this->get(route('lapor.sukses', $laporan))
            ->assertOk()
            ->assertSee($laporan->nomor_telepon)
            ->assertSee('Pantau Pelacakan Armada (Laporan Saya)');
    }

    public function test_store_rejects_invalid_photo_format(): void
    {
        $response = $this->post(route('lapor.store'), [
            'nomor_telepon' => '081234567890',
            'latitude' => '-6.2088',
            'longitude' => '106.8456',
            'alamat' => 'Jl. Kebakaran No. 1, Jakarta',
            'foto' => UploadedFile::fake()->create('not-a-photo.pdf', 100, 'application/pdf'),
        ]);

        $response->assertSessionHasErrors('foto');
        $this->assertSame(0, Laporan::count());
    }

    public function test_sukses_returns_404_for_unknown_id(): void
    {
        $this->get(route('lapor.sukses', 9999))
            ->assertNotFound();
    }

    public function test_laporan_saya_shows_sedang_ditangani_after_handling_starts(): void
    {
        $laporan = Laporan::factory()->create(['status' => 'diproses', 'mulai_penanganan_at' => now()]);

        $this->withSession(['laporan_ids' => [$laporan->id]])
            ->get(route('laporan.saya'))
            ->assertOk()
            ->assertSee('Sedang Ditangani')
            ->assertSee('Petugas Sedang Menangani Kebakaran');
    }

    public function test_laporan_stays_active_for_masyarakat_until_final_report_is_saved(): void
    {
        // Petugas sudah klik "Selesaikan Penanganan", tapi laporan akhir belum dibuat
        $laporan = Laporan::factory()->create(['status' => 'selesai', 'hasil_dibuat_pada' => null]);

        $this->withSession(['laporan_ids' => [$laporan->id]])
            ->get(route('laporan.saya'))
            ->assertOk()
            ->assertSee('Petugas Sedang Menangani Kebakaran')
            ->assertSee('Lacak Armada')
            ->assertDontSee('telah selesai ditangani');
    }

    public function test_laporan_shows_selesai_after_final_report_is_saved(): void
    {
        $laporan = Laporan::factory()->create(['status' => 'selesai', 'hasil_dibuat_pada' => now()]);

        $this->withSession(['laporan_ids' => [$laporan->id]])
            ->get(route('laporan.saya'))
            ->assertOk()
            ->assertSee('Laporan Anda telah selesai ditangani')
            ->assertDontSee('Lacak Armada')
            ->assertSee('Buat Laporan Baru');
    }

    public function test_lacak_page_shows_current_stage(): void
    {
        $ditangani = Laporan::factory()->create(['status' => 'selesai', 'hasil_dibuat_pada' => null, 'mulai_penanganan_at' => now()]);
        $this->get(route('laporan.lacak', $ditangani))->assertOk()->assertSee('Sedang Ditangani')->assertSee('--.--');

        $tuntas = Laporan::factory()->create(['status' => 'selesai', 'hasil_dibuat_pada' => now()]);
        $this->get(route('laporan.lacak', $tuntas))->assertOk()->assertSee('Laporan akhir telah dibuat petugas')->assertDontSee('--.--');
    }

    public function test_rejected_report_shows_notice_with_reason_to_reporter(): void
    {
        $laporan = Laporan::factory()->create([
            'status' => 'ditolak',
            'alasan_penolakan' => 'Laporan palsu / iseng',
            'ditolak_pada' => now(),
        ]);

        $this->withSession(['laporan_ids' => [$laporan->id]])
            ->get(route('laporan.saya'))
            ->assertOk()
            ->assertSee('Laporan Anda ditolak')
            ->assertSee('Laporan palsu / iseng')
            ->assertDontSee('Lacak Armada')
            ->assertSee('Buat Laporan Baru');
    }

    public function test_lacak_redirects_to_laporan_saya_for_rejected_report(): void
    {
        $laporan = Laporan::factory()->create(['status' => 'ditolak', 'ditolak_pada' => now()]);

        $this->get(route('laporan.lacak', $laporan))->assertRedirect(route('laporan.saya'));
    }

    public function test_guest_report_stays_visible_when_logged_in_as_another_account(): void
    {
        $laporan = Laporan::factory()->create(['status' => 'diproses', 'mulai_penanganan_at' => now()]);
        $damkar = \App\Models\User::factory()->create(['role' => 'damkar']);

        $this->actingAs($damkar)
            ->withSession(['laporan_ids' => [$laporan->id]])
            ->get(route('laporan.saya'))
            ->assertOk()
            ->assertSee('Petugas Sedang Menangani Kebakaran');
    }

    public function test_guest_report_is_recovered_from_cookie_when_session_is_reset(): void
    {
        $laporan = Laporan::factory()->create(['status' => 'diproses']);

        $this->withUnencryptedCookie('laporan_ids', json_encode([$laporan->id]))
            ->get(route('laporan.saya'))
            ->assertOk()
            ->assertSee('Petugas Sedang Menuju Lokasi');
    }

    public function test_cannot_open_form_while_a_report_is_still_active(): void
    {
        foreach (['pending', 'diproses'] as $status) {
            $laporan = Laporan::factory()->create(['status' => $status]);

            $this->withSession(['laporan_ids' => [$laporan->id]])
                ->get(route('lapor.create'))
                ->assertRedirect(route('laporan.saya'))
                ->assertSessionHas('info');
        }

        // Petugas sudah klik selesai tapi laporan akhir belum dibuat: masih dianggap aktif
        $menunggu = Laporan::factory()->create(['status' => 'selesai', 'hasil_dibuat_pada' => null]);
        $this->withSession(['laporan_ids' => [$menunggu->id]])
            ->get(route('lapor.create'))
            ->assertRedirect(route('laporan.saya'));
    }

    public function test_cannot_submit_second_report_while_one_is_active(): void
    {
        $aktif = Laporan::factory()->create(['status' => 'pending']);

        $this->withSession(['laporan_ids' => [$aktif->id]])
            ->post(route('lapor.store'), [
                'nomor_telepon' => '081234567890',
                'latitude' => '-6.2088',
                'longitude' => '106.8456',
                'alamat' => 'Jl. Kebakaran No. 2, Jakarta',
            ])
            ->assertRedirect(route('laporan.saya'))
            ->assertSessionHas('info');

        $this->assertSame(1, Laporan::count());
    }

    public function test_can_report_again_after_previous_report_is_selesai_or_ditolak(): void
    {
        $selesai = Laporan::factory()->create(['status' => 'selesai', 'hasil_dibuat_pada' => now()]);
        $this->withSession(['laporan_ids' => [$selesai->id]])->get(route('lapor.create'))->assertOk();

        $ditolak = Laporan::factory()->create(['status' => 'ditolak', 'ditolak_pada' => now()]);
        $this->withSession(['laporan_ids' => [$ditolak->id]])->get(route('lapor.create'))->assertOk();
    }

    public function test_logged_in_user_with_active_report_cannot_open_form(): void
    {
        $user = \App\Models\User::factory()->create();
        Laporan::factory()->create(['user_id' => $user->id, 'status' => 'pending']);

        $this->actingAs($user)->get(route('lapor.create'))->assertRedirect(route('laporan.saya'));
    }

    public function test_laporan_saya_shows_only_latest_report_and_older_ones_in_riwayat(): void
    {
        $lama = Laporan::factory()->create(['status' => 'selesai', 'hasil_dibuat_pada' => now()->subDay(), 'alamat' => 'Jl. Lama 1', 'created_at' => now()->subDays(2)]);
        $baru = Laporan::factory()->create(['status' => 'ditolak', 'ditolak_pada' => now(), 'alamat' => 'Jl. Baru 2', 'created_at' => now()]);

        $this->withSession(['laporan_ids' => [$lama->id, $baru->id]])
            ->get(route('laporan.saya'))
            ->assertOk()
            ->assertSee('Laporan Anda ditolak')
            ->assertSee('Riwayat Laporan Sebelumnya (1)')
            ->assertSee('Jl. Lama 1');
    }

    public function test_old_stuck_report_does_not_block_new_report_when_latest_is_finished(): void
    {
        $macet = Laporan::factory()->create(['status' => 'pending', 'created_at' => now()->subDays(3)]);
        $macetSelesai = Laporan::factory()->create(['status' => 'selesai', 'hasil_dibuat_pada' => null, 'created_at' => now()->subDays(2)]);
        $terbaru = Laporan::factory()->create(['status' => 'selesai', 'hasil_dibuat_pada' => now(), 'created_at' => now()->subDay()]);

        $sesi = ['laporan_ids' => [$macet->id, $macetSelesai->id, $terbaru->id]];

        $this->withSession($sesi)->get(route('lapor.create'))->assertOk();

        $this->withSession($sesi)->get(route('laporan.saya'))
            ->assertOk()
            ->assertSee('Laporan Anda telah selesai ditangani')
            ->assertSee('Buat Laporan Baru')
            ->assertDontSee('Laporan baru bisa dibuat setelah');
    }
}
