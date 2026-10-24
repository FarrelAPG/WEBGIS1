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
        $response->assertSee('113');
    }

    public function test_tautan_edukasi_dari_beranda_arah_ke_route_edukasi(): void
    {
        $response = $this->get(route('beranda'));

        $response->assertOk();
        $response->assertSee(route('edukasi.index'));
        $response->assertSee(route('edukasi.tata'));
    }
}
