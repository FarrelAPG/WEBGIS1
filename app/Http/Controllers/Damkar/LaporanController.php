<?php

namespace App\Http\Controllers\Damkar;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Laporan;
use App\Models\PosDamkar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $laporanQuery = Laporan::query()
            ->with(['user', 'kendaraan'])
            ->when(in_array($status, ['pending', 'diproses', 'selesai', 'ditolak'], true), fn ($query) => $query->where('status', $status))
            ->latest();

        $laporanList = $laporanQuery->get()->map(function ($item) {
            $statusLabel = match ($item->status) {
                'pending' => 'Menunggu Penugasan',
                'diproses' => 'Penanganan',
                'selesai' => 'Selesai',
                'ditolak' => 'Ditolak',
                default => ucfirst($item->status),
            };

            return [
                'id' => $item->id,
                'judul_lokasi' => $item->alamat,
                'nama_pelapor' => $item->user?->name ?? 'Tamu (tanpa akun)',
                'kecamatan' => $item->alamat,
                'status' => $item->status,
                'status_label' => $statusLabel,
                'waktu' => $item->created_at ? $item->created_at->format('H:i').' WIB' : '-',
                'keterangan_waktu' => $item->created_at ? $item->created_at->diffForHumans() : '-',
                'lat' => (float) $item->latitude,
                'lng' => (float) $item->longitude,
                'detail_url' => route('damkar.laporan.show', $item),
            ];
        });

        $posDamkarList = PosDamkar::all()->map(function ($pos) {
            return [
                'nama' => $pos->nama,
                'unit' => $pos->unit,
                'alamat' => $pos->alamat,
                'lat' => (float) $pos->latitude,
                'lng' => (float) $pos->longitude,
            ];
        });

        $fleetUnits = Kendaraan::all()->map(function ($unit) {
            return [
                'code' => $unit->kode,
                'status' => $unit->status,
                'lat' => (float) $unit->latitude,
                'lng' => (float) $unit->longitude,
            ];
        });

        $pendingCount = Laporan::where('status', 'pending')->count();

        return view('damkar.laporan.index', compact('laporanList', 'posDamkarList', 'fleetUnits', 'pendingCount', 'status'));
    }

    public function show(Laporan $laporan)
    {
        return view('damkar.laporan.show', [
            'laporan' => $laporan->load(['user', 'kendaraan']),
            'transisi' => $laporan->transisiTersedia(),
            'kendaraanTersedia' => Kendaraan::siaga()->get(),
        ]);
    }

    /**
     * Tampilkan foto bukti kejadian langsung dari storage.
     * Tidak bergantung pada symlink public/storage (php artisan storage:link).
     */
    public function foto(Laporan $laporan)
    {
        $disk = Storage::disk('public');

        abort_unless($laporan->foto && $disk->exists($laporan->foto), 404);

        return $disk->response($laporan->foto);
    }

    public function penugasanKendaraan(Laporan $laporan)
    {
        $dapatDiassign = $laporan->bisaDiubahKe('diproses') || ($laporan->status === 'diproses' && ! $laporan->kendaraan_id);

        abort_unless($dapatDiassign, 403, 'Laporan tidak dapat ditugaskan kendaraan lagi.');

        $latLaporan = (float) $laporan->latitude;
        $lngLaporan = (float) $laporan->longitude;

        // Ambil kendaraan siaga beserta data pos damkarnya
        $semuaKendaraan = Kendaraan::with('posDamkar')->siaga()->get();

        // Hitung jarak real-time dari pos kendaraan ke titik kejadian (Haversine)
        $kendaraanTersedia = $semuaKendaraan->map(function ($k) use ($latLaporan, $lngLaporan) {
            $latPos = (float) ($k->latitude ?? $k->posDamkar?->latitude ?? -2.9761);
            $lngPos = (float) ($k->longitude ?? $k->posDamkar?->longitude ?? 104.7754);

            if ($latLaporan != 0.0 && $lngLaporan != 0.0) {
                $dLat = deg2rad($latLaporan - $latPos);
                $dLon = deg2rad($lngLaporan - $lngPos);
                $a = sin($dLat / 2) * sin($dLat / 2) +
                     cos(deg2rad($latPos)) * cos(deg2rad($latLaporan)) *
                     sin($dLon / 2) * sin($dLon / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                $jarak = round(6371 * $c, 1);
            } else {
                $jarak = 1.5;
            }

            $k->jarak_km = $jarak;
            $k->estimasi_menit = max(2, (int) round(($jarak / 35) * 60)); // asumsi 35 km/jam

            return $k;
        })->sortBy('jarak_km')->values();

        // Batasi hanya beberapa (1 sampai 4) kendaraan yang paling dekat
        $kendaraanTerdekat = $kendaraanTersedia->take(4);
        $kendaraanLainnya = $kendaraanTersedia->slice(4)->values();

        return view('damkar.penugasan-kendaraan', [
            'laporan' => $laporan->load('user'),
            'kendaraanTersedia' => $kendaraanTerdekat,
            'kendaraanLainnya' => $kendaraanLainnya,
            'totalSiaga' => $kendaraanTersedia->count(),
        ]);
    }

    public function storePenugasanKendaraan(Request $request, Laporan $laporan)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
        ]);

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);

        abort_unless($kendaraan->status === 'siaga', 422, 'Kendaraan tidak siaga.');

        $dapatDiassign = $laporan->bisaDiubahKe('diproses') || ($laporan->status === 'diproses' && ! $laporan->kendaraan_id);
        abort_unless($dapatDiassign, 422, 'Laporan tidak bisa ditugaskan kendaraan lagi.');

        $laporan->update([
            'status' => $laporan->status === 'pending' ? 'diproses' : $laporan->status,
            'kendaraan_id' => $kendaraan->id,
        ]);

        $kendaraan->update(['status' => 'bergerak']);

        return redirect()
            ->route('damkar.laporan.navigasi-rute', $laporan)
            ->with('berhasil', 'Kendaraan '.$kendaraan->kode.' ditugaskan ke laporan ini.');
    }

    public function navigasiRute(Laporan $laporan)
    {
        abort_unless($laporan->kendaraan_id !== null, 404, 'Kendaraan belum ditugaskan.');

        $laporan->load(['user', 'kendaraan.posDamkar']);
        $posDamkar = $laporan->kendaraan?->posDamkar ?? PosDamkar::first();

        return view('damkar.navigasi-rute', compact('laporan', 'posDamkar'));
    }

    public function penangananTkp(Laporan $laporan)
    {
        abort_unless($laporan->kendaraan_id && $laporan->status === 'diproses', 403, 'Laporan belum dalam penanganan atau belum memiliki kendaraan.');

        // Membuka halaman penanganan TKP = petugas mulai menangani (dicatat sekali saja).
        // Masyarakat melihat tahap "Sedang Ditangani" sejak saat ini.
        if (! $laporan->mulai_penanganan_at) {
            $laporan->update(['mulai_penanganan_at' => now()]);
        }

        $laporan->load(['user', 'kendaraan']);

        $kendaraanTersedia = Kendaraan::all()->map(function ($unit) {
            return [
                'id' => $unit->id,
                'kode' => $unit->kode,
                'nama' => $unit->nama,
                'status' => $unit->status,
                'lat' => (float) $unit->latitude,
                'lng' => (float) $unit->longitude,
            ];
        });

        $posDamkar = PosDamkar::first();

        return view('damkar.penanganan-tkp', compact('laporan', 'kendaraanTersedia', 'posDamkar'));
    }

    public function selesai(Request $request, Laporan $laporan)
    {
        // Jika status sudah selesai, langsung arahkan ke form laporan evaluasi hasil
        if ($laporan->status === 'selesai') {
            return redirect()
                ->route('damkar.laporan.hasil', $laporan)
                ->with('berhasil', 'Penanganan insiden telah selesai. Silakan lengkapi laporan evaluasi akhir.');
        }

        abort_unless($laporan->bisaDiubahKe('selesai'), 422, 'Transisi status tidak diizinkan.');

        $laporan->update([
            'status' => 'selesai',
            'tanggal_penanganan' => now()->toDateString(),
            'selesai_pukul' => now()->format('H:i').' WIB',
        ]);

        if ($laporan->kendaraan) {
            $laporan->kendaraan->update(['status' => 'siaga']);
        }

        return redirect()
            ->route('damkar.laporan.hasil', $laporan)
            ->with('berhasil', 'Penanganan insiden telah selesai. Silakan lengkapi laporan evaluasi akhir.');
    }

    public function hasil(Laporan $laporan)
    {
        // Bila dibuka langsung dan status masih diproses, selesaikan otomatis agar petugas tidak buntu
        if ($laporan->status !== 'selesai' && $laporan->bisaDiubahKe('selesai')) {
            $laporan->update([
                'status' => 'selesai',
                'tanggal_penanganan' => now()->toDateString(),
                'selesai_pukul' => now()->format('H:i').' WIB',
            ]);

            if ($laporan->kendaraan) {
                $laporan->kendaraan->update(['status' => 'siaga']);
            }
        }

        abort_unless($laporan->status === 'selesai', 403, 'Laporan belum berstatus selesai.');

        $laporan->load(['user', 'kendaraan']);
        $posDamkar = PosDamkar::first();

        return view('damkar.laporan.hasil', compact('laporan', 'posDamkar'));
    }

    public function simpanHasil(Request $request, Laporan $laporan)
    {
        abort_unless($laporan->status === 'selesai', 403, 'Laporan belum berstatus selesai.');

        $validated = $request->validate([
            'tanggal_penanganan' => 'required|date',
            'wilayah' => 'required|string|max:255',
            'jam_terima' => 'required|string|max:50',
            'tiba_tkp' => 'required|string|max:50',
            'selesai_pukul' => 'required|string|max:50',
            'dugaan_penyebab' => 'required|string|max:255',
            'kronologi_kejadian' => 'required|string',
            'korban_jiwa' => 'required|integer|min:0',
            'korban_luka' => 'required|integer|min:0',
            'catatan_medis' => 'nullable|string',
        ]);

        $validated['hasil_dibuat_pada'] = now();

        $laporan->update($validated);

        return redirect()
            ->route('damkar.laporan.berita')
            ->with('berhasil', 'Laporan hasil pemadaman dan penyelamatan berhasil disimpan.');
    }

    public function berita()
    {
        $laporanList = Laporan::query()
            ->where('status', 'selesai')
            ->whereNotNull('hasil_dibuat_pada')
            ->with(['user', 'kendaraan'])
            ->latest('hasil_dibuat_pada')
            ->get();

        return view('damkar.laporan.berita', compact('laporanList'));
    }

    /**
     * Tolak laporan (mis. laporan iseng/palsu). Hanya bisa selama penanganan di TKP belum dimulai.
     * Pelapor melihat "Laporan Anda ditolak" beserta alasannya.
     */
    public function tolak(Request $request, Laporan $laporan)
    {
        abort_unless($laporan->bisaDiubahKe('ditolak'), 422, 'Laporan ini tidak bisa ditolak.');
        abort_if($laporan->mulai_penanganan_at !== null, 422, 'Penanganan sudah dimulai, laporan tidak bisa ditolak.');

        $data = $request->validate([
            'alasan' => ['required', 'string', Rule::in(Laporan::ALASAN_PENOLAKAN)],
            'catatan' => ['nullable', 'string', 'max:200'],
        ]);

        $catatan = trim((string) ($data['catatan'] ?? ''));

        $laporan->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $data['alasan'].($catatan !== '' ? ' — '.$catatan : ''),
            'ditolak_pada' => now(),
        ]);

        // Kendaraan yang sudah telanjur ditugaskan dikembalikan siaga
        $laporan->kendaraan?->update(['status' => 'siaga']);

        return redirect()
            ->route('damkar.laporan.show', $laporan)
            ->with('berhasil', 'Laporan ditolak. Pelapor akan melihat pemberitahuan penolakan.');
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        $status = (string) $request->input('status');

        // Penolakan wajib lewat alasan agar pelapor tahu kenapa laporannya ditolak
        if ($status === 'ditolak') {
            return $this->tolak($request, $laporan);
        }

        abort_unless($laporan->bisaDiubahKe($status), 422, 'Transisi status tidak diizinkan.');

        $laporan->update(['status' => $status]);

        return redirect()
            ->route('damkar.laporan.show', $laporan)
            ->with('berhasil', 'Status laporan diubah menjadi "'.$status.'".');
    }

    public function assignKendaraan(Request $request, Laporan $laporan)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
        ]);

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);

        abort_unless($kendaraan->status === 'siaga', 422, 'Kendaraan tidak siaga.');
        abort_unless($laporan->bisaDiubahKe('diproses'), 422, 'Laporan tidak bisa ditugaskan kendaraan lagi.');

        $laporan->update([
            'status' => 'diproses',
            'kendaraan_id' => $kendaraan->id,
        ]);

        $kendaraan->update(['status' => 'bergerak']);

        return redirect()
            ->route('damkar.laporan.show', $laporan)
            ->with('berhasil', 'Kendaraan '.$kendaraan->kode.' ditugaskan ke laporan ini.');
    }
}
