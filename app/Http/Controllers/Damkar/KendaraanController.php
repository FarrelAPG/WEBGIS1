<?php

namespace App\Http\Controllers\Damkar;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Contracts\View\View;

class KendaraanController extends Controller
{
    public function index(): View
    {
        $kendaraanList = Kendaraan::query()
            ->orderBy('kode')
            ->get()
            ->map(function (Kendaraan $kendaraan): array {
                $namaKendaraan = strtolower($kendaraan->nama);

                return [
                    'kendaraan' => $kendaraan,
                    'jenis' => $kendaraan->jenis ?: (str_contains($namaKendaraan, 'tanker') ? 'Fire Tanker' : 'Fire Truck'),
                    'statusLabel' => match ($kendaraan->status) {
                        'siaga' => 'Operasional',
                        'bergerak' => 'Bergerak',
                        'dipanggil' => 'Dipanggil',
                        default => ucfirst($kendaraan->status),
                    },
                ];
            });

        return view('damkar.kendaraan', [
            'kendaraanList' => $kendaraanList,
            'totalAktif' => $kendaraanList->filter(fn (array $item): bool => in_array($item['kendaraan']->status, ['siaga', 'bergerak'], true))->count(),
            'totalSiaga' => $kendaraanList->filter(fn (array $item): bool => $item['kendaraan']->status === 'siaga')->count(),
            'totalBergerak' => $kendaraanList->filter(fn (array $item): bool => $item['kendaraan']->status === 'bergerak')->count(),
        ]);
    }
}
