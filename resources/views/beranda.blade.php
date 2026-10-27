<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP Damkar — Beranda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans text-[#292626] antialiased bg-[#fffaf8]">
    {{-- Wrapper utama: w-full penuh di desktop, natural di mobile --}}
    <div class="min-h-screen w-full bg-[#fffaf8] flex flex-col justify-between">
        
        {{-- ===== HEADER ===== --}}
        <header class="sticky top-0 z-20 w-full border-b border-[#f2e9e6] bg-[#fffaf8]/95 backdrop-blur">
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8 py-3.5">
                {{-- Logo & Judul --}}
                <a href="{{ route('beranda') }}" class="flex min-w-0 items-center gap-2.5 sm:gap-3" aria-label="SIGAP Damkar Beranda">
                    <span class="flex h-10 w-10 sm:h-11 sm:w-11 shrink-0 items-center justify-center rounded-xl border border-slate-100 bg-white p-1.5 shadow-sm">
                        <img src="{{ asset('images/sigap-logo.svg') }}" alt="" class="h-full w-full object-contain">
                    </span>
                    <span class="min-w-0 leading-tight">
                        <span class="block text-[10px] sm:text-xs font-extrabold tracking-[0.14em] text-[#bd101b]">SIGAP DAMKAR</span>
                        <span class="block text-xl sm:text-2xl font-bold tracking-tight text-[#292626]">Beranda</span>
                    </span>
                </a>

                {{-- Navigasi Desktop (md: dan lg:) --}}
                <nav class="hidden md:flex items-center gap-1.5 lg:gap-3 text-sm font-semibold text-[#665a57]">
                    <a href="{{ route('beranda') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[#bd101b] bg-red-50 font-bold transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V10Z"/></svg>
                        <span>Beranda</span>
                    </a>
                    <a href="{{ route('peta') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:text-[#bd101b] hover:bg-[#fff0ed] transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Zm6-3v15m6-12v15"/></svg>
                        <span>Peta Pos Damkar</span>
                    </a>
                    <a href="{{ route('laporan.saya') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:text-[#bd101b] hover:bg-[#fff0ed] transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6l1 2h4v15H4V6h4l1-2Zm1 6h4m-4 4h6m-6 4h6"/></svg>
                        <span>Laporan Saya</span>
                    </a>
                    <a href="{{ route('edukasi.index') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:text-[#bd101b] hover:bg-[#fff0ed] transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Edukasi</span>
                    </a>
                </nav>

                {{-- Aksi Kanan Header --}}
                <div class="flex items-center gap-2 sm:gap-3">
                    <button type="button" aria-label="Notifikasi Kebakaran" onclick="toggleModalNotif(true)" class="relative rounded-full p-1.5 text-[#473a38] transition hover:bg-black/5">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg>
                        @if(isset($kebakaranTerverifikasi) && $kebakaranTerverifikasi->isNotEmpty())
                            <span class="absolute -top-0.5 -right-0.5 flex h-4 w-4">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-4 w-4 bg-[#c41621] text-[9px] font-black text-white items-center justify-center ring-2 ring-[#fffaf8]">
                                    {{ $kebakaranTerverifikasi->count() }}
                                </span>
                            </span>
                        @endif
                    </button>
                    <div class="flex items-center gap-1">
                        <button type="button" id="btn-refresh-halaman" class="inline-flex items-center gap-1 rounded-lg px-2 py-1.5 text-[10px] font-bold text-[#bd101b] transition hover:bg-red-50 disabled:cursor-wait disabled:opacity-60" aria-label="Refresh informasi kebakaran" title="Refresh informasi kebakaran">
                            <svg id="halaman-refresh-icon" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            <span class="hidden sm:inline">Refresh</span>
                        </button>
                        <span id="halaman-refresh-status" class="hidden text-[10px] font-semibold text-[#766965] lg:inline" aria-live="polite">20 dtk</span>
                    </div>
                    <a href="{{ route('masyarakat.profile') }}" class="h-9 w-9 sm:h-10 sm:w-10 overflow-hidden rounded-full border-2 border-[#e7b5ae] bg-white p-0.5 transition hover:ring-2 hover:ring-[#c41621]/30" aria-label="Profil">
                        <img src="{{ asset('images/avatar.svg') }}" alt="Foto profil" class="h-full w-full rounded-full object-cover">
                    </a>
                </div>
            </div>
        </header>

        {{-- ===== AREA KONTEN UTAMA ===== --}}
        <main class="flex-1 w-full">
            <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-5 sm:py-7 lg:py-8 space-y-6">

                {{-- Sapaan & Lokasi GPS --}}
                <section aria-labelledby="greeting-title" class="space-y-1.5">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <h1 id="greeting-title" class="text-[22px] font-bold leading-tight tracking-tight sm:text-2xl md:text-3xl text-[#292626]">
                            Halo, @auth{{ Auth::user()->name }}@else Warga Palembang @endauth <span aria-hidden="true">👋</span>
                        </h1>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 border border-emerald-200/60 px-3 py-1 text-[11px] sm:text-xs font-semibold text-emerald-800 shadow-sm">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>Posisi Aman
                        </span>
                    </div>
                    <p class="text-sm sm:text-base text-[#766965]">Tetap waspada, laporkan keadaan darurat kebakaran dan penyelamatan segera.</p>
                    <div class="flex items-center gap-1.5 text-[13px] sm:text-sm font-semibold text-[#49403e]">
                        <svg class="h-4 w-4 shrink-0 text-[#c41520]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.5a7.5 7.5 0 0 0-7.5 7.5c0 5.6 7.5 11.5 7.5 11.5S19.5 15.6 19.5 10A7.5 7.5 0 0 0 12 2.5Zm0 10.2a2.7 2.7 0 1 1 0-5.4 2.7 2.7 0 0 1 0 5.4Z"/></svg>
                        <span id="lokasi-pengguna" class="transition-opacity duration-200">Kota Palembang, Sumatera Selatan</span>
                        <button type="button" id="btn-refresh-lokasi" title="Perbarui lokasi GPS" class="text-slate-400 hover:text-[#c41520] transition-colors p-1 rounded-full hover:bg-slate-100">
                            <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </button>
                    </div>
                </section>

                {{-- Banner Peringatan Kebakaran Aktif Publik --}}
                @if(isset($kebakaranTerverifikasi) && $kebakaranTerverifikasi->isNotEmpty())
                    <section class="overflow-hidden rounded-2xl border-2 border-red-500 bg-gradient-to-r from-red-600 via-rose-600 to-red-700 text-white shadow-xl shadow-red-600/25" aria-labelledby="live-alert-title">
                        <div class="p-4 sm:p-5 flex items-start gap-3.5">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/20 text-2xl shadow">
                                🔥
                            </span>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="bg-white text-red-700 text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full">
                                        Peringatan Kebakaran Aktif
                                    </span>
                                    <span class="text-xs text-white/90 font-bold">• Terverifikasi Damkar</span>
                                </div>
                                <h3 class="mt-1 text-sm sm:text-base font-extrabold leading-snug line-clamp-1">
                                    {{ $kebakaranTerverifikasi->first()->alamat }}
                                </h3>
                                <p class="text-[11px] text-white/90 mt-0.5">
                                    Terdeteksi {{ $kebakaranTerverifikasi->count() }} kebakaran aktif sedang ditangani Damkar. Warga sekitar dihimbau waspada &amp; hindari lokasi.
                                </p>
                                <div class="mt-3 flex items-center gap-2">
                                    <a href="{{ route('peta', ['fokus' => $kebakaranTerverifikasi->first()->id]) }}" class="inline-flex items-center gap-1.5 bg-white text-red-700 hover:bg-red-50 px-3.5 py-1.5 rounded-xl text-xs font-black shadow transition">
                                        <span>Pantau Titik Api di Peta 🗺️</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

                {{-- Responsive Grid: Stacked di Mobile, 2 Kolom Berdampingan di Desktop (lg:grid lg:grid-cols-2 lg:gap-8) --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-start">

                    {{-- ── KOLOM KIRI: Area Aksi Utama (SOS / Banner Lapor + Laporan Aktif) ── --}}
                    <div class="space-y-6">

                        {{-- Hero Emergency Banner (Seluruh kartu dapat diklik untuk membuat laporan) --}}
                        <a href="{{ route('lapor.create') }}" id="btn-aktivasi-lapor" class="group block overflow-hidden rounded-2xl bg-gradient-to-br from-[#c4111b] via-[#b90d17] to-[#d01b26] text-white shadow-[0_14px_28px_rgba(168,12,24,0.17)] transition-all hover:shadow-[0_18px_36px_rgba(168,12,24,0.26)] hover:scale-[1.01] active:scale-[0.99] cursor-pointer" aria-labelledby="emergency-title">
                            <div class="p-5 sm:p-6 lg:p-7">
                                <div class="mb-4 flex items-center justify-between gap-3">
                                    <div class="flex min-w-0 items-center gap-2.5">
                                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white/15 ring-1 ring-white/10 transition-transform group-hover:scale-105">
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c1 3-1 4.5.5 6 1.7-1.2 2.1-2.7 2.2-3.5C18 9 19 11 19 14a7 7 0 1 1-14 0c0-2.5 1-4.2 3.2-6.5-.1 2.2.7 3.3 1.8 4C11 9 10 6 12 3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 13c1 1.1 2 2.1 2 3.5a2 2 0 1 1-4 0c0-1.4.9-2.4 2-3.5Z"/></svg>
                                        </span>
                                        <span class="truncate rounded-full bg-white/15 px-2.5 py-1 text-[10px] sm:text-xs font-bold uppercase tracking-wide"><span class="mr-1.5 inline-block h-1.5 w-1.5 rounded-full bg-white"></span>Sinyal darurat langsung</span>
                                    </div>
                                    <span class="flex h-10 w-10 sm:h-11 sm:w-11 shrink-0 items-center justify-center rounded-full bg-white text-sm sm:text-base font-black text-[#c41621] shadow transition-transform group-hover:scale-110">SOS</span>
                                </div>
                                <h2 id="emergency-title" class="text-[34px] sm:text-[40px] lg:text-[44px] font-extrabold uppercase leading-[0.98] tracking-tight">Lapor<br>Kebakaran</h2>
                                <p class="mt-2 text-[13px] leading-[1.45] text-white/95 sm:text-sm md:text-base">Tekan untuk laporan darurat seketika &amp; kirim sinyal lokasi GPS langsung ke komando pusat penanganan bencana.</p>
                            </div>
                            <div class="flex min-h-12 sm:min-h-14 items-center justify-between gap-3 bg-white px-5 sm:px-7 text-[11px] sm:text-xs md:text-sm font-extrabold uppercase tracking-wide text-black transition group-hover:bg-gray-100">
                                <span>Aktivasi cepat 1-ketukan <span class="normal-case tracking-normal text-black/80">— Kirim titik koordinat</span></span>
                                <svg class="h-5 w-5 shrink-0 text-black transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                            </div>
                        </a>

                        {{-- Laporan Aktif Anda (Bila Ada) --}}
                        @if ($laporanAktif)
                            @php
                                $tahap = $laporanAktif->tahapMasyarakat();
                            @endphp
                            <section id="laporan-aktif" aria-labelledby="report-title" class="space-y-2.5">
                                <div class="flex items-center justify-between gap-2">
                                    <h2 id="report-title" class="flex items-center gap-1.5 text-sm sm:text-base font-bold text-[#292626]">
                                        <span class="h-2.5 w-2.5 rounded-full bg-[#c41621] animate-pulse"></span>Laporan Aktif Anda
                                    </h2>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[11px] sm:text-xs font-semibold text-[#766965]">ID: #SIGAP-{{ str_pad($laporanAktif->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>
                                <article class="rounded-2xl border border-[#f3eeeb] bg-white p-4 sm:p-5 lg:p-6 shadow-[0_3px_12px_rgba(65,45,40,0.04)]">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <h3 class="truncate text-[17px] sm:text-lg font-bold leading-tight text-[#292626]">{{ $laporanAktif->alamat }}</h3>
                                            <p class="mt-1 flex flex-wrap items-center gap-1 text-[11px] sm:text-xs text-[#766965]">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 2"/></svg>
                                                {{ $laporanAktif->created_at->diffForHumans() }} <span class="text-[#d5cbc7]">•</span> <span class="font-semibold text-[#bc111c]">Laporan Darurat</span>
                                            </p>
                                        </div>
                                        <span class="flex h-11 w-12 sm:h-12 sm:w-14 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-[#e8eff1] text-2xl sm:text-3xl" aria-label="Ilustrasi mobil pemadam">🚒</span>
                                    </div>
                                    <div class="mt-3.5 flex gap-2 rounded-xl bg-[#fff0e5] p-3 text-[11px] sm:text-xs font-medium leading-relaxed text-[#79420f]">
                                        <span class="mt-0.5 h-3 w-3 shrink-0 rounded-full bg-[#b76400]"></span>
                                        <span>
                                            @if ($laporanAktif->status === 'pending')
                                                Laporan Diterima (Menunggu Verifikasi Petugas)
                                            @elseif ($laporanAktif->status === 'diproses')
                                                Sedang Ditangani Damkar (Armada Meluncur / Penanganan di TKP)
                                            @else
                                                Tahap Akhir Penanganan
                                            @endif
                                        </span>
                                    </div>
                                    <ol class="mt-5 grid grid-cols-4 gap-2 text-center" aria-label="Tahapan penanganan laporan">
                                        <li class="flex flex-col items-center gap-1.5">
                                            <span class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-full bg-[#c41621] text-xs font-bold text-white shadow-sm">✓</span>
                                            <span class="text-[10px] sm:text-xs font-semibold text-slate-900">Diterima</span>
                                        </li>
                                        <li class="flex flex-col items-center gap-1.5">
                                            <span class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-full {{ $tahap >= 1 ? 'bg-[#c41621] text-white shadow-sm font-bold text-xs' : 'bg-[#f1efed] text-xs font-bold text-[#b8b2af]' }}">{{ $tahap >= 1 ? '✓' : '2' }}</span>
                                            <span class="text-[10px] sm:text-xs font-semibold {{ $tahap >= 1 ? 'text-slate-900' : 'text-[#b8b2af]' }}">Verifikasi</span>
                                        </li>
                                        <li class="flex flex-col items-center gap-1.5">
                                            <span class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-full {{ $tahap >= 2 ? 'bg-[#c41621] text-white shadow-sm font-bold text-xs' : 'bg-[#f1efed] text-xs font-bold text-[#b8b2af]' }}">{{ $tahap >= 2 ? '✓' : '3' }}</span>
                                            <span class="text-[10px] sm:text-xs font-semibold {{ $tahap >= 2 ? 'text-slate-900' : 'text-[#b8b2af]' }}">Meluncur</span>
                                        </li>
                                        <li class="flex flex-col items-center gap-1.5">
                                            <span class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-full {{ $tahap >= 3 ? 'bg-[#c41621] text-white shadow-sm font-bold text-xs' : 'bg-[#f1efed] text-xs font-bold text-[#b8b2af]' }}">{{ $tahap >= 3 ? '✓' : '4' }}</span>
                                            <span class="text-[10px] sm:text-xs font-semibold {{ $tahap >= 3 ? 'text-slate-900' : 'text-[#b8b2af]' }}">Penanganan</span>
                                        </li>
                                    </ol>
                                    <a href="{{ route('laporan.lacak', $laporanAktif) }}" class="mt-4 flex min-h-11 sm:min-h-12 items-center justify-center gap-1.5 rounded-xl bg-[#f2f0ef] px-4 text-center text-xs sm:text-sm font-bold text-[#393331] transition hover:bg-[#e9e5e3]">
                                        Lihat Detail Laporan &amp; Posisi Armada
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                    </a>
                                </article>
                            </section>
                        @endif

                    </div>

                    {{-- ── KOLOM KANAN: Informasi Pendukung (Kondisi Wilayah, Hotline 112, Edukasi, Peta) ── --}}
                    <div class="space-y-6">

                        {{-- Kondisi Wilayah Sekitar --}}
                        <section aria-labelledby="area-title" class="space-y-2.5">
                            <div class="flex items-center justify-between gap-2">
                                <h2 id="area-title" class="text-sm sm:text-base font-bold text-[#292626]">Kondisi Wilayah Sekitar</h2>
                                <span class="text-[9px] sm:text-[11px] font-bold uppercase tracking-wide text-[#bd101b]">Pembaruan 1m lalu</span>
                            </div>
                            <div class="grid grid-cols-3 gap-2.5 sm:gap-3 lg:gap-4">
                                <article class="min-w-0 rounded-2xl border border-[#f3eeeb] bg-white p-3.5 sm:p-4 shadow-[0_3px_10px_rgba(65,45,40,0.04)] hover:shadow-md transition">
                                    <div class="mb-2 sm:mb-3 flex items-center gap-1.5">
                                        <span class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-lg bg-[#ffe0dc] text-[#c41621]">
                                            <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c1 3-1 4.5.5 6 1.7-1.2 2.1-2.7 2.2-3.5C18 9 19 11 19 14a7 7 0 1 1-14 0c0-2.5 1-4.2 3.2-6.5-.1 2.2.7 3.3 1.8 4C11 9 10 6 12 3Z"/></svg>
                                        </span>
                                        <span class="whitespace-nowrap rounded-full bg-[#ffe0dc] px-1.5 py-0.5 text-[9px] sm:text-[10px] font-bold text-[#a20c15]">{{ $totalKejadianAktif ?? 0 }} Aktif</span>
                                    </div>
                                    <p class="text-[17px] sm:text-lg font-bold leading-tight">Palembang</p>
                                    <p class="mt-0.5 text-[11px] sm:text-xs text-[#685b57]">Wilayah Operasi</p>
                                </article>
                                <article class="min-w-0 rounded-2xl border border-[#f3eeeb] bg-white p-3.5 sm:p-4 shadow-[0_3px_10px_rgba(65,45,40,0.04)] hover:shadow-md transition">
                                    <div class="mb-2 sm:mb-3 flex items-center gap-1.5">
                                        <span class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-lg bg-[#dceaff] text-[#1c4c8c]">
                                            <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 21V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16M2 21h20M8 7h2m4 0h2M8 11h2m4 0h2M8 15h2m4 0h2M10 21v-3h4v3"/></svg>
                                        </span>
                                        <span class="whitespace-nowrap rounded-full bg-[#dceaff] px-1.5 py-0.5 text-[9px] sm:text-[10px] font-bold text-[#213f66]">Siaga</span>
                                    </div>
                                    <p class="text-[17px] sm:text-lg font-bold leading-tight">8 Pos</p>
                                    <p class="mt-0.5 text-[11px] sm:text-xs text-[#685b57]">Pos Damkar</p>
                                </article>
                                <article class="min-w-0 rounded-2xl border border-[#f3eeeb] bg-white p-3.5 sm:p-4 shadow-[0_3px_10px_rgba(65,45,40,0.04)] hover:shadow-md transition">
                                    <div class="mb-2 sm:mb-3 flex items-center gap-1.5">
                                        <span class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-lg bg-[#ffe1cc] text-[#a44d0b]">
                                            <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m10.3 3.8-8 14A2 2 0 0 0 4 20.8h16a2 2 0 0 0 1.7-3l-8-14a2 2 0 0 0-3.4 0ZM12 9v4m0 3h.01"/></svg>
                                        </span>
                                        <span class="whitespace-nowrap rounded-full bg-[#ffe1cc] px-1.5 py-0.5 text-[9px] sm:text-[10px] font-bold text-[#704018]">Waspada</span>
                                    </div>
                                    <p class="text-[17px] sm:text-lg font-bold leading-tight">24 Jam</p>
                                    <p class="mt-0.5 text-[11px] sm:text-xs text-[#685b57]">Status Siaga</p>
                                </article>
                            </div>
                        </section>

                        {{-- Hotline 112 Damkar --}}
                        <section aria-labelledby="hotline-title" class="flex flex-row items-center justify-between gap-3.5 rounded-2xl bg-gradient-to-br from-[#e7f0ff] via-[#dceaff] to-[#cfe2fe] p-4 sm:p-5 lg:p-6 shadow-[0_3px_12px_rgba(50,80,130,0.08)] border border-blue-200/60">
                            <div class="flex items-center gap-3">
                                <span class="flex h-12 w-12 sm:h-14 sm:w-14 shrink-0 items-center justify-center rounded-full bg-[#0064ad] text-white shadow-md">
                                    <svg class="h-6 w-6 sm:h-7 sm:w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4h4l2 5-2.5 1.5a15 15 0 0 0 6 6L15 14l5 2v4a1 1 0 0 1-1 1C9.6 21 3 14.4 3 5a1 1 0 0 1 1-1Z"/></svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[9px] sm:text-[10px] font-extrabold uppercase tracking-wide text-[#075a9c]">Panggilan siaga 24 jam</p>
                                    <h2 id="hotline-title" class="text-lg sm:text-xl font-bold leading-tight text-[#123452]">Hotline 112 Damkar</h2>
                                    <p class="text-[11px] sm:text-xs leading-tight text-[#756b69]">Bebas Pulsa &amp; Respons Tanggap</p>
                                </div>
                            </div>
                            <a href="tel:112" class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-[#0064ad] hover:bg-[#00538f] px-4 py-2.5 sm:py-3 text-[11px] sm:text-xs font-bold text-white shadow-md transition">
                                <span>Panggil</span>
                                <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4h4l2 5-2.5 1.5a15 15 0 0 0 6 6L15 14l5 2v4a1 1 0 0 1-1 1Zm14 1a6 6 0 0 1 2 4m-2-8a10 10 0 0 1 4 8"/></svg>
                            </a>
                        </section>

                        {{-- Edukasi & Antisipasi Cepat --}}
                        <section aria-labelledby="education-title" class="space-y-2.5">
                            <div class="flex items-center justify-between gap-2">
                                <h2 id="education-title" class="text-sm sm:text-base font-bold text-[#292626]">Edukasi &amp; Antisipasi Cepat</h2>
                                <a href="{{ route('edukasi.index') }}" class="text-[10px] sm:text-xs font-semibold text-[#bd101b] hover:underline">Lihat Semua</a>
                            </div>
                            <a href="{{ route('edukasi.tata') }}" class="group flex items-center gap-3.5 rounded-2xl border border-[#f3eeeb] bg-white p-3.5 sm:p-4 shadow-[0_3px_12px_rgba(65,45,40,0.04)] hover:shadow-md hover:border-red-100 transition-all">
                                <span class="flex h-[58px] w-16 sm:h-16 sm:w-16 shrink-0 items-center justify-center rounded-xl bg-[#eef0ed] text-[#9a3026] group-hover:scale-105 transition-transform">
                                    <svg class="h-10 w-10 sm:h-11 sm:w-11" viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M17 13h14v4H17z" fill="#77716b"/><path d="M20 17h8v23h-8z" rx="2" fill="#c8c7bf" stroke="#77716b" stroke-width="1.5"/><path d="M22 9h4v4h-4zM21 22h6v2h-6z" fill="#bd101b"/><path d="M18 19h-3v5h3m13-5h3v5h-3" stroke="#77716b" stroke-width="1.5" stroke-linecap="round"/><path d="M23 26h2m-1-1v4" stroke="#bd101b" stroke-width="1.5" stroke-linecap="round"/><path d="M24 9c-2-2-1-4 0-5 1 2 2 3 0 5Z" fill="#e9a22b"/></svg>
                                </span>
                                <span class="min-w-0 flex-1">
                                    <span class="flex flex-wrap items-center gap-1.5 text-[10px] sm:text-[11px] text-[#766965]">
                                        <span class="rounded bg-[#fff0e5] px-1.5 py-0.5 font-semibold text-[#8b4c27]">Tips APAR</span>
                                        <span>Baca 1 menit</span>
                                    </span>
                                    <span class="mt-1 block text-[13px] sm:text-sm font-bold leading-snug text-[#292626] group-hover:text-[#bd101b] transition-colors">Metode T.A.T.A Saat Api Mulai Muncul</span>
                                    <span class="mt-0.5 block truncate text-[11px] sm:text-xs text-[#766965]">Tarik pin, Arahkan nozzle, Tekan tuas,...</span>
                                </span>
                                <svg class="h-4 w-4 shrink-0 text-[#6d514b] group-hover:translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                            </a>
                        </section>

                        {{-- Kartu Tautan Peta Interaktif (Desktop) --}}
                        <section class="hidden lg:block rounded-2xl border border-[#f3eeeb] bg-white p-4 sm:p-5 shadow-[0_3px_12px_rgba(65,45,40,0.04)] space-y-2.5">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-bold text-[#292626]">Peta Pos &amp; Wilayah</h3>
                                <span class="rounded-full bg-red-50 px-2 py-0.5 text-[10px] font-bold text-[#bd101b]">GIS Aktif</span>
                            </div>
                            <p class="text-xs text-[#766965] leading-relaxed">Pantau jangkauan respon 8 Pos Damkar Kota Palembang dan temukan titik hidran / sumber air di sekitar Anda.</p>
                            <a href="{{ route('peta') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-[#bd101b]/20 bg-[#fff5f4] px-4 py-2.5 text-xs font-bold text-[#bd101b] transition hover:bg-[#bd101b] hover:text-white">
                                <span>Buka Peta Interaktif</span>
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                            </a>
                        </section>

                    </div>

                </div>

            </div>
        </main>

        {{-- ===== FOOTER DESKTOP (Hanya muncul di md: ke atas) ===== --}}
        <footer class="hidden md:block w-full border-t border-[#f0e8e5] bg-[#fffaf8]">
            <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-5">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-[#766965]">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-[#bd101b]">SIGAP DAMKAR</span>
                        <span>— Sistem Informasi Geografis &amp; Tanggap Kebakaran Kota Palembang</span>
                    </div>
                    <div class="flex items-center gap-4 text-xs font-medium">
                        <a href="{{ route('beranda') }}" class="hover:text-[#bd101b] transition">Beranda</a>
                        <a href="{{ route('peta') }}" class="hover:text-[#bd101b] transition">Peta</a>
                        <a href="{{ route('edukasi.index') }}" class="hover:text-[#bd101b] transition">Edukasi</a>
                        <a href="tel:112" class="font-bold text-[#0064ad] hover:underline">Hotline 112</a>
                    </div>
                </div>
            </div>
        </footer>

        {{-- ===== NAVIGASI BAWAH MOBILE (Hanya tampil di mobile, md:hidden) ===== --}}
        <nav aria-label="Navigasi utama" class="sticky bottom-0 z-30 w-full border-t border-[#f0e8e5] bg-[#fffaf8]/95 shadow-[0_-4px_18px_rgba(60,35,30,0.05)] backdrop-blur md:hidden">
            <div class="mx-auto grid max-w-md grid-cols-4 px-2 pb-[max(0.55rem,env(safe-area-inset-bottom))] pt-2">
                <a href="{{ route('beranda') }}" aria-current="page" class="flex flex-col items-center gap-0.5 text-[#bd101b]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V10Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6c.8 1.5-.7 2.2.4 3 1-.5 1.3-1.4 1.3-1.4 1.2 1.7 1.3 2.6.3 3.7"/></svg>
                    <span class="text-[10px] font-bold">Beranda</span>
                </a>
                <a href="{{ route('peta') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Zm6-3v15m6-12v15"/></svg>
                    <span class="text-[10px] font-bold">Peta</span>
                </a>
                <a href="{{ route('laporan.saya') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6l1 2h4v15H4V6h4l1-2Zm1 6h4m-4 4h6m-6 4h6"/></svg>
                    <span class="text-[10px] font-bold">Laporan</span>
                </a>
                <a href="{{ route('masyarakat.profile') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2H4Z"/></svg>
                    <span class="text-[10px] font-bold">Profil</span>
                </a>
            </div>
        </nav>
    </div>

    {{-- Script Geolocation & reverse geocoding preserved --}}
    <script>
        (function() {
            const elLokasi = document.getElementById('lokasi-pengguna');
            const btnRefresh = document.getElementById('btn-refresh-lokasi');
            const btnAktivasi = document.getElementById('btn-aktivasi-lapor');
            const btnRefreshHalaman = document.getElementById('btn-refresh-halaman');
            const halamanRefreshStatus = document.getElementById('halaman-refresh-status');
            const halamanRefreshIcon = document.getElementById('halaman-refresh-icon');

            const STORAGE_KEY = 'sigap_user_geo';

            // Coba pulihkan dari cache sessionStorage agar tidak berkedip
            const cached = sessionStorage.getItem(STORAGE_KEY);
            if (cached) {
                try {
                    const parsed = JSON.parse(cached);
                    if (parsed && parsed.label) {
                        elLokasi.textContent = parsed.label;
                        perbaruiLinkLapor(parsed.lat, parsed.lng);
                    }
                } catch (e) {}
            }

            function perbaruiLinkLapor(lat, lng) {
                if (btnAktivasi && lat && lng) {
                    btnAktivasi.href = "{{ route('lapor.create') }}?lat=" + encodeURIComponent(lat) + "&lng=" + encodeURIComponent(lng);
                }
            }

            function formatNamaWilayah(data) {
                if (!data) return 'Kota Palembang, Sumatera Selatan';
                const addr = data.address || {};
                
                // Prioritas format: Kelurahan/Kecamatan, Kota/Kabupaten
                const district = addr.suburb || addr.village || addr.neighbourhood || addr.city_district || '';
                const city = addr.city || addr.town || addr.county || addr.municipality || 'Palembang';
                const province = addr.state || 'Sumatera Selatan';

                if (district && city) {
                    return district + ', ' + city;
                } else if (city && province) {
                    return city + ', ' + province;
                } else if (data.display_name) {
                    const parts = data.display_name.split(',').map(s => s.trim());
                    return parts.slice(0, 2).join(', ');
                }
                return 'Kota Palembang, Sumatera Selatan';
            }

            function deteksiLokasi() {
                if (!navigator.geolocation) {
                    if (!elLokasi.textContent || elLokasi.textContent.includes('Mencari')) {
                        elLokasi.textContent = 'Kota Palembang, Sumatera Selatan';
                    }
                    return;
                }

                if (!sessionStorage.getItem(STORAGE_KEY)) {
                    elLokasi.innerHTML = '<span class="inline-flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-[#c41520] animate-pulse"></span>Mendeteksi GPS...</span>';
                }

                navigator.geolocation.getCurrentPosition(
                    async function(pos) {
                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;
                        perbaruiLinkLapor(lat, lng);

                        try {
                            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&accept-language=id&zoom=14&lat=${lat}&lon=${lng}`);
                            if (!res.ok) throw new Error('Geocoding error');
                            const data = await res.json();
                            const namaWilayah = formatNamaWilayah(data);
                            elLokasi.textContent = namaWilayah;
                            sessionStorage.setItem(STORAGE_KEY, JSON.stringify({
                                lat: lat,
                                lng: lng,
                                label: namaWilayah
                            }));
                        } catch (err) {
                            const fallbackLabel = 'Koordinat: ' + lat.toFixed(3) + ', ' + lng.toFixed(3);
                            elLokasi.textContent = fallbackLabel;
                            sessionStorage.setItem(STORAGE_KEY, JSON.stringify({
                                lat: lat,
                                lng: lng,
                                label: fallbackLabel
                            }));
                        }
                    },
                    function(err) {
                        // Jika izin belum diberikan atau ditolak, tetap gunakan default aman
                        if (!sessionStorage.getItem(STORAGE_KEY)) {
                            elLokasi.textContent = 'Kota Palembang, Sumatera Selatan';
                        }
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 60000
                    }
                );
            }

            if (btnRefresh) {
                btnRefresh.addEventListener('click', function() {
                    sessionStorage.removeItem(STORAGE_KEY);
                    deteksiLokasi();
                });
            }

            if (btnRefreshHalaman) {
                const refreshIntervalSeconds = 20;
                let secondsUntilRefresh = refreshIntervalSeconds;

                function refreshHalaman() {
                    btnRefreshHalaman.disabled = true;
                    halamanRefreshIcon.classList.add('animate-spin');
                    halamanRefreshStatus.textContent = 'Memuat...';
                    window.location.reload();
                }

                btnRefreshHalaman.addEventListener('click', refreshHalaman);
                halamanRefreshStatus.classList.remove('hidden');

                window.setInterval(function() {
                    secondsUntilRefresh -= 1;
                    halamanRefreshStatus.textContent = secondsUntilRefresh + ' dtk';

                    if (secondsUntilRefresh <= 0) {
                        refreshHalaman();
                    }
                }, 1000);
            }

            deteksiLokasi();
        })();

        function toggleModalNotif(buka) {
            const modal = document.getElementById('modal-notif');
            if (modal) {
                modal.classList.toggle('hidden', !buka);
                document.body.classList.toggle('overflow-hidden', buka);
            }
        }
    </script>

    <!-- Modal Notifikasi Kebakaran Real-Time -->
    <div id="modal-notif" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-end sm:items-center justify-center p-0 sm:p-4">
        <div class="w-full max-w-lg bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden border border-slate-100 flex flex-col max-h-[85vh]">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between bg-[#fffaf8]">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-red-100 text-red-600 text-lg">
                        🔔
                    </span>
                    <div>
                        <h3 class="text-base font-black text-slate-900">Pusat Informasi &amp; Peringatan</h3>
                        <p class="text-xs text-slate-500">Notifikasi resmi bencana kebakaran Kota Palembang</p>
                    </div>
                </div>
                <button type="button" onclick="toggleModalNotif(false)" class="p-1.5 rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-4 sm:p-5 overflow-y-auto space-y-3.5 flex-1">
                @if(isset($kebakaranTerverifikasi) && $kebakaranTerverifikasi->isNotEmpty())
                    <div class="flex items-center justify-between text-xs font-bold text-red-700 bg-red-50 p-2.5 rounded-xl border border-red-200">
                        <span>🔥 {{ $kebakaranTerverifikasi->count() }} Kebakaran Sedang Ditangani</span>
                        <span class="text-[10px] text-red-500 uppercase">Siaga 24 Jam</span>
                    </div>

                    @foreach($kebakaranTerverifikasi as $k)
                        <div class="rounded-2xl border-2 border-red-200 bg-white p-4 shadow-sm hover:border-red-400 transition space-y-2">
                            <div class="flex items-center justify-between gap-2">
                                <span class="inline-flex items-center gap-1 rounded-full bg-red-600 px-2.5 py-0.5 text-[10px] font-black text-white uppercase tracking-wider">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white animate-pulse"></span>
                                    {{ $k->status === 'diproses' ? 'Terverifikasi & Ditangani' : 'Laporan Diterima' }}
                                </span>
                                <span class="text-[11px] font-semibold text-slate-400">{{ $k->created_at->diffForHumans() }}</span>
                            </div>

                            <div>
                                <h4 class="text-sm font-extrabold text-slate-900 leading-snug">{{ $k->alamat }}</h4>
                                @if($k->keterangan)
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $k->keterangan }}</p>
                                @endif
                            </div>

                            @if($k->kendaraan)
                                <div class="text-[11px] font-semibold text-slate-700 bg-slate-50 p-2 rounded-lg flex items-center gap-1.5">
                                    <span>🚒 Armada Ditugaskan:</span>
                                    <span class="text-[#bd101b] font-bold">{{ $k->kendaraan->kode }} ({{ $k->kendaraan->nama }})</span>
                                </div>
                            @endif

                            <div class="pt-1">
                                <a href="{{ route('peta', ['fokus' => $k->id]) }}" class="flex w-full items-center justify-center gap-1.5 rounded-xl bg-[#bd101b] py-2 px-3 text-xs font-bold text-white shadow hover:bg-[#a00e17] transition">
                                    <span>Buka Titik Api di Peta 🗺️</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 text-center space-y-2">
                        <span class="text-3xl">🛡️</span>
                        <h4 class="text-sm font-bold text-slate-800">Tidak Ada Kebakaran Aktif</h4>
                        <p class="text-xs text-slate-500">Seluruh wilayah Kota Palembang saat ini terpantau aman dan terkendali. Tetap utamakan keselamatan.</p>
                    </div>
                @endif

                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-500">Pernah mengirim laporan?</span>
                    <a href="{{ route('laporan.saya') }}" class="font-bold text-[#bd101b] hover:underline">
                        Buka Laporan Saya →
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
