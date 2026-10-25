<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LaporanController extends Controller
{
    // Menampilkan halaman form laporan
    private const PESAN_SATU_LAPORAN = 'Anda masih punya laporan yang sedang ditangani. Laporan baru bisa dibuat setelah laporan ini selesai atau ditolak.';

    public function create(Request $request)
    {
        // Satu laporan aktif per pengunjung: cegah laporan beruntun/iseng
        if ($this->punyaLaporanBerjalan($request)) {
            return redirect()->route('laporan.saya')->with('info', self::PESAN_SATU_LAPORAN);
        }

        return view('lapor');
    }

    // Menyimpan data laporan ke database
    public function store(Request $request)
    {
        if ($this->punyaLaporanBerjalan($request)) {
            return redirect()->route('laporan.saya')->with('info', self::PESAN_SATU_LAPORAN);
        }

        $request->validate([
            'nomor_telepon' => 'required|string|max:20',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:10240', // Maksimal 10MB
            'keterangan' => 'nullable|string',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            try {
                $fotoPath = $request->file('foto')->store('laporan-foto', 'public');
            } catch (\Throwable $e) {
                report($e);
                $fotoPath = null;
            }
        }

        $deviceId = (string) ($request->input('device_id') ?? $request->cookie('sigap_device_id') ?? $request->header('X-Device-Id') ?? '');

        $laporan = Laporan::create([
            'user_id' => $request->user()?->getAuthIdentifier(), // null jika tidak login
            'device_id' => ! empty($deviceId) ? $deviceId : null,
            'nomor_telepon' => $request->nomor_telepon,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'alamat' => $request->alamat,
            'foto' => $fotoPath,
            'keterangan' => $request->keterangan,
            'status' => 'pending',
        ]);

        // Ingat laporan milik pengunjung yang belum login, agar "Laporan Saya" hanya menampilkan miliknya
        try {
            if (! empty($deviceId)) {
                Cookie::queue('sigap_device_id', $deviceId, 60 * 24 * 365);
            }
            $ids = array_values(array_unique([...$this->idLaporanSaya($request), $laporan->id]));
            $request->session()->put('laporan_ids', $ids);
            Cookie::queue('laporan_ids', json_encode($ids), 60 * 24 * 30);
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('lapor.sukses', ['id' => $laporan->id]);
    }

    public function sukses($id)
    {
        $laporan = Laporan::findOrFail($id);

        return view('sukses', ['laporan' => $laporan]);
    }

    // Menampilkan halaman lacak armada untuk sebuah laporan
    public function lacak(Laporan $laporan)
    {
        // Laporan yang ditolak tidak punya armada untuk dilacak; pemberitahuannya ada di Laporan Saya
        if ($laporan->status === 'ditolak') {
            return redirect()->route('laporan.saya');
        }

        return view('lacak', ['laporan' => $laporan]);
    }

    // Menampilkan halaman Laporan Saya: hanya laporan terbaru (aktif, selesai, atau ditolak) + riwayat lama
    public function index(Request $request)
    {
        $laporanTerbaru = $this->laporanSaya($request)->latest()->latest('id')->first();

        // Boleh membuat laporan baru hanya bila tidak ada laporan yang masih berjalan
        $bisaLapor = ! $laporanTerbaru?->masihBerjalanMasyarakat();

        $riwayatLaporan = $this->laporanSaya($request)
            ->when($laporanTerbaru, fn ($q) => $q->where('id', '!=', $laporanTerbaru->id))
            ->riwayatMasyarakat()
            ->latest()
            ->get();

        return view('laporan-saya', compact('laporanTerbaru', 'bisaLapor', 'riwayatLaporan'));
    }

    /**
     * Hanya laporan TERBARU yang menentukan boleh/tidaknya membuat laporan baru, sama dengan yang
     * ditampilkan di Laporan Saya. Laporan lama yang tersangkut tidak boleh memblokir diam-diam.
     */
    private function punyaLaporanBerjalan(Request $request): bool
    {
        $terbaru = $this->laporanSaya($request)->latest()->latest('id')->first();

        return $terbaru?->masihBerjalanMasyarakat() ?? false;
    }

    /**
     * Laporan milik pengunjung: yang dikirim dari browser ini (device_id / sesi / cookie) + laporan akun yang login.
     * Dipisah per device/user agar status laporan aktif tidak tertukar antar device/pengguna lain.
     */
    private function laporanSaya(Request $request): Builder
    {
        $userId = $request->user()?->getAuthIdentifier();
        $deviceId = (string) ($request->cookie('sigap_device_id') ?? $request->header('X-Device-Id') ?? '');
        $idSaya = $this->idLaporanSaya($request);

        return Laporan::query()->where(function ($q) use ($userId, $deviceId, $idSaya) {
            $hasFilter = false;
            if (! empty($deviceId)) {
                $q->where('device_id', $deviceId);
                $hasFilter = true;
            }
            if ($userId) {
                $hasFilter ? $q->orWhere('user_id', $userId) : $q->where('user_id', $userId);
                $hasFilter = true;
            }
            if (! empty($idSaya)) {
                $hasFilter ? $q->orWhereIn('id', $idSaya) : $q->whereIn('id', $idSaya);
                $hasFilter = true;
            }

            if (! $hasFilter) {
                $q->whereRaw('0 = 1');
            }
        });
    }

    /** @return list<int> ID laporan milik pengunjung ini (gabungan sesi dan cookie). */
    private function idLaporanSaya(Request $request): array
    {
        $dariCookie = json_decode((string) $request->cookie('laporan_ids'), true);

        return array_values(array_unique(array_map('intval', array_filter(
            [...(array) $request->session()->get('laporan_ids', []), ...(is_array($dariCookie) ? $dariCookie : [])],
            'is_numeric'
        ))));
    }
}
