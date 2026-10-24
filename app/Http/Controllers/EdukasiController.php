<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class EdukasiController extends Controller
{
    /**
     * Tampilkan daftar artikel edukasi & antisipasi kebakaran (publik, tanpa login).
     */
    public function index(): View
    {
        $artikel = [
            [
                'slug' => 'metode-tata',
                'judul' => 'Metode T.A.T.A Saat Api Mulai Muncul',
                'kategori' => 'Tips APAR',
                'waktuBaca' => '1 menit',
                'ikonen' => '🧯',
                'deskripsi' => 'Tarik pin, Arahkan nozzle, Tekan tuas, dan Sapukan ke sumber api. Cara cepat memadamkan api kecil dengan APAR.',
            ],
            [
                'slug' => 'kebocoran-tabung-gas',
                'judul' => 'Apa Jika Tabung Gas Bocor?',
                'kategori' => 'Kecelakaan Rumah Tangga',
                'waktuBaca' => '2 menit',
                'ikonen' => '⛽',
                'deskripsi' => 'Langkah pertama saat mencium bau gas: matikan regulator, jalaikan pembuka api, buka jendela, dan serahkan ke petugas.',
            ],
            [
                'slug' => 'jalur-evakuasi',
                'judul' => 'Siapkan Jalur Evakuasi di Rumah',
                'kategori' => 'Pengendaran Diri',
                'waktuBaca' => '2 menit',
                'ikonen' => '🚪',
                'deskripsi' => 'Tentukan dua jalur keluar, latihan dengan anggota keluarga, dan jaga pintu keluar tidak tersumbat.',
            ],
            [
                'slug' => 'pencegahan-kebakaran-rumah',
                'judul' => 'Pencegahan Kebakaran Rumah Tangga',
                'kategori' => 'Pencegahan',
                'waktuBaca' => '2 menit',
                'ikonen' => '🏠',
                'deskripsi' => 'Periksa kertas listrik, jangan tinggalkan kompor menyala, dan simpan api jauh dari anak-anak.',
            ],
            [
                'slug' => 'kecelakaan-listrik',
                'judul' => 'Penanganan Kecelakaan Listrik',
                'kategori' => 'Kecelakaan Rumah Tangga',
                'waktuBaca' => '2 menit',
                'ikonen' => '⚡',
                'deskripsi' => 'Matikan saklistrik utama, jangan padamkan api listrik dengan air, dan hubungi petugas terkait segera.',
            ],
            [
                'slug' => 'penggunaan-apar',
                'judul' => 'Penggunaan APAR Secara Benar',
                'kategori' => 'Alat Pemadam',
                'waktuBaca' => '1 menit',
                'ikonen' => '🧯',
                'deskripsi' => 'Kenali jenis APAR (APAR, tabung kimia, CO2) dan cara penggunaannya sesuai jenis bahan pembakar.',
            ],
        ];

        return view('edukasi.index', compact('artikel'));
    }

    /**
     * Tampilkan detail artikel Metode T.A.T.A (penggunaan APAR).
     */
    public function tata(): View
    {
        return view('edukasi.tata');
    }
}
