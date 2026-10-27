<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#c4111b">
    <title>SIGAP DAMKAR — Portal Akses Pengguna</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-900 font-sans text-slate-100 antialiased selection:bg-red-500 selection:text-white flex flex-col justify-between">

    {{-- Background Pattern & Glow --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-32 -left-32 h-96 w-96 rounded-full bg-red-600/20 blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 h-96 w-96 rounded-full bg-blue-600/15 blur-3xl"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#ffffff0a_1px,transparent_1px)] [background-size:24px_24px]"></div>
    </div>

    {{-- Header / Logo --}}
    <header class="relative z-10 w-full pt-8 pb-4 px-6 text-center">
        <div class="mx-auto flex max-w-4xl flex-col items-center">
            <span class="inline-flex items-center gap-2 rounded-full border border-red-500/30 bg-red-500/10 px-3.5 py-1 text-[11px] font-extrabold uppercase tracking-widest text-red-400">
                <span class="h-2 w-2 rounded-full bg-red-500 animate-pulse"></span>
                Dinas Pemadam Kebakaran &amp; Penyelamatan Kota Palembang
            </span>

            <div class="mt-4 flex items-center justify-center gap-3">
                <img src="{{ asset('images/logo-sigap-red.png') }}" alt="SIGAP DAMKAR" class="h-12 w-12 shrink-0 rounded-2xl object-contain shadow-lg shadow-red-600/30">
                <div class="text-left">
                    <h1 class="text-3xl font-black tracking-tight text-white sm:text-4xl">SIGAP DAMKAR</h1>
                    <p class="text-xs font-semibold tracking-wide text-slate-400">Sistem Informasi Geografis &amp; Armada Pemadam</p>
                </div>
            </div>

            <p class="mt-4 max-w-md text-sm text-slate-300">
                Selamat datang di platform respon cepat bencana kebakaran. Silakan pilih portal akses Anda untuk melanjutkan:
            </p>
        </div>
    </header>

    {{-- Main Cards Selection --}}
    <main class="relative z-10 w-full px-6 py-6 flex-1 flex items-center justify-center">
        <div class="mx-auto w-full max-w-4xl grid gap-6 md:grid-cols-2">

            {{-- ── CARD 1: MASYARAKAT (PUBLIK) ── --}}
            <a href="{{ route('beranda') }}"
               class="group relative flex flex-col justify-between overflow-hidden rounded-3xl border border-red-500/30 bg-gradient-to-b from-slate-800/90 to-slate-850/90 p-7 shadow-xl shadow-red-950/20 backdrop-blur-md transition-all duration-300 hover:-translate-y-1.5 hover:border-red-500 hover:shadow-2xl hover:shadow-red-900/40 focus:outline-none focus:ring-4 focus:ring-red-500/30">
                
                {{-- Accent Top Glow --}}
                <div class="absolute -right-12 -top-12 h-32 w-32 rounded-full bg-red-500/20 blur-2xl group-hover:bg-red-500/35 transition-colors"></div>

                <div>
                    {{-- Badge & Icon --}}
                    <div class="flex items-center justify-between gap-3">
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-[#c4111b] to-[#E52329] text-white shadow-lg shadow-red-600/30 transition-transform group-hover:scale-110">
                            <svg class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 23c6.075 0 11-4.925 11-11 0-4.04-2.18-7.572-5.434-9.524a.75.75 0 0 0-1.096.862C17.065 5.508 17.5 7.95 17.5 10c0 .605-.06 1.196-.176 1.767a8.96 8.96 0 0 0-3.324-2.767.75.75 0 0 0-1.077.72c.078 1.488-.363 2.981-1.282 4.108C10.59 15.12 9.297 15.75 8 15.75c-.88 0-1.725-.262-2.45-.733A6.974 6.974 0 0 1 4.5 12c0-2.316.892-4.423 2.352-6.002a.75.75 0 0 0-.58-1.222C3.132 5.378 1 8.442 1 12c0 6.075 4.925 11 11 11z"/>
                            </svg>
                        </span>
                        <span class="rounded-full border border-red-400/30 bg-red-500/10 px-3 py-1 text-[11px] font-bold text-red-300">
                            Publik / Warga
                        </span>
                    </div>

                    {{-- Title & Subtitle --}}
                    <h2 class="mt-6 text-2xl font-black text-white group-hover:text-red-400 transition-colors">
                        Masyarakat
                    </h2>
                    <p class="mt-2 text-xs leading-relaxed text-slate-300">
                        Portal layanan kedaruratan untuk warga masyarakat Kota Palembang. Laporkan insiden seketika &amp; pantau kesiagaan damkar.
                    </p>

                    {{-- Fitur Unggulan --}}
                    <ul class="mt-5 space-y-2.5 text-xs text-slate-300">
                        <li class="flex items-center gap-2">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-red-500/20 text-red-400 text-[11px] font-bold">✓</span>
                            <span>Aktivasi cepat 1-ketukan laporan koordinat GPS</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-red-500/20 text-red-400 text-[11px] font-bold">✓</span>
                            <span>Peta lokasi Pos Damkar &amp; jarak terdekat secara real-time</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-red-500/20 text-red-400 text-[11px] font-bold">✓</span>
                            <span>Pelacakan perjalanan armada damkar meluncur ke TKP</span>
                        </li>
                    </ul>
                </div>

                {{-- Action Button --}}
                <div class="mt-7 flex items-center justify-between rounded-2xl bg-gradient-to-r from-[#c4111b] to-[#E52329] px-5 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-red-900/40 group-hover:from-red-600 group-hover:to-red-500 transition-all">
                    <span>Masuk sebagai Masyarakat</span>
                    <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </div>
            </a>


            {{-- ── CARD 2: ADMIN DAMKAR (PETUGAS) ── --}}
            <a href="{{ route('damkar.dashboard') }}"
               class="group relative flex flex-col justify-between overflow-hidden rounded-3xl border border-blue-500/30 bg-gradient-to-b from-slate-800/90 to-slate-850/90 p-7 shadow-xl shadow-blue-950/20 backdrop-blur-md transition-all duration-300 hover:-translate-y-1.5 hover:border-blue-400 hover:shadow-2xl hover:shadow-blue-900/40 focus:outline-none focus:ring-4 focus:ring-blue-500/30">
                
                {{-- Accent Top Glow --}}
                <div class="absolute -right-12 -top-12 h-32 w-32 rounded-full bg-blue-500/20 blur-2xl group-hover:bg-blue-500/35 transition-colors"></div>

                <div>
                    {{-- Badge & Icon --}}
                    <div class="flex items-center justify-between gap-3">
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-700 to-slate-800 text-white shadow-lg shadow-blue-600/30 transition-transform group-hover:scale-110">
                            <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                            </svg>
                        </span>
                        <span class="rounded-full border border-blue-400/30 bg-blue-500/10 px-3 py-1 text-[11px] font-bold text-blue-300">
                            Khusus Petugas
                        </span>
                    </div>

                    {{-- Title & Subtitle --}}
                    <h2 class="mt-6 text-2xl font-black text-white group-hover:text-blue-400 transition-colors">
                        Admin / Petugas Damkar
                    </h2>
                    <p class="mt-2 text-xs leading-relaxed text-slate-300">
                        Panel kendali pos komando operasional lapangan, disposisi unit taktis armada, verifikasi insiden, &amp; pemantauan GIS.
                    </p>

                    {{-- Fitur Unggulan --}}
                    <ul class="mt-5 space-y-2.5 text-xs text-slate-300">
                        <li class="flex items-center gap-2">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-500/20 text-blue-400 text-[11px] font-bold">✓</span>
                            <span>Dashboard monitoring laporan masuk real-time</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-500/20 text-blue-400 text-[11px] font-bold">✓</span>
                            <span>Disposisi armada &amp; navigasi rute tercepat ke TKP</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-500/20 text-blue-400 text-[11px] font-bold">✓</span>
                            <span>Peta sumber air &amp; zonasi rawan bencana kebakaran</span>
                        </li>
                    </ul>
                </div>

                {{-- Action Button --}}
                <div class="mt-7 flex items-center justify-between rounded-2xl bg-gradient-to-r from-blue-700 to-indigo-700 px-5 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-blue-950/40 group-hover:from-blue-600 group-hover:to-indigo-600 transition-all">
                    <span>Masuk sebagai Petugas</span>
                    <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </div>
            </a>

        </div>
    </main>

    {{-- Footer & Emergency Hotline --}}
    <footer class="relative z-10 w-full py-6 px-6 text-center border-t border-slate-800 bg-slate-900/80 backdrop-blur-sm">
        <div class="mx-auto flex max-w-4xl flex-wrap items-center justify-between gap-4 text-xs text-slate-400">
            <div class="flex items-center gap-2">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-red-600/20 text-red-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </span>
                <span class="font-bold text-slate-300">Panggilan Darurat Bebas Pulsa:</span>
                <a href="tel:112" class="font-extrabold text-red-400 hover:text-red-300 transition-colors">Hotline 112 Damkar</a>
            </div>

            <p class="text-[11px] text-slate-500">
                &copy; {{ date('Y') }} Dinas Pemadam Kebakaran dan Penyelamatan Kota Palembang
            </p>
        </div>
    </footer>

</body>
</html>

