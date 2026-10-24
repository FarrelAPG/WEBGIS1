<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MasyarakatProfileController extends Controller
{
    /**
     * Tampilkan halaman profil publik masyarakat (tanpa login/autentikasi).
     *
     * Halaman ini menampilkan identitas sesi/perangkat, panduan penggunaan
     * sistem lapor, dan form isian data diri lokal (disimpan di browser,
     * bukan ke server) untuk kontak default pelapor kebakaran.
     */
    public function index(Request $request): View
    {
        return view('profile.masyarakat', [
            'idSesi' => $request->session()->getId(),
        ]);
    }
}
