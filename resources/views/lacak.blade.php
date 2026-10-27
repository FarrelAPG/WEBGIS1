<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP Damkar — Lacak Armada</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
</head>
<body class="min-h-screen bg-[#eef1f6] font-sans text-[#292626] antialiased">
    <div class="min-h-screen w-full bg-[#eef1f6] flex flex-col justify-between">

        <!-- Top Header Bar (Masyarakat) -->
        <header class="sticky top-0 z-20 w-full border-b border-[#e2e6ee] bg-[#eef1f6]/95 backdrop-blur">
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8 py-3.5">
                <div class="flex items-center gap-3">
                    <button type="button" onclick="history.back()" aria-label="Kembali" class="rounded-full p-1 text-[#473a38] transition hover:bg-white/60 md:hidden">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <a href="{{ route('beranda') }}" class="flex min-w-0 items-center gap-2.5 sm:gap-3" aria-label="SIGAP Damkar Beranda">
                        <img src="{{ asset('images/logo-sigap-red.png') }}" alt="SIGAP DAMKAR" class="h-10 w-10 sm:h-11 sm:w-11 shrink-0 rounded-xl object-contain shadow-sm">
                        <span class="min-w-0 leading-tight">
                            <span class="block text-[10px] sm:text-xs font-extrabold tracking-[0.14em] text-[#bd101b]">SIGAP DAMKAR</span>
                            <span class="block text-xl sm:text-2xl font-bold tracking-tight text-[#1d2b46]">Lacak Armada</span>
                        </span>
                    </a>
                </div>

                <!-- Desktop Navigation Menu (md: & lg:) -->
                <nav class="hidden md:flex items-center gap-1.5 lg:gap-3 text-sm font-semibold text-[#665a57]">
                    <a href="{{ route('beranda') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:text-[#bd101b] hover:bg-white transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V10Z"/></svg>
                        <span>Beranda</span>
                    </a>
                    <a href="{{ route('peta') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:text-[#bd101b] hover:bg-white transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Zm6-3v15m6-12v15"/></svg>
                        <span>Peta Pos Damkar</span>
                    </a>
                    <a href="{{ route('laporan.saya') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[#bd101b] bg-white font-bold shadow-sm transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6l1 2h4v15H4V6h4l1-2Zm1 6h4m-4 4h6m-6 4h6"/></svg>
                        <span>Laporan Saya</span>
                    </a>
                    <a href="{{ route('edukasi.index') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:text-[#bd101b] hover:bg-white transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Edukasi</span>
                    </a>
                </nav>

                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="tel:112" class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-[#bd101b] hover:bg-[#a00e17] px-3 py-1.5 text-[11px] sm:text-xs font-bold text-white shadow-sm transition">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>112 Darurat</span>
                    </a>
                    <a href="{{ route('masyarakat.profile') }}" class="h-9 w-9 sm:h-10 sm:w-10 overflow-hidden rounded-full border-2 border-[#e7b5ae] bg-white p-0.5 transition hover:ring-2 hover:ring-[#c41621]/30" aria-label="Profil">
                        <img src="{{ asset('images/avatar.svg') }}" alt="Foto profil" class="h-full w-full rounded-full object-cover">
                    </a>
                </div>
            </div>
        </header>

        <main class="flex-1 w-full">
            <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-5 sm:py-7">

                <!-- 2 Kolom di Layar Desktop (lg:) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                    <!-- Kolom Kiri: Peta Lacak & Ringkasan Kejadian (7 cols on lg) -->
                    <div class="lg:col-span-7 xl:col-span-8 space-y-4">

                        <!-- Kartu Ringkasan Laporan -->
                        <section aria-labelledby="ringkasan-title" class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200">
                            <div class="flex items-center justify-between gap-2 border-b border-slate-100 pb-2.5 mb-2">
                                <h1 id="ringkasan-title" class="text-base sm:text-lg font-bold text-[#1d2b46]">
                                    Kebakaran: {{ \Illuminate\Support\Str::limit($laporan->alamat, 60) }}
                                </h1>
                                <span class="rounded-full bg-red-50 px-2.5 py-0.5 text-[11px] font-bold text-[#c41621] shrink-0 animate-pulse">● Penanganan Aktif</span>
                            </div>
                            <p class="flex items-start gap-1.5 text-xs text-[#5c6a84]">
                                <svg class="mt-0.5 h-4 w-4 shrink-0 text-[#c41621]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.5a7.5 7.5 0 0 0-7.5 7.5c0 5.6 7.5 11.5 7.5 11.5S19.5 15.6 19.5 10A7.5 7.5 0 0 0 12 2.5Zm0 10.2a2.7 2.7 0 1 1 0-5.4 2.7 2.7 0 0 1 0 5.4Z"/></svg>
                                <span>{{ $laporan->alamat }}</span>
                            </p>
                            <p class="mt-3 inline-block rounded-lg bg-[#eef1f6] px-3 py-1 text-xs font-semibold text-[#3a465f]">Dilaporkan: {{ $laporan->created_at->translatedFormat('H:i') }} WIB</p>
                        </section>

                        <!-- Peta Lacak Armada -->
                        <section aria-label="Peta pelacakan armada" class="overflow-hidden rounded-2xl bg-white shadow-sm border border-slate-200">
                            <div id="map" class="h-80 sm:h-96 lg:h-[460px] w-full"></div>
                        </section>

                    </div>

                    <!-- Kolom Kanan: Info Unit, ETA, Stepper & Aksi (5 cols on lg) -->
                    <div class="lg:col-span-5 xl:col-span-4 space-y-4">

                        <!-- Kartu Unit & ETA -->
                        <section aria-labelledby="unit-title" class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200">
                            <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-2xl border border-red-100" aria-hidden="true">🚒</span>
                                <div class="min-w-0">
                                    <h2 id="unit-title" class="text-base font-extrabold text-[#1d2b46]">Unit Damkar 03</h2>
                                    <p class="text-xs font-medium text-[#5c6a84]">Armada Tanggap Kebakaran</p>
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-3">
                                <div class="rounded-xl bg-[#eef1f6] p-3.5">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#5c6a84]">Estimasi Tiba (ETA)</p>
                                    <p class="mt-1 leading-none"><span class="text-2xl font-black text-[#c41621]">4</span> <span class="text-xs font-bold text-[#c41621]">Menit</span></p>
                                    <p class="mt-2 flex items-center gap-1 text-[10px] text-[#5c6a84]">
                                        <svg class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 2"/></svg>
                                        <span>Perkiraan: {{ $laporan->created_at->copy()->addMinutes(8)->translatedFormat('H:i') }} WIB</span>
                                    </p>
                                </div>
                                <div class="rounded-xl bg-[#eef1f6] p-3.5">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#5c6a84]">Jarak Tempuh</p>
                                    <p class="mt-1 leading-none"><span class="text-2xl font-black text-[#1d2b46]">1,2</span> <span class="text-xs font-bold text-[#1d2b46]">KM</span></p>
                                    <p class="mt-2 flex items-center gap-1 text-[10px] text-[#5c6a84]">
                                        <svg class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m12 3 9 5-9 5-9-5 9-5Zm9 10-9 5-9-5m18 5-4.5 2.5"/></svg>
                                        <span>Menuju TKP</span>
                                    </p>
                                </div>
                            </div>
                        </section>

                        <!-- Progres Penanganan -->
                        <section aria-labelledby="progres-title" class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200">
                            <h2 id="progres-title" class="text-sm font-bold text-[#1d2b46] border-b border-slate-100 pb-2.5">Progres Alur Penanganan</h2>

                            @php
                                $tahap = $laporan->tahapMasyarakat();
                                $langkah = [
                                    ['judul' => 'Laporan Diterima', 'ket' => 'Dispatcher Posko Komando', 'waktu' => $laporan->created_at->translatedFormat('H.i').' WIB', 'state' => 'selesai'],
                                    ['judul' => 'Menuju Lokasi Kebakaran', 'ket' => 'Menempuh arah ke lokasi laporan', 'waktu' => null, 'state' => $tahap >= 3 ? 'selesai' : 'berjalan'],
                                    ['judul' => 'Sedang Ditangani', 'ket' => 'Petugas tiba di lokasi, gelar selang & hidran', 'waktu' => $laporan->mulai_penanganan_at ? $laporan->mulai_penanganan_at->translatedFormat('H.i').' WIB' : null, 'state' => $tahap >= 4 ? 'selesai' : ($tahap === 3 ? 'berjalan' : 'menunggu')],
                                    ['judul' => 'Penanganan Selesai', 'ket' => 'Laporan akhir telah dibuat petugas', 'waktu' => $laporan->hasil_dibuat_pada ? $laporan->hasil_dibuat_pada->translatedFormat('H.i').' WIB' : null, 'state' => $tahap >= 4 ? 'selesai' : 'menunggu'],
                                ];
                            @endphp

                            <ol class="mt-4 space-y-0" aria-label="Tahapan penanganan laporan">
                                @foreach ($langkah as $l)
                                    @php $akhir = $loop->last; @endphp
                                    @if ($l['state'] === 'selesai')
                                        <li class="relative flex gap-3 {{ $akhir ? '' : 'pb-5' }}">
                                            <span class="relative z-10 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#c41621] text-white">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4 10-10"/></svg>
                                                @unless ($akhir)<span class="absolute -bottom-5 h-5 w-0.5 bg-[#c41621]"></span>@endunless
                                            </span>
                                            <div class="flex min-w-0 flex-1 items-start justify-between gap-2">
                                                <div class="min-w-0">
                                                    <p class="text-xs font-bold text-[#1d2b46]">{{ $l['judul'] }}</p>
                                                    <p class="mt-0.5 text-[11px] text-[#5c6a84]">{{ $l['ket'] }}</p>
                                                    <div class="mt-1 h-1 w-8 rounded-full bg-[#c41621]/30" aria-hidden="true"></div>
                                                </div>
                                                <span class="shrink-0 text-[11px] font-bold text-[#1d2b46]">{{ $l['waktu'] ?? '' }}</span>
                                            </div>
                                        </li>
                                    @elseif ($l['state'] === 'berjalan')
                                        <li class="relative flex gap-3 {{ $akhir ? '' : 'pb-5' }}">
                                            <span class="relative z-10 flex h-7 w-7 shrink-0 items-center justify-center">
                                                <span class="h-4 w-4 rounded-full bg-[#c41621] ring-4 ring-[#c41621]/25"></span>
                                                @unless ($akhir)<span class="absolute -bottom-4 h-4 w-0.5 bg-[#e8d5d3]"></span>@endunless
                                            </span>
                                            <div class="min-w-0 flex-1 rounded-xl bg-[#fdecec] p-3">
                                                <div class="flex items-start justify-between gap-2">
                                                    <p class="text-xs font-extrabold leading-snug text-[#c41621]">{{ $l['judul'] }}</p>
                                                    @if ($l['waktu'])<span class="shrink-0 text-[11px] font-bold text-[#c41621]">{{ $l['waktu'] }}</span>@endif
                                                </div>
                                                <p class="mt-0.5 text-[11px] text-[#8a4a48]">{{ $l['ket'] }}</p>
                                            </div>
                                        </li>
                                    @else
                                        <li class="relative flex gap-3 {{ $akhir ? '' : 'pb-5' }}">
                                            <span class="relative z-10 flex h-7 w-7 shrink-0 items-center justify-center">
                                                <span class="h-3 w-3 rounded-full bg-[#c3cbd9] ring-4 ring-[#c3cbd9]/30"></span>
                                                @unless ($akhir)<span class="absolute -bottom-5 h-5 w-0.5 bg-[#e8d5d3]"></span>@endunless
                                            </span>
                                            <div class="min-w-0 flex-1 items-start justify-between gap-2">
                                                <div class="min-w-0">
                                                    <p class="text-xs font-bold text-[#9aa5b8]">{{ $l['judul'] }}</p>
                                                    <p class="mt-0.5 text-[11px] text-[#9aa5b8]">{{ $l['ket'] }}</p>
                                                </div>
                                                <span class="shrink-0 text-[11px] font-bold text-[#9aa5b8]">--.--</span>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </section>

                        <!-- Aksi Cepat -->
                        <section class="space-y-3 pt-1">
                            <a href="tel:112" class="flex min-h-12 w-full items-center justify-center gap-2 rounded-full bg-[#bd101b] hover:bg-[#a00e17] text-xs sm:text-sm font-bold text-white shadow-md shadow-red-900/20 transition">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.5 19.5 0 0 1-3-8.7A2 2 0 0 1 4.1 4h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 2.8a2 2 0 0 1-.4 2.1L8.1 12a16 16 0 0 0 6 6l1.4-1.3a2 2 0 0 1 2.1-.4c.9.3 1.9.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg>
                                <span>Hubungi Petugas Damkar 112</span>
                            </a>
                            <p class="text-center">
                                <a href="{{ route('laporan.saya') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#5c6a84] transition hover:text-[#292626]">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m6-6-6 6 6 6"/></svg>
                                    <span>Kembali ke Laporan Saya</span>
                                </a>
                            </p>
                        </section>

                    </div>

                </div>

            </div>
        </main>

        <!-- Desktop Footer (Hanya muncul di md: ke atas) -->
        <footer class="hidden md:block w-full border-t border-[#e2e6ee] bg-[#eef1f6]">
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

        <!-- Bottom Navigation Bar (Masyarakat, md:hidden) -->
        <nav aria-label="Navigasi utama" class="sticky bottom-0 z-30 w-full border-t border-[#e2e6ee] bg-[#eef1f6]/95 shadow-[0_-4px_18px_rgba(60,35,30,0.05)] backdrop-blur md:hidden">
            <div class="mx-auto grid max-w-md grid-cols-4 px-2 pb-[max(0.55rem,env(safe-area-inset-bottom))] pt-2">
                <a href="{{ route('beranda') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V10Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6c.8 1.5-.7 2.2.4 3 1-.5 1.3-1.4 1.3-1.4 1.2 1.7 1.3 2.6.3 3.7"/></svg><span class="text-[10px] font-bold">Beranda</span></a>
                <a href="{{ route('peta') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Zm6-3v15m6-12v15"/></svg><span class="text-[10px] font-bold">Peta</span></a>
                <a href="{{ route('laporan.saya') }}" aria-current="page" class="flex flex-col items-center gap-0.5 text-[#bd101b]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6l1 2h4v15H4V6h4l1-2Zm1 6h4m-4 4h6m-6 4h6"/></svg><span class="text-[10px] font-bold">Laporan</span></a>
                <a href="{{ route('masyarakat.profile') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2H4Z"/></svg><span class="text-[10px] font-bold">Profil</span></a>
            </div>
        </nav>
    </div>

    <script>
        // Titik TKP dari data laporan
        const tkp = [{{ (float) $laporan->latitude }}, {{ (float) $laporan->longitude }}];

        const map = L.map('map', { zoomControl: false }).setView(tkp, 15);
        L.control.zoom({ position: 'topright' }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Marker TKP (titik kebakaran)
        const ikonTkp = L.divIcon({
            className: '',
            html: '<div style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:9999px;background:#c41621;box-shadow:0 4px 10px rgba(120,10,20,.35);border:3px solid #fff;">🔥</div>',
            iconSize: [40, 40],
            iconAnchor: [20, 20],
        });
        L.marker(tkp, { icon: ikonTkp }).addTo(map).bindPopup('Titik Kebakaran (TKP)').openPopup();

        // Marker armada sedikit bergeser dari TKP (simulasi posisi unit saat ini)
        const armada = [tkp[0] + 0.003, tkp[1] - 0.002];
        const ikonArmada = L.divIcon({
            className: '',
            html: '<div style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:9999px;background:#1d2b46;box-shadow:0 4px 10px rgba(20,30,60,.35);border:3px solid #fff;font-size:1.1rem;">🚒</div>',
            iconSize: [40, 40],
            iconAnchor: [20, 20],
        });
        L.marker(armada, { icon: ikonArmada }).addTo(map).bindPopup('Armada 03');

        // Garis rute armada ke TKP
        const gayaRute = { color: '#c41621', weight: 4, dashArray: '8 6', opacity: 0.9 };
        fetch(`https://router.project-osrm.org/route/v1/driving/${armada[1]},${armada[0]};${tkp[1]},${tkp[0]}?overview=full&geometries=geojson`)
            .then(res => { if (!res.ok) throw new Error('HTTP ' + res.status); return res.json(); })
            .then(data => {
                if (data.code !== 'Ok' || !data.routes.length) throw new Error('Rute tidak ditemukan');
                const garis = L.geoJSON(data.routes[0].geometry, { style: gayaRute }).addTo(map);
                map.fitBounds(garis.getBounds().pad(0.2));
            })
            .catch(err => {
                console.warn('Routing gagal, memakai garis lurus:', err);
                L.polyline([armada, tkp], gayaRute).addTo(map);
            });

        map.fitBounds(L.latLngBounds([tkp, armada]).pad(0.6));
    </script>
</body>
</html>
