<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasyarakatProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_profil_masyarakat_dapat_diakses_tanpa_login(): void
    {
        // Halaman profil masyarakat adalah publik: tidak perlu login / autentikasi.
        $response = $this->get(route('masyarakat.profile'));

        $response->assertOk();
        $response->assertViewIs('profile.masyarakat');
    }

    public function test_halaman_profil_masyarakat_tampilkan_identitas_dan_panduan(): void
    {
        $response = $this->get(route('masyarakat.profile'));

        $response->assertSee('Identitas Sesi & Perangkat');
        $response->assertSee('Panduan Penggunaan Sistem Lapor');
        $response->assertSee('Kontak Default Pelapor (Lokal)');
        $response->assertSee('Simpan Kontak Default');
    }
}
