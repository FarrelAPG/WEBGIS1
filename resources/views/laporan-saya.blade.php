<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP Damkar — Laporan Saya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans text-[#292626] antialiased sm:flex sm:justify-center sm:bg-gray-100">
    <div class="min-h-screen w-full max-w-2xl bg-[#fffaf8] shadow-[0_0_32px_rgba(75,35,35,0.06)] sm:shadow-xl flex flex-col justify-between">

        <header class="sticky top-0 z-20 border-b border-[#f2e9e6] bg-[#fffaf8]/95 px-5 py-3 backdrop-blur">
            <div class="flex items-center gap-3">
                <button type="button" onclick="history.back()" aria-label="Kembali" class="rounded-full p-1 text-[#473a38] transition hover:bg-[#f2e9e6]">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <a href="{{ route('laporan.saya') }}" aria-current="page" class="flex min-w-0 items-center gap-2.5">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-slate-100 bg-white p-2 shadow-sm">
                        <img src="{{ asset('images/sigap-logo.svg') }}" alt="" class="h-full w-full object-contain">
                    </span>
                    <span class="min-w-0 leading-tight">
                        <span class="block text-sm font-extrabold tracking-[0.08em] text-[#bd101b]">SIGAP</span>
                        <span class="block text-[11px] font-bold uppercase tracking-wide text-[#292626]">Laporan Saya</span>
                    </span>
                </a>
            </div>
        </header>

        @php
            $ditolak = $laporanTerbaru?->status === 'ditolak';
            $selesai = $laporanTerbaru && ! $ditolak && $laporanTerbaru->tahapMasyarakat() >= 4;
            $berjalan = $laporanTerbaru && ! $ditolak && ! $selesai;
        @endphp
        <main class="flex-1 space-y-5 px-5 pb-6 pt-4 sm:px-7">

            @if (session('info'))
                <div role="alert" class="rounded-xl border border-[#f3d9a4] bg-[#fff7e6] px-4 py-3 text-[12px] font-semibold text-[#8a5a00]">{{ session('info') }}</div>
            @endif

            <!-- Judul Halaman -->
            <section aria-labelledby="aktivitas-title" class="space-y-1">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <h1 id="aktivitas-title" class="text-xl font-bold tracking-tight">Aktivitas Laporan</h1>
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
                    <article class="rounded-xl border-l-4 {{ $ditolak ? 'border-l-[#a20c15]' : ($selesai ? 'border-l-[#1c7a3a]' : 'border-l-[#c41621]') }} bg-white p-4 shadow-[0_3px_12px_rgba(65,45,40,0.04)]">
                        <p class="text-[11px] font-semibold text-[#766965]">{{ $ditolak ? '🚫' : ($selesai ? '✅' : '🎉') }} {{ $laporanTerbaru->created_at->translatedFormat('H.i') }} WIB ({{ $laporanTerbaru->created_at->isToday() ? 'Hari ini' : $laporanTerbaru->created_at->translatedFormat('d M Y') }})</p>
                        <h2 id="aktif-title" class="mt-1.5 text-[17px] font-bold leading-snug">{{ \Illuminate\Support\Str::limit($laporanTerbaru->alamat, 64) }}</h2>
                        @if ($laporanTerbaru->latitude && $laporanTerbaru->longitude)
                            <p class="mt-1 flex items-center gap-1 text-[11px] text-[#766965]">
                                <svg class="h-3.5 w-3.5 shrink-0 text-[#c41621]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.5a7.5 7.5 0 0 0-7.5 7.5c0 5.6 7.5 11.5 7.5 11.5S19.5 15.6 19.5 10A7.5 7.5 0 0 0 12 2.5Zm0 10.2a2.7 2.7 0 1 1 0-5.4 2.7 2.7 0 0 1 0 5.4Z"/></svg>
                                Titik Lokasi: {{ $laporanTerbaru->latitude }}, {{ $laporanTerbaru->longitude }}
                            </p>
                        @endif

                        <div class="mt-3 flex items-start gap-2 rounded-lg px-3 py-2.5 {{ $kotak }}">
                            <span class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full {{ $titik }}"></span>
                            <div class="min-w-0">
                                <p class="text-[13px] font-bold leading-tight {{ $warnaTeks }}">{{ $statusLabel }}</p>
                                <p class="mt-0.5 text-[11px] font-medium text-[#5c4f4c]">{{ $subLabel }}</p>
                            </div>
                        </div>

                        @if ($ditolak)
                            <div class="mt-3 rounded-lg bg-[#f2f0ef] p-3 text-[12px] text-[#5c4f4c]">
                                <p class="font-bold text-[#a20c15]">Laporan Anda ditolak oleh petugas</p>
                                @if ($laporanTerbaru->alasan_penolakan)
                                    <p class="mt-1"><span class="font-bold">Alasan:</span> {{ $laporanTerbaru->alasan_penolakan }}</p>
                                @endif
                                @if ($laporanTerbaru->ditolak_pada)
                                    <p class="mt-1 text-[10px] text-[#8a7f7b]">Ditolak pukul {{ $laporanTerbaru->ditolak_pada->translatedFormat('H.i') }} WIB. Jika ini kejadian nyata, buat laporan baru atau hubungi 112.</p>
                                @endif
                            </div>
                        @else
                        <div class="mt-3 rounded-lg bg-[#f2f0ef] p-3">
                            <p class="text-[9px] font-bold uppercase tracking-wide text-[#494442]">Status Alur Respon Cepat</p>
                            <ol class="mt-2.5 grid grid-cols-5 gap-1 text-center" aria-label="Tahapan penanganan laporan">
                                @foreach ($steps as $i => $label)
                                    @php $done = $i < $currentStep || $currentStep >= 4; $current = $i === $currentStep && $currentStep < 4; @endphp
                                <li class="flex flex-col items-center gap-1 {{ $current ? 'text-[#c41621]' : ($done ? 'text-[#292626]' : 'text-[#a39a95]') }}">
                                    @if ($done)
                                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#c41621] text-white"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4 10-10"/></svg></span>
                                    @elseif ($current)
                                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#c41621] font-bold text-white ring-4 ring-[#c41621]/20">{{ strtolower($label[0]) === 'a' ? 'A' : ($i + 1) }}</span>
                                    @else
                                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#e4e0dd]">{{ $i + 1 }}</span>
                                    @endif
                                    <span class="text-[10px] {{ $current ? 'font-bold' : 'font-semibold' }}">{{ $label }}</span>
                                    <span class="text-[9px] text-[#8a7f7b]">{{ $waktuStep[$i] ?? '-:-' }}</span>
                                </li>
                                @endforeach
                            </ol>
                        </div>

                        @endif

                        @if ($berjalan)
                        <a href="{{ route('laporan.lacak', $laporanTerbaru) }}" class="mt-4 inline-flex items-center gap-2 rounded-full bg-[#c41621] px-5 py-2.5 text-xs font-bold text-white shadow-md shadow-red-900/15 transition hover:bg-[#a90d25]">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 2 11 13M22 2l-7 20-4-9-9-4 20-7Z"/></svg>
                            Lacak Armada
                        </a>
                        @endif
                    </article>
                @else
                    <div class="rounded-xl border border-dashed border-[#e0d5d1] bg-white p-6 text-center">
                        <p class="text-2xl" aria-hidden="true">🏠</p>
                        <p class="mt-2 text-sm font-semibold text-[#292626]">Belum ada laporan aktif</p>
                        <p class="mt-1 text-xs text-[#766965]">Laporkan segera bila terjadi kebakaran di sekitarmu.</p>
                        <a href="{{ route('lapor.create') }}" class="mt-3 inline-flex items-center gap-1.5 rounded-full bg-[#c41621] px-4 py-2 text-xs font-bold text-white shadow transition hover:bg-[#a90d25]">🚨 Buat Laporan</a>
                    </div>
                @endif
            </section>

            <!-- Riwayat laporan sebelumnya (hanya tampil jika ada) -->
            @if ($riwayatLaporan->isNotEmpty())
                <details class="space-y-2">
                    <summary class="cursor-pointer text-sm font-bold">Riwayat Laporan Sebelumnya ({{ $riwayatLaporan->count() }})</summary>
                    <div class="mt-2 space-y-2">
                    @foreach ($riwayatLaporan as $riwayat)
                        <article class="rounded-xl border border-[#f3eeeb] bg-white p-4 shadow-[0_3px_12px_rgba(65,45,40,0.04)]">
                            <div class="flex flex-wrap items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="text-[9px] font-bold uppercase tracking-wide text-[#8a7f7b]">Laporan</p>
                                    <p class="mt-0.5 text-[13px] font-semibold text-[#292626]">{{ $riwayat->created_at->translatedFormat('d M Y') }} • {{ $riwayat->created_at->translatedFormat('H.i') }} WIB</p>
                                </div>
                                @if ($riwayat->status === 'selesai')
                                    <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full border border-[#e3ecf7] bg-white px-2.5 py-1 text-[10px] font-bold text-[#1c4c8c]"><span class="h-1.5 w-1.5 rounded-full bg-[#1c6dd0]"></span>Selesai Dipadamkan</span>
                                @elseif ($riwayat->status === 'ditolak')
                                    <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full border border-[#f5dedd] bg-white px-2.5 py-1 text-[10px] font-bold text-[#a20c15]"><span class="h-1.5 w-1.5 rounded-full bg-[#c41621]"></span>Laporan Ditolak</span>
                                @else
                                    <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full border border-[#f5dedd] bg-white px-2.5 py-1 text-[10px] font-bold text-[#a20c15]"><span class="h-1.5 w-1.5 rounded-full bg-[#c41621]"></span>Tidak Diproses</span>
                                @endif
                            </div>
                            <h3 class="mt-2 text-[15px] font-bold leading-snug">{{ \Illuminate\Support\Str::limit($riwayat->alamat, 64) }}</h3>
                            @if ($riwayat->keterangan)
                                <p class="mt-0.5 text-[11px] text-[#766965]">{{ \Illuminate\Support\Str::limit($riwayat->keterangan, 80) }}</p>
                            @endif
                            @if ($riwayat->status === 'ditolak' && $riwayat->alasan_penolakan)
                                <p class="mt-1 text-[11px] font-semibold text-[#a20c15]">Alasan ditolak: {{ $riwayat->alasan_penolakan }}</p>
                            @endif
                        </article>
                    @endforeach
                    </div>
                </details>
            @endif

            @if ($bisaLapor)
            <div class="flex justify-end">
                <a href="{{ route('lapor.create') }}" class="inline-flex items-center gap-2 rounded-full bg-[#c41621] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-red-900/20 transition hover:bg-[#a90d25]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c1 3-1 4.5.5 6 1.7-1.2 2.1-2.7 2.2-3.5C18 9 19 11 19 14a7 7 0 1 1-14 0c0-2.5 1-4.2 3.2-6.5-.1 2.2.7 3.3 1.8 4C11 9 10 6 12 3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 13c1 1.1 2 2.1 2 3.5a2 2 0 1 1-4 0c0-1.4.9-2.4 2-3.5Z"/></svg>
                    Buat Laporan Baru
                </a>
            </div>
            @else
                <p class="rounded-xl bg-white p-3 text-center text-[11px] font-semibold text-[#766965]">Laporan baru bisa dibuat setelah laporan Anda selesai atau ditolak.</p>
            @endif
        </main>

        <nav aria-label="Navigasi utama" class="sticky bottom-0 z-30 grid grid-cols-4 border-t border-[#f0e8e5] bg-[#fffaf8]/95 px-2 pb-[max(0.55rem,env(safe-area-inset-bottom))] pt-2 shadow-[0_-4px_18px_rgba(60,35,30,0.05)] backdrop-blur">
            <a href="{{ route('beranda') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V10Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6c.8 1.5-.7 2.2.4 3 1-.5 1.3-1.4 1.3-1.4 1.2 1.7 1.3 2.6.3 3.7"/></svg><span class="text-[10px] font-bold">Beranda</span></a>
            <a href="{{ route('peta') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Zm6-3v15m6-12v15"/></svg><span class="text-[10px] font-bold">Peta</span></a>
            <a href="{{ route('laporan.saya') }}" aria-current="page" class="flex flex-col items-center gap-0.5 text-[#bd101b]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6l1 2h4v15H4V6h4l1-2Zm1 6h4m-4 4h6m-6 4h6"/></svg><span class="text-[10px] font-bold">Laporan</span></a>
            <a href="{{ route('masyarakat.profile') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2H4Z"/></svg><span class="text-[10px] font-bold">Profil</span></a>
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
