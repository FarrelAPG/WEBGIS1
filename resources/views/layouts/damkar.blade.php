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
    @if (request()->routeIs('damkar.dashboard', 'damkar.laporan.index'))
        <script>
            // Segarkan otomatis saat ada laporan baru / perubahan status (cek tiap 15 detik)
            (function () {
                let tandaAwal = null;
                async function cekLaporan() {
                    if (document.hidden) return;
                    try {
                        const res = await fetch("{{ route('damkar.cek-laporan') }}", { headers: { 'Accept': 'application/json' } });
                        if (!res.ok) return;
                        const d = await res.json();
                        const tanda = [d.pending, d.diproses, d.terakhir].join('-');
                        if (tandaAwal === null) { tandaAwal = tanda; return; }
                        if (tanda !== tandaAwal) location.reload();
                    } catch (e) { /* abaikan, coba lagi di putaran berikutnya */ }
                }
                cekLaporan();
                setInterval(cekLaporan, 15000);
            })();
        </script>
    @endif
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
