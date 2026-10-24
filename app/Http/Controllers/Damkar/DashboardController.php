<?php

namespace App\Http\Controllers\Damkar;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Laporan;
use App\Models\PosDamkar;

class DashboardController extends Controller
{
    public function index()
    {
        $statistik = [
            'laporan_baru' => Laporan::where('status', 'pending')->count(),
            'kebakaran_aktif' => Laporan::where('status', 'diproses')->count(),
            'kendaraan_siap' => Kendaraan::siaga()->count(),
        ];

        // Antrean berjalan: laporan yang masih perlu ditangani
        $laporanTerbaru = Laporan::whereIn('status', ['pending', 'diproses'])
            ->latest()
            ->take(3)
            ->get();

        $posDamkarList = PosDamkar::orderBy('unit')->get();

        return view('damkar.dashboard', compact('statistik', 'laporanTerbaru', 'posDamkarList'));
    }

    // Ringkasan ringan untuk polling: dipakai halaman damkar agar otomatis menyegarkan diri
    public function cek()
    {
        return response()->json([
            'pending' => Laporan::where('status', 'pending')->count(),
            'diproses' => Laporan::where('status', 'diproses')->count(),
            'terakhir' => Laporan::max('id'),
        ]);
    }

    public function resetDemo()
    {
        Kendaraan::query()->update(['status' => 'siaga']);
        Laporan::query()->update([
            'status' => 'pending',
            'kendaraan_id' => null,
            'tanggal_penanganan' => null,
            'wilayah' => null,
            'jam_terima' => null,
            'tiba_tkp' => null,
            'selesai_pukul' => null,
            'dugaan_penyebab' => null,
            'kronologi_kejadian' => null,
            'korban_jiwa' => 0,
            'korban_luka' => 0,
            'catatan_medis' => null,
            'hasil_dibuat_pada' => null,
        ]);

        return redirect()
            ->route('damkar.dashboard')
            ->with('berhasil', 'Data laporan uji coba berhasil di-reset kembali ke status pending!');
    }
}
