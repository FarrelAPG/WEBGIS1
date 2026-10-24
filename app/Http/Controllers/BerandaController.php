<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()?->getAuthIdentifier();
        $dariCookie = json_decode((string) $request->cookie('laporan_ids'), true);
        $idSaya = array_values(array_unique(array_map('intval', array_filter(
            [...(array) $request->session()->get('laporan_ids', []), ...(is_array($dariCookie) ? $dariCookie : [])],
            'is_numeric'
        ))));

        $laporanTerbaru = Laporan::query()
            ->where(function ($q) use ($userId, $idSaya) {
                $q->whereIn('id', $idSaya);
                if ($userId) {
                    $q->orWhere('user_id', $userId);
                }
            })
            ->latest()
            ->latest('id')
            ->first();

        $laporanAktif = ($laporanTerbaru && $laporanTerbaru->masihBerjalanMasyarakat()) ? $laporanTerbaru : null;
        $totalKejadianAktif = Laporan::whereIn('status', ['pending', 'diproses'])->count();

        return view('beranda', compact('laporanAktif', 'totalKejadianAktif'));
    }
}
