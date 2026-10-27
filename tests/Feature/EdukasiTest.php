<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EdukasiTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_daftar_edukasi_dapat_diakses_tanpa_login(): void
    {
        $response = $this->get(route('edukasi.index'));

        $response->assertOk();
        $response->assertViewIs('edukasi.index');
        $response->assertSee('Edukasi & Antisipasi Cepat');
        $response->assertSee('Metode T.A.T.A Saat Api Mulai Muncul');
    }

    public function test_halaman_detail_metode_tata_dapat_diakses_tanpa_login(): void
    {
        $response = $this->get(route('edukasi.tata'));

        $response->assertOk();
        $response->assertViewIs('edukasi.tata');
        $response->assertSee('Metode T.A.T.A Saat Api Mulai Muncul');
        $response->assertSee('Tarik Pin');
        $response->assertSee('Arahkan Nozzle');
        $response->assertSee('Tekan Tuas');
        $response->assertSee('Sapukan ke Sumber Api');
        $response->assertSee('112');
    }

    public function test_tautan_edukasi_dari_beranda_arah_ke_route_edukasi(): void
    {
        $response = $this->get(route('beranda'));

        $response->assertOk();
        $response->assertSee(route('edukasi.index'));
        $response->assertSee(route('edukasi.tata'));
    }

    public function test_semua_halaman_detail_edukasi_dapat_diakses_berdasarkan_slug(): void
    {
        $slugs = [
            'metode-tata' => 'Metode T.A.T.A Saat Api Mulai Muncul',
            'kebocoran-tabung-gas' => 'Apa yang Harus Dilakukan Jika Tabung Gas Bocor?',
            'jalur-evakuasi' => 'Siapkan Rencana &amp; Jalur Evakuasi Kebakaran di Rumah',
            'pencegahan-kebakaran-rumah' => 'Pencegahan Kebakaran Rumah Tangga &amp; Lingkungan',
            'kecelakaan-listrik' => 'Penanganan Korsleting Listrik &amp; Bahaya Sengatan Arus',
            'penggunaan-apar' => 'Penggunaan, Jenis, &amp; Klasifikasi APAR Secara Benar',
        ];

        foreach ($slugs as $slug => $expectedJudul) {
            $response = $this->get(route('edukasi.show', $slug));
            $response->assertOk();
            $response->assertSee($expectedJudul, false);
        }
    }

    public function test_slug_edukasi_yang_tidak_valid_mengembalikan_404(): void
    {
        $response = $this->get(route('edukasi.show', 'slug-tidak-dikenal'));

        $response->assertNotFound();
    }
}
