<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP Damkar — Laporan Saya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans text-[#292626] antialiased bg-[#fffaf8]">
    <div class="min-h-screen w-full bg-[#fffaf8] flex flex-col justify-between">

        <!-- Top Header Bar (Masyarakat) -->
        <header class="sticky top-0 z-20 w-full border-b border-[#f2e9e6] bg-[#fffaf8]/95 backdrop-blur">
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8 py-3.5">
                <div class="flex items-center gap-3">
                    <button type="button" onclick="history.back()" aria-label="Kembali" class="rounded-full p-1 text-[#473a38] transition hover:bg-[#f2e9e6] md:hidden">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <a href="{{ route('beranda') }}" class="flex min-w-0 items-center gap-2.5 sm:gap-3" aria-label="SIGAP Damkar Beranda">
                        <span class="flex h-10 w-10 sm:h-11 sm:w-11 shrink-0 items-center justify-center rounded-xl border border-slate-100 bg-white p-1.5 shadow-sm">
                            <img src="{{ asset('images/sigap-logo.svg') }}" alt="SIGAP Logo" class="h-full w-full object-contain">
                        </span>
                        <span class="min-w-0 leading-tight">
                            <span class="block text-[10px] sm:text-xs font-extrabold tracking-[0.14em] text-[#bd101b]">SIGAP DAMKAR</span>
                            <span class="block text-xl sm:text-2xl font-bold tracking-tight text-[#292626]">Laporan Saya</span>
                        </span>
                    </a>
                </div>

                <!-- Desktop Navigation Menu (md: & lg:) -->
                <nav class="hidden md:flex items-center gap-1.5 lg:gap-3 text-sm font-semibold text-[#665a57]">
                    <a href="{{ route('beranda') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:text-[#bd101b] hover:bg-[#fff0ed] transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V10Z"/></svg>
                        <span>Beranda</span>
                    </a>
                    <a href="{{ route('peta') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:text-[#bd101b] hover:bg-[#fff0ed] transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Zm6-3v15m6-12v15"/></svg>
                        <span>Peta Pos Damkar</span>
                    </a>
                    <a href="{{ route('laporan.saya') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[#bd101b] bg-red-50 font-bold transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6l1 2h4v15H4V6h4l1-2Zm1 6h4m-4 4h6m-6 4h6"/></svg>
                        <span>Laporan Saya</span>
                    </a>
                    <a href="{{ route('edukasi.index') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:text-[#bd101b] hover:bg-[#fff0ed] transition">
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

        @php
            $ditolak = $laporanTerbaru?->status === 'ditolak';
            $selesai = $laporanTerbaru && ! $ditolak && $laporanTerbaru->tahapMasyarakat() >= 4;
            $berjalan = $laporanTerbaru && ! $ditolak && ! $selesai;
        @endphp
        <main class="flex-1 w-full">
            <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-5 sm:py-7 space-y-6">

            @if (session('info'))
                <div role="alert" class="rounded-xl border border-[#f3d9a4] bg-[#fff7e6] px-4 py-3 text-[12px] font-semibold text-[#8a5a00]">{{ session('info') }}</div>
            @endif

            <!-- Judul Halaman -->
            <section aria-labelledby="aktivitas-title" class="space-y-1">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <h1 id="aktivitas-title" class="text-xl sm:text-2xl font-bold tracking-tight text-[#292626]">Aktivitas Laporan</h1>
                    @if (! $laporanTerbaru)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#f2e9e6] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-[#766965]">Belum Ada Laporan</span>
                    @elseif ($ditolak)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#a20c15] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white"><span class="h-1.5 w-1.5 rounded-full bg-white"></span>Ditolak</span>
                    @elseif ($selesai)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#1c7a3a] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white"><span class="h-1.5 w-1.5 rounded-full bg-white"></span>Selesai</span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#c41621] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white"><span class="h-1.5 w-1.5 rounded-full bg-white"></span>Sedang Diproses</span>
                    @endif
                </div>
                <p class="text-sm text-[#766965]">Pantau penanganan armada &amp; rekam jejak darurat</p>
            </section>

            <!-- Responsive Grid Layout: 2 Kolom di Desktop (lg:) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                <!-- Kolom Kiri: Laporan Terkini & Aksi Utama (8 cols on lg) -->
                <div class="lg:col-span-7 xl:col-span-8 space-y-6">

                    <!-- Laporan Terbaru (satu laporan per pengunjung) -->
                    <section aria-labelledby="aktif-title">
                        @if ($laporanTerbaru)
                            @php
                                $currentStep = $laporanTerbaru->tahapMasyarakat();
                                $statusLabel = $ditolak ? 'Laporan Anda ditolak' : match (true) {
                                    $selesai => 'Laporan Anda telah selesai ditangani',
                                    $currentStep >= 3 => 'Petugas Sedang Menangani Kebakaran',
                                    $currentStep === 2 => 'Petugas Sedang Menuju Lokasi',
                                    default => 'Menunggu Verifikasi Petugas',
                                };
                                $subLabel = $ditolak
                                    ? ($laporanTerbaru->alasan_penolakan ?: 'Laporan tidak dapat diproses.')
                                    : ($selesai
                                        ? 'Terima kasih sudah melapor. Petugas telah menyelesaikan penanganan.'
                                        : \Illuminate\Support\Str::limit($laporanTerbaru->keterangan ?? 'Laporan sedang ditangani Command Center.', 64));
                                $kotak = $ditolak ? 'bg-[#ffe0dc]/60' : ($selesai ? 'bg-[#e3f5e8]' : 'bg-[#ffe0dc]/50');
                                $titik = $ditolak ? 'bg-[#a20c15]' : ($selesai ? 'bg-[#1c7a3a]' : 'bg-[#c41621]');
                                $warnaTeks = $ditolak ? 'text-[#a20c15]' : ($selesai ? 'text-[#1c7a3a]' : 'text-[#c41621]');
                                $steps = \App\Models\Laporan::TAHAP_MASYARAKAT;
                                $waktuStep = [
                                    0 => $laporanTerbaru->created_at->translatedFormat('H:i'),
                                    3 => $laporanTerbaru->mulai_penanganan_at?->translatedFormat('H:i'),
                                    4 => $laporanTerbaru->hasil_dibuat_pada?->translatedFormat('H:i'),
                                ];
                            @endphp
                            <article class="rounded-2xl border-l-4 {{ $ditolak ? 'border-l-[#a20c15]' : ($selesai ? 'border-l-[#1c7a3a]' : 'border-l-[#c41621]') }} bg-white p-5 sm:p-6 shadow-sm border border-[#f0e8e5]">
                                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-3">
                                    <p class="text-xs font-semibold text-[#766965] flex items-center gap-1.5">
                                        <span>{{ $ditolak ? '🚫' : ($selesai ? '✅' : '🚨') }}</span>
                                        <span>{{ $laporanTerbaru->created_at->translatedFormat('H.i') }} WIB</span>
                                        <span>•</span>
                                        <span>{{ $laporanTerbaru->created_at->isToday() ? 'Hari ini' : $laporanTerbaru->created_at->translatedFormat('d M Y') }}</span>
                                    </p>
                                    @if ($berjalan)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-[11px] font-bold text-[#c41621] animate-pulse">● Respon Aktif</span>
                                    @endif
                                </div>

                                <h2 id="aktif-title" class="mt-3 text-lg sm:text-xl font-bold leading-snug text-slate-900">{{ $laporanTerbaru->alamat }}</h2>
                                @if ($laporanTerbaru->latitude && $laporanTerbaru->longitude)
                                    <p class="mt-1.5 flex items-center gap-1.5 text-xs text-[#766965]">
                                        <svg class="h-4 w-4 shrink-0 text-[#c41621]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.5a7.5 7.5 0 0 0-7.5 7.5c0 5.6 7.5 11.5 7.5 11.5S19.5 15.6 19.5 10A7.5 7.5 0 0 0 12 2.5Zm0 10.2a2.7 2.7 0 1 1 0-5.4 2.7 2.7 0 0 1 0 5.4Z"/></svg>
                                        <span>Titik Koordinat: <span class="font-mono">{{ $laporanTerbaru->latitude }}, {{ $laporanTerbaru->longitude }}</span></span>
                                    </p>
                                @endif

                                <div class="mt-4 flex items-start gap-2.5 rounded-xl px-4 py-3 {{ $kotak }}">
                                    <span class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full {{ $titik }}"></span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold leading-tight {{ $warnaTeks }}">{{ $statusLabel }}</p>
                                        <p class="mt-1 text-xs font-medium text-[#5c4f4c]">{{ $subLabel }}</p>
                                    </div>
                                </div>

                                @if ($ditolak)
                                    <div class="mt-4 rounded-xl bg-[#f8f5f4] p-4 text-xs text-[#5c4f4c] border border-[#f0e8e5]">
                                        <p class="font-bold text-[#a20c15]">Laporan Anda ditolak oleh petugas</p>
                                        @if ($laporanTerbaru->alasan_penolakan)
                                            <p class="mt-1"><span class="font-bold">Alasan:</span> {{ $laporanTerbaru->alasan_penolakan }}</p>
                                        @endif
                                        @if ($laporanTerbaru->ditolak_pada)
                                            <p class="mt-1 text-[11px] text-[#8a7f7b]">Ditolak pukul {{ $laporanTerbaru->ditolak_pada->translatedFormat('H.i') }} WIB. Jika terjadi keadaan darurat nyata lainnya, silakan buat laporan baru atau hubungi 112.</p>
                                        @endif
                                    </div>
                                @else
                                <div class="mt-4 rounded-xl bg-[#f8f5f4] p-4 border border-[#f0e8e5]">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#494442]">Status Alur Respon Cepat Damkar</p>
                                    <ol class="mt-3 grid grid-cols-5 gap-1.5 sm:gap-2 text-center" aria-label="Tahapan penanganan laporan">
                                        @foreach ($steps as $i => $label)
                                            @php $done = $i < $currentStep || $currentStep >= 4; $current = $i === $currentStep && $currentStep < 4; @endphp
                                        <li class="flex flex-col items-center gap-1 {{ $current ? 'text-[#c41621]' : ($done ? 'text-[#292626]' : 'text-[#a39a95]') }}">
                                            @if ($done)
                                                <span class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-full bg-[#c41621] text-white shadow-sm"><svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4 10-10"/></svg></span>
                                            @elseif ($current)
                                                <span class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-full bg-[#c41621] font-bold text-white ring-4 ring-[#c41621]/20 shadow-sm">{{ strtolower($label[0]) === 'a' ? 'A' : ($i + 1) }}</span>
                                            @else
                                                <span class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-full bg-[#e4e0dd] text-xs font-semibold">{{ $i + 1 }}</span>
                                            @endif
                                            <span class="text-[10px] sm:text-[11px] {{ $current ? 'font-bold' : 'font-semibold' }} leading-tight mt-0.5">{{ $label }}</span>
                                            <span class="text-[9px] text-[#8a7f7b]">{{ $waktuStep[$i] ?? '-:-' }}</span>
                                        </li>
                                        @endforeach
                                    </ol>
                                </div>
                                @endif

                                @if ($berjalan)
                                <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                                    <a href="{{ route('laporan.lacak', $laporanTerbaru) }}" class="inline-flex items-center gap-2 rounded-full bg-[#c41621] px-5 py-2.5 text-xs font-bold text-white shadow-md shadow-red-900/15 transition hover:bg-[#a90d25]">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 2 11 13M22 2l-7 20-4-9-9-4 20-7Z"/></svg>
                                        <span>Lacak Posisi Armada</span>
                                    </a>
                                    <span class="text-[11px] text-[#766965] hidden sm:inline">Peta pergerakan unit damkar menuju lokasi Anda</span>
                                </div>
                                @endif
                            </article>
                        @else
                            <div class="rounded-2xl border border-dashed border-[#e0d5d1] bg-white p-8 text-center shadow-sm">
                                <p class="text-3xl" aria-hidden="true">🏠</p>
                                <p class="mt-2 text-base font-bold text-[#292626]">Belum ada laporan aktif</p>
                                <p class="mt-1 text-xs text-[#766965]">Laporkan segera bila terjadi kebakaran atau keadaan darurat di sekitarmu.</p>
                                <a href="{{ route('lapor.create') }}" class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-[#c41621] px-5 py-2.5 text-xs font-bold text-white shadow transition hover:bg-[#a90d25]">🚨 Buat Laporan Kebakaran</a>
                            </div>
                        @endif
                    </section>

                    <!-- Tindakan Cepat Buat Laporan Baru -->
                    @if ($bisaLapor)
                    <div class="rounded-2xl border border-[#f0e8e5] bg-white p-5 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Perlu melaporkan kejadian darurat lain?</h3>
                            <p class="text-xs text-[#766965] mt-0.5">Sinyal GPS &amp; data kebakaran akan segera diteruskan ke Pos Damkar terdekat.</p>
                        </div>
                        <a href="{{ route('lapor.create') }}" class="inline-flex shrink-0 items-center gap-2 rounded-full bg-[#c41621] px-5 py-2.5 text-xs sm:text-sm font-bold text-white shadow-md shadow-red-900/15 transition hover:bg-[#a90d25]">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c1 3-1 4.5.5 6 1.7-1.2 2.1-2.7 2.2-3.5C18 9 19 11 19 14a7 7 0 1 1-14 0c0-2.5 1-4.2 3.2-6.5-.1 2.2.7 3.3 1.8 4C11 9 10 6 12 3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 13c1 1.1 2 2.1 2 3.5a2 2 0 1 1-4 0c0-1.4.9-2.4 2-3.5Z"/></svg>
                            <span>Buat Laporan Baru</span>
                        </a>
                    </div>
                    @else
                    <div class="rounded-xl bg-[#f8f5f4] p-3.5 text-center text-xs font-semibold text-[#766965] border border-[#f0e8e5]">
                        Laporan baru dapat dibuat setelah penanganan laporan Anda saat ini selesai atau ditolak oleh petugas.
                    </div>
                    @endif

                </div>

                <!-- Kolom Kanan: Riwayat Laporan & Bantuan Darurat (4 cols on lg) -->
                <div class="lg:col-span-5 xl:col-span-4 space-y-5">

                    <!-- Kartu Riwayat Laporan Sebelumnya -->
                    <div class="rounded-2xl border border-[#f0e8e5] bg-white p-5 shadow-sm space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                            <h3 class="text-sm font-bold text-slate-900">Riwayat Laporan</h3>
                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-600">{{ $riwayatLaporan->count() }} Laporan</span>
                        </div>

                        @if ($riwayatLaporan->isNotEmpty())
                            <div class="space-y-2.5 max-h-[380px] overflow-y-auto pr-1">
                                @foreach ($riwayatLaporan as $riwayat)
                                    <div class="rounded-xl border border-[#f3eeeb] bg-[#fffaf8] p-3 text-xs space-y-1.5 transition hover:border-slate-300">
                                        <div class="flex items-center justify-between gap-1">
                                            <span class="text-[10px] font-bold text-slate-500">{{ $riwayat->created_at->translatedFormat('d M Y') }} • {{ $riwayat->created_at->translatedFormat('H.i') }} WIB</span>
                                            @if ($riwayat->status === 'selesai')
                                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-bold text-emerald-700">Selesai</span>
                                            @elseif ($riwayat->status === 'ditolak')
                                                <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-0.5 text-[10px] font-bold text-[#c41621]">Ditolak</span>
                                            @else
                                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-600">{{ ucfirst($riwayat->status) }}</span>
                                            @endif
                                        </div>
                                        <p class="font-bold text-slate-800 line-clamp-1">{{ $riwayat->alamat }}</p>
                                        @if ($riwayat->status === 'ditolak' && $riwayat->alasan_penolakan)
                                            <p class="text-[10px] text-[#a20c15] line-clamp-1"><span class="font-semibold">Alasan:</span> {{ $riwayat->alasan_penolakan }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-[#766965] py-2 text-center">Belum ada rekam jejak laporan sebelumnya.</p>
                        @endif
                    </div>

                    <!-- Kartu Bantuan Darurat Hotline 112 -->
                    <div class="rounded-2xl border border-[#cfe1f5] bg-[#edf5fc] p-5 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#0064ad] text-white shadow-sm">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-[10px] font-extrabold uppercase tracking-wider text-[#0064ad]">Panggilan Siaga 24 Jam</p>
                                <h3 class="text-base font-bold text-slate-900 leading-tight">Hotline 112 Damkar</h3>
                                <p class="text-[11px] text-slate-500">Bebas Pulsa &amp; Tanggap Kebakaran</p>
                            </div>
                            <a href="tel:112" class="shrink-0 rounded-full bg-[#0064ad] hover:bg-[#00518c] px-4 py-2 text-xs font-bold text-white shadow transition">
                                Panggil
                            </a>
                        </div>
                    </div>

                    <!-- Tautan Cepat Peta Pos Damkar -->
                    <div class="rounded-2xl border border-[#f0e8e5] bg-white p-4 shadow-sm flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <h4 class="text-xs font-bold text-[#292626]">Peta Pos Damkar Terdekat</h4>
                            <p class="text-[11px] text-[#766965] truncate">Pantau 8 Pos Damkar Kota Palembang</p>
                        </div>
                        <a href="{{ route('peta') }}" class="inline-flex shrink-0 items-center gap-1 text-xs font-bold text-[#bd101b] hover:underline">
                            <span>Buka Peta</span>
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7"/></svg>
                        </a>
                    </div>

                </div>

            </div>

            </div>
        </main>

        <!-- Desktop Footer (Hanya muncul di md: ke atas) -->
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
                        <a href="{{ route('laporan.saya') }}" class="hover:text-[#bd101b] transition font-bold text-[#bd101b]">Laporan Saya</a>
                        <a href="{{ route('edukasi.index') }}" class="hover:text-[#bd101b] transition">Edukasi</a>
                        <a href="tel:112" class="font-bold text-[#0064ad] hover:underline">Hotline 112</a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bottom Navigation Bar (Masyarakat, md:hidden) -->
        <nav aria-label="Navigasi utama" class="sticky bottom-0 z-30 w-full border-t border-[#f0e8e5] bg-[#fffaf8]/95 shadow-[0_-4px_18px_rgba(60,35,30,0.05)] backdrop-blur md:hidden">
            <div class="mx-auto grid max-w-md grid-cols-4 px-2 pb-[max(0.55rem,env(safe-area-inset-bottom))] pt-2">
                <a href="{{ route('beranda') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V10Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6c.8 1.5-.7 2.2.4 3 1-.5 1.3-1.4 1.3-1.4 1.2 1.7 1.3 2.6.3 3.7"/></svg>
                    <span class="text-[10px] font-bold">Beranda</span>
                </a>
                <a href="{{ route('peta') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Zm6-3v15m6-12v15"/></svg>
                    <span class="text-[10px] font-bold">Peta</span>
                </a>
                <a href="{{ route('laporan.saya') }}" aria-current="page" class="flex flex-col items-center gap-0.5 text-[#bd101b]">
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

    <script>
        (function() {
            const KEY = 'sigap_device_id';
            let devId = localStorage.getItem(KEY);
            if (!devId) {
                devId = 'dev_' + Date.now().toString(36) + '_' + Math.random().toString(36).substring(2, 10);
                localStorage.setItem(KEY, devId);
            }
            if (!document.cookie.includes(KEY + '=')) {
                document.cookie = KEY + '=' + encodeURIComponent(devId) + '; path=/; max-age=31536000; SameSite=Lax';
            }
        })();
    </script>
</body>
</html>
