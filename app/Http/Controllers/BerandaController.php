<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()?->getAuthIdentifier();
        $deviceId = (string) ($request->attributes->get('sigap_device_id')
            ?? $request->cookie('sigap_device_id')
            ?? $request->header('X-Device-Id')
            ?? '');

        $laporanTerbaru = Laporan::query()
            ->where(function ($q) use ($userId, $deviceId) {
                $hasFilter = false;
                if (! empty($deviceId)) {
                    $q->where('device_id', $deviceId);
                    $hasFilter = true;
                }
                if ($userId) {
                    $hasFilter ? $q->orWhere('user_id', $userId) : $q->where('user_id', $userId);
                    $hasFilter = true;
                }

                if (! $hasFilter) {
                    $q->whereRaw('0 = 1');
                }
            })
            ->latest()
            ->latest('id')
            ->first();

        $laporanAktif = ($laporanTerbaru && $laporanTerbaru->masihBerjalanMasyarakat()) ? $laporanTerbaru : null;
        $totalKejadianAktif = Laporan::whereIn('status', ['pending', 'diproses'])->count();

        // Kebakaran terverifikasi/aktif yang sedang ditangani (notifikasi publik untuk seluruh masyarakat)
        $kebakaranTerverifikasi = Laporan::with(['kendaraan.posDamkar'])
            ->whereIn('status', ['diproses', 'pending'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest()
            ->get();

        return view('beranda', compact('laporanAktif', 'totalKejadianAktif', 'kebakaranTerverifikasi'));
    }
}
