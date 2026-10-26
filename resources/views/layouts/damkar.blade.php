<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#E52329">
    <title>SIGAP @yield('judul', '— Pos Komando Damkar')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-[#F8FAFC] font-sans text-slate-800">
<div class="flex min-h-screen">

    {{-- Sidebar Kiri (Desktop) --}}
    <aside class="sticky top-0 flex h-screen w-64 shrink-0 flex-col justify-between border-r border-slate-200 bg-white">
        <div class="p-6">
            {{-- Logo SIGAP --}}
            <div class="mb-8 flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E52329] text-white shadow-sm">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 23c6.075 0 11-4.925 11-11 0-4.04-2.18-7.572-5.434-9.524a.75.75 0 0 0-1.096.862C17.065 5.508 17.5 7.95 17.5 10c0 .605-.06 1.196-.176 1.767a8.96 8.96 0 0 0-3.324-2.767.75.75 0 0 0-1.077.72c.078 1.488-.363 2.981-1.282 4.108C10.59 15.12 9.297 15.75 8 15.75c-.88 0-1.725-.262-2.45-.733A6.974 6.974 0 0 1 4.5 12c0-2.316.892-4.423 2.352-6.002a.75.75 0 0 0-.58-1.222C3.132 5.378 1 8.442 1 12c0 6.075 4.925 11 11 11z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-extrabold leading-none tracking-wide text-slate-900">SIGAP</h1>
                    <p class="mt-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">Pos Komando Damkar</p>
                </div>
            </div>

            {{-- Menu Navigasi Utama --}}
            <nav class="space-y-1.5" aria-label="Menu panel damkar">
                <a href="{{ route('damkar.dashboard') }}" @if (request()->routeIs('damkar.dashboard')) aria-current="page" @endif
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold transition-all
                    {{ request()->routeIs('damkar.dashboard') ? 'bg-[#E52329] text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('damkar.peta') }}" @if (request()->routeIs('damkar.peta*')) aria-current="page" @endif
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all
                    {{ request()->routeIs('damkar.peta*') ? 'bg-[#E52329] text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Zm6-3v15m6-12v15"/>
                    </svg>
                    <span>Peta</span>
                </a>

                <a href="{{ route('damkar.laporan.index') }}" @if (request()->routeIs('damkar.laporan.*') && !request()->routeIs('damkar.laporan.berita')) aria-current="page" @endif
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all
                    {{ request()->routeIs('damkar.laporan.*') && !request()->routeIs('damkar.laporan.berita') ? 'bg-[#E52329] text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6l1 2h4v15H4V6h4l1-2Zm1 6h4m-4 4h6m-6 4h6"/>
                    </svg>
                    <span>Laporan</span>
                </a>

                <a href="{{ route('damkar.laporan.berita') }}" @if (request()->routeIs('damkar.laporan.berita')) aria-current="page" @endif
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all
                    {{ request()->routeIs('damkar.laporan.berita') ? 'bg-[#E52329] text-white shadow-sm' : 'text-[#5c4f4c] hover:bg-[#fffaf8] hover:text-[#bd101b]' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 2l-4.444 8.88A1 1 0 0015.556 12l2.222-4.444A1 1 0 0013.778 6H10m0 0L5.556 12A1 1 0 007.778 14l4.444-8.889A1 1 0 0011.112 4z"/>
                    </svg>
                    <span>Berita Laporan</span>
                </a>

                <a href="{{ route('damkar.kendaraan') }}" @if (request()->routeIs('damkar.kendaraan')) aria-current="page" @endif
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all
                    {{ request()->routeIs('damkar.kendaraan') ? 'bg-[#E52329] text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    <span>Kendaraan</span>
                </a>

                <a href="{{ route('damkar.pos-damkar') }}" @if (request()->routeIs('damkar.pos-damkar')) aria-current="page" @endif
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all
                    {{ request()->routeIs('damkar.pos-damkar') ? 'bg-[#E52329] text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9"/>
                    </svg>
                    <span>Pos Damkar</span>
                </a>
            </nav>
        </div>

        {{-- Menu Bawah Sidebar --}}
        <div class="space-y-1.5 border-t border-slate-100 p-6">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-500 transition-all hover:bg-slate-100">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>Akun</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-500 transition-all hover:bg-red-50 hover:text-red-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Area Konten Utama --}}
    <main class="@yield('main-class', 'flex-1 space-y-6 overflow-y-auto p-8')">
        @if (session('berhasil'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-[13px] font-semibold text-emerald-700">
                {{ session('berhasil') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

    <!-- Modal Popup Laporan Kebakaran Masuk (Real-time untuk Petugas Damkar) -->
    <div id="modal-alert-laporan" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 animate-fade-in" role="alertdialog" aria-modal="true" aria-labelledby="alert-laporan-title">
        <div class="relative w-full max-w-md overflow-hidden rounded-3xl border-2 border-red-500 bg-white shadow-2xl shadow-red-950/40">
            <!-- Header Popup Darurat -->
            <div class="flex items-center justify-between bg-gradient-to-r from-red-600 via-rose-600 to-red-700 px-5 py-4 text-white">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-white/20 text-2xl shadow-inner animate-pulse">
                        🔥
                    </span>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="h-2 w-2 rounded-full bg-white animate-ping"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest text-red-100">Panggilan Darurat</span>
                        </div>
                        <h3 id="alert-laporan-title" class="text-base font-extrabold leading-tight text-white">Laporan Kebakaran Masuk!</h3>
                    </div>
                </div>
                <!-- Tombol Silang (X) untuk Menutup Popup -->
                <button type="button" onclick="tutupAlertLaporan()" aria-label="Tutup notifikasi" class="flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-white transition hover:bg-white/30 hover:scale-105">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Konten Rincian Kebakaran -->
            <div class="p-5 space-y-4 bg-[#fffaf8]">
                <div class="rounded-2xl border border-red-100 bg-white p-4 shadow-sm space-y-2">
                    <div class="flex items-center justify-between text-[11px] text-slate-500">
                        <span class="font-bold text-red-600 uppercase tracking-wide">📍 Lokasi Kejadian:</span>
                        <span id="alert-laporan-waktu" class="font-semibold text-slate-400">Baru saja</span>
                    </div>
                    <p id="alert-laporan-alamat" class="text-sm font-black text-slate-900 leading-snug">
                        Memuat lokasi kejadian...
                    </p>
                    <div class="pt-1 text-xs text-slate-600 line-clamp-2" id="alert-laporan-ket">
                        -
                    </div>
                    <div class="pt-1 flex items-center gap-1.5 text-xs text-slate-500 border-t border-slate-100 mt-2">
                        <span class="font-bold text-slate-700">Kontak Pelapor:</span>
                        <span id="alert-laporan-telp" class="font-semibold text-red-700">-</span>
                    </div>
                </div>

                <!-- Tombol Tindakan -->
                <div class="grid grid-cols-2 gap-2.5 pt-1">
                    <button type="button" onclick="tutupAlertLaporan()" class="w-full rounded-xl border border-slate-200 bg-white py-2.5 px-4 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
                        Tutup
                    </button>
                    <a id="alert-laporan-link" href="{{ route('damkar.laporan.index') }}" class="flex items-center justify-center gap-1.5 rounded-xl bg-red-600 py-2.5 px-4 text-xs font-black text-white shadow-md shadow-red-600/30 transition hover:bg-red-700 hover:scale-[1.02]">
                        <span>Tugaskan Tim ➔</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Polling Real-Time & Suara Beep 4x untuk Panel Damkar -->
    <script>
        // Generator nada "piip piip piip piip" 4 kali via Web Audio API (volume sedang, tanpa butuh file mp3 eksternal)
        function mainkanSuaraPiip4x() {
            try {
                const AudioCtx = window.AudioContext || window.webkitAudioContext;
                if (!AudioCtx) return;
                const ctx = new AudioCtx();
                if (ctx.state === 'suspended') {
                    ctx.resume();
                }

                const totalPiip = 4;
                const durasiPiip = 0.14; // lama tiap 'piip'
                const jedaPiip = 0.16;   // jeda antar 'piip'
                const frekuensi = 880;   // Nada A5 (tinggi & jernih khas sirine/pager darurat)
                const volumeSedang = 0.35; // Volume sedang aman & jelas

                for (let i = 0; i < totalPiip; i++) {
                    const mulaiPada = ctx.currentTime + (i * (durasiPiip + jedaPiip));

                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();

                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(frekuensi, mulaiPada);

                    // Fade in & fade out lembut agar tidak menimbulkan bunyi letupan (pop)
                    gain.gain.setValueAtTime(0.001, mulaiPada);
                    gain.gain.exponentialRampToValueAtTime(volumeSedang, mulaiPada + 0.02);
                    gain.gain.exponentialRampToValueAtTime(0.001, mulaiPada + durasiPiip);

                    osc.connect(gain);
                    gain.connect(ctx.destination);

                    osc.start(mulaiPada);
                    osc.stop(mulaiPada + durasiPiip);
                }
            } catch (err) {
                console.warn('Gagal memutar audio darurat:', err);
            }
        }

        function bukaAlertLaporan(data) {
            const modal = document.getElementById('modal-alert-laporan');
            if (!modal) return;

            document.getElementById('alert-laporan-alamat').textContent = data.alamat || 'Alamat tidak tertera';
            document.getElementById('alert-laporan-ket').textContent = data.keterangan || 'Laporan kebakaran darurat dari masyarakat.';
            document.getElementById('alert-laporan-waktu').textContent = data.waktu || 'Baru saja';
            document.getElementById('alert-laporan-telp').textContent = data.nomor_telepon || '-';
            if (data.url) {
                document.getElementById('alert-laporan-link').href = data.url;
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Bunyikan suara piip 4 kali dengan volume sedang
            mainkanSuaraPiip4x();
        }

        function tutupAlertLaporan() {
            const modal = document.getElementById('modal-alert-laporan');
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }

        // Jalankan polling setiap 6 detik di seluruh halaman panel Damkar
        (function () {
            let lastReportId = null;
            let isFirstLoad = true;

            async function periksaLaporanBaru() {
                try {
                    const res = await fetch("{{ route('damkar.cek-laporan') }}", {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (!res.ok) return;
                    const d = await res.json();

                    if (isFirstLoad) {
                        lastReportId = d.terakhir;
                        isFirstLoad = false;
                        return;
                    }

                    // Jika ada laporan baru yang masuk (ID lebih besar dari sebelumnya) & ada data laporan pending
                    if (d.terakhir && d.terakhir > lastReportId) {
                        lastReportId = d.terakhir;
                        if (d.laporan_baru) {
                            bukaAlertLaporan(d.laporan_baru);
                        } else {
                            // Bila status berubah tanpa payload laporan_baru, reload untuk memperbarui antrean
                            location.reload();
                        }
                    }
                } catch (e) {
                    /* coba lagi di polling berikutnya */
                }
            }

            // Cek berkala tiap 6 detik agar responsif seketika
            periksaLaporanBaru();
            setInterval(periksaLaporanBaru, 6000);
        })();
    </script>
    <script>
        // Cegah klik ganda pada tombol kirim form
        document.addEventListener('submit', function (e) {
            if (e.defaultPrevented) return;
            const btn = e.submitter || e.target.querySelector('button[type="submit"]');
            if (!btn) return;
            setTimeout(function () {
                btn.disabled = true;
                btn.classList.add('opacity-60', 'cursor-not-allowed');
            }, 0);
        });
        // Aktifkan lagi tombol bila halaman dibuka lewat tombol "Kembali" browser
        window.addEventListener('pageshow', function (e) {
            if (!e.persisted) return;
            document.querySelectorAll('button[type="submit"][disabled]').forEach(function (b) {
                b.disabled = false;
                b.classList.remove('opacity-60', 'cursor-not-allowed');
            });
        });
    </script>
</body>
</html>
