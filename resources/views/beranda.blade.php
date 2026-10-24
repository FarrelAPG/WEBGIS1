<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP Damkar — Beranda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans text-[#292626] antialiased sm:flex sm:justify-center sm:bg-gray-100">
    <div class="min-h-screen w-full max-w-2xl bg-[#fffaf8] shadow-[0_0_32px_rgba(75,35,35,0.06)] sm:shadow-xl flex flex-col justify-between">
        <header class="sticky top-0 z-20 border-b border-[#f2e9e6] bg-[#fffaf8]/95 px-5 py-3 backdrop-blur">
            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('beranda') }}" class="flex min-w-0 items-center gap-2.5" aria-label="SIGAP Damkar Beranda">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-slate-100 bg-white p-1.5 shadow-sm">
                        <img src="{{ asset('images/sigap-logo.svg') }}" alt="" class="h-full w-full object-contain">
                    </span>
                    <span class="min-w-0 leading-tight">
                        <span class="block text-[10px] font-extrabold tracking-[0.12em] text-[#bd101b]">SIGAP DAMKAR</span>
                        <span class="block text-xl font-semibold tracking-tight text-[#292626]">Beranda</span>
                    </span>
                </a>
                <div class="flex items-center gap-2.5">
                    <a href="{{ route('portal') }}" title="Kembali ke Pilihan Portal" class="inline-flex items-center gap-1 rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[10px] font-bold text-slate-600 shadow-sm transition hover:border-red-200 hover:text-[#bd101b]">
                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        <span>Portal</span>
                    </a>
                    <button type="button" aria-label="Notifikasi" onclick="location.href='{{ route('laporan.saya') }}'" class="relative rounded-full p-1 text-[#473a38]">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg>
                        <span class="absolute right-0.5 top-0.5 h-2 w-2 rounded-full bg-[#c41621] ring-2 ring-[#fffaf8]"></span>
                    </button>
                    <a href="@auth{{ route('profile.edit') }}@else{{ route('login') }}@endauth" class="h-9 w-9 overflow-hidden rounded-full border-2 border-[#e7b5ae] bg-white p-0.5" aria-label="Profil">
                        <img src="{{ asset('images/avatar.svg') }}" alt="Foto profil" class="h-full w-full rounded-full object-cover">
                    </a>
                </div>
            </div>
        </header>

        <main class="flex-1 space-y-5 px-5 pb-6 pt-3 sm:px-7">
            <section aria-labelledby="greeting-title" class="space-y-1">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <h1 id="greeting-title" class="text-[22px] font-bold leading-tight tracking-tight sm:text-2xl">Halo, @auth{{ Auth::user()->name }}@else Warga Palembang @endauth <span aria-hidden="true">👋</span></h1>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#f2f0ed] px-2.5 py-1 text-[10px] font-medium text-[#494442]"><span class="h-2 w-2 rounded-full bg-emerald-600"></span>Posisi Aman</span>
                </div>
                <p class="text-sm text-[#766965]">Tetap waspada, laporkan keadaan darurat segera.</p>
                <p class="flex items-center gap-1.5 text-[13px] font-semibold text-[#49403e]">
                    <svg class="h-4 w-4 shrink-0 text-[#c41520]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.5a7.5 7.5 0 0 0-7.5 7.5c0 5.6 7.5 11.5 7.5 11.5S19.5 15.6 19.5 10A7.5 7.5 0 0 0 12 2.5Zm0 10.2a2.7 2.7 0 1 1 0-5.4 2.7 2.7 0 0 1 0 5.4Z"/></svg>
                    <span id="lokasi-pengguna" class="transition-opacity duration-200">Kota Palembang, Sumatera Selatan</span>
                    <button type="button" id="btn-refresh-lokasi" title="Perbarui lokasi GPS" class="text-slate-400 hover:text-[#c41520] transition-colors p-0.5">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </button>
                </p>
            </section>

            <section class="overflow-hidden rounded-xl bg-gradient-to-br from-[#c4111b] via-[#b90d17] to-[#d01b26] text-white shadow-[0_14px_28px_rgba(168,12,24,0.17)]" aria-labelledby="emergency-title">
                <div class="p-5 sm:p-6">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <div class="flex min-w-0 items-center gap-2.5">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white/15 ring-1 ring-white/10">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c1 3-1 4.5.5 6 1.7-1.2 2.1-2.7 2.2-3.5C18 9 19 11 19 14a7 7 0 1 1-14 0c0-2.5 1-4.2 3.2-6.5-.1 2.2.7 3.3 1.8 4C11 9 10 6 12 3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 13c1 1.1 2 2.1 2 3.5a2 2 0 1 1-4 0c0-1.4.9-2.4 2-3.5Z"/></svg>
                            </span>
                            <span class="truncate rounded-full bg-white/15 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide"><span class="mr-1 inline-block h-1.5 w-1.5 rounded-full bg-white"></span>Sinyal darurat langsung</span>
                        </div>
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white text-sm font-black text-[#c41621] shadow">SOS</span>
                    </div>
                    <h2 id="emergency-title" class="text-[36px] font-extrabold uppercase leading-[0.98] tracking-tight sm:text-[42px]">Lapor<br>Kebakaran</h2>
                    <p class="mt-1.5 max-w-lg text-[13px] leading-[1.45] text-white/95 sm:text-sm">Tekan untuk laporan darurat seketika &amp; kirim sinyal lokasi GPS langsung ke komando pusat.</p>
                </div>
                <a href="{{ route('lapor.create') }}" id="btn-aktivasi-lapor" class="flex min-h-12 items-center justify-between gap-3 bg-white px-5 text-[11px] font-extrabold uppercase tracking-wide text-black transition hover:bg-gray-100 sm:px-6 sm:text-xs">
                    <span>Aktivasi cepat 1-ketukan <span class="normal-case tracking-normal text-black/80">Kirim titik koordinat</span></span>
                    <svg class="h-5 w-5 shrink-0 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </a>
            </section>

            <section aria-labelledby="area-title" class="space-y-2">
                <div class="flex items-center justify-between gap-2">
                    <h2 id="area-title" class="text-sm font-bold">Kondisi Wilayah Sekitar</h2>
                    <span class="text-[9px] font-bold uppercase tracking-wide text-[#bd101b]">Pembaruan 1m lalu</span>
                </div>
                <div class="grid grid-cols-3 gap-2.5">
                    <article class="min-w-0 rounded-xl border border-[#f3eeeb] bg-white p-3 shadow-[0_3px_10px_rgba(65,45,40,0.04)]">
                        <div class="mb-2 flex items-center gap-1.5"><span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#ffe0dc] text-[#c41621]"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c1 3-1 4.5.5 6 1.7-1.2 2.1-2.7 2.2-3.5C18 9 19 11 19 14a7 7 0 1 1-14 0c0-2.5 1-4.2 3.2-6.5-.1 2.2.7 3.3 1.8 4C11 9 10 6 12 3Z"/></svg></span><span class="whitespace-nowrap rounded-full bg-[#ffe0dc] px-1.5 py-0.5 text-[9px] font-bold text-[#a20c15]">{{ $totalKejadianAktif ?? 0 }} Aktif</span></div>
                        <p class="text-[17px] font-semibold leading-tight">Palembang</p><p class="mt-0.5 text-[11px] text-[#685b57]">Wilayah<br>Operasi</p>
                    </article>
                    <article class="min-w-0 rounded-xl border border-[#f3eeeb] bg-white p-3 shadow-[0_3px_10px_rgba(65,45,40,0.04)]">
                        <div class="mb-2 flex items-center gap-1.5"><span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#dceaff] text-[#1c4c8c]"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 21V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16M2 21h20M8 7h2m4 0h2M8 11h2m4 0h2M8 15h2m4 0h2M10 21v-3h4v3"/></svg></span><span class="whitespace-nowrap rounded-full bg-[#dceaff] px-1.5 py-0.5 text-[9px] font-bold text-[#213f66]">Siaga</span></div>
                        <p class="text-[17px] font-semibold leading-tight">8 Pos</p><p class="mt-0.5 text-[11px] text-[#685b57]">Pos Damkar</p>
                    </article>
                    <article class="min-w-0 rounded-xl border border-[#f3eeeb] bg-white p-3 shadow-[0_3px_10px_rgba(65,45,40,0.04)]">
                        <div class="mb-2 flex items-center gap-1.5"><span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#ffe1cc] text-[#a44d0b]"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m10.3 3.8-8 14A2 2 0 0 0 4 20.8h16a2 2 0 0 0 1.7-3l-8-14a2 2 0 0 0-3.4 0ZM12 9v4m0 3h.01"/></svg></span><span class="whitespace-nowrap rounded-full bg-[#ffe1cc] px-1.5 py-0.5 text-[9px] font-bold text-[#704018]">Waspada</span></div>
                        <p class="text-[17px] font-semibold leading-tight">24 Jam</p><p class="mt-0.5 text-[11px] text-[#685b57]">Status Siaga</p>
                    </article>
                </div>
            </section>

            @if ($laporanAktif)
                @php
                    $tahap = $laporanAktif->tahapMasyarakat();
                @endphp
                <section id="laporan-aktif" aria-labelledby="report-title" class="space-y-2">
                    <div class="flex items-center justify-between gap-2">
                        <h2 id="report-title" class="flex items-center gap-1.5 text-sm font-bold"><span class="h-2.5 w-2.5 rounded-full bg-[#c41621] animate-pulse"></span>Laporan Aktif Anda</h2>
                        <span class="text-[11px] font-semibold text-[#766965]">ID: #SIGAP-{{ str_pad($laporanAktif->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <article class="rounded-xl border border-[#f3eeeb] bg-white p-4 shadow-[0_3px_12px_rgba(65,45,40,0.04)]">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="truncate text-[17px] font-semibold leading-tight">{{ $laporanAktif->alamat }}</h3>
                                <p class="mt-1 flex flex-wrap items-center gap-1 text-[11px] text-[#766965]"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 2"/></svg>{{ $laporanAktif->created_at->diffForHumans() }} <span class="text-[#d5cbc7]">•</span> <span class="font-semibold text-[#bc111c]">Laporan Darurat</span></p>
                            </div>
                            <span class="flex h-10 w-12 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-[#e8eff1] text-2xl" aria-label="Ilustrasi mobil pemadam">🚒</span>
                        </div>
                        <div class="mt-3 flex gap-2 rounded-lg bg-[#fff0e5] px-2.5 py-2.5 text-[11px] font-medium leading-tight text-[#79420f]">
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
                        <ol class="mt-4 grid grid-cols-4 gap-1 text-center" aria-label="Tahapan penanganan laporan">
                            <li class="flex flex-col items-center gap-1"><span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#c41621] text-[11px] text-white">✓</span><span class="text-[9px] font-semibold">Diterima</span></li>
                            <li class="flex flex-col items-center gap-1"><span class="flex h-6 w-6 items-center justify-center rounded-full {{ $tahap >= 1 ? 'bg-[#c41621] text-white' : 'bg-[#f1efed] text-[11px] font-bold text-[#b8b2af]' }}">{{ $tahap >= 1 ? '✓' : '2' }}</span><span class="text-[9px] font-semibold {{ $tahap >= 1 ? 'text-slate-900' : 'text-[#b8b2af]' }}">Verifikasi</span></li>
                            <li class="flex flex-col items-center gap-1"><span class="flex h-6 w-6 items-center justify-center rounded-full {{ $tahap >= 2 ? 'bg-[#c41621] text-white' : 'bg-[#f1efed] text-[11px] font-bold text-[#b8b2af]' }}">{{ $tahap >= 2 ? '✓' : '3' }}</span><span class="text-[9px] font-semibold {{ $tahap >= 2 ? 'text-slate-900' : 'text-[#b8b2af]' }}">Meluncur</span></li>
                            <li class="flex flex-col items-center gap-1"><span class="flex h-6 w-6 items-center justify-center rounded-full {{ $tahap >= 3 ? 'bg-[#c41621] text-white' : 'bg-[#f1efed] text-[11px] font-bold text-[#b8b2af]' }}">{{ $tahap >= 3 ? '✓' : '4' }}</span><span class="text-[9px] font-semibold {{ $tahap >= 3 ? 'text-slate-900' : 'text-[#b8b2af]' }}">Penanganan</span></li>
                        </ol>
                        <a href="{{ route('laporan.lacak', $laporanAktif) }}" class="mt-3 flex min-h-11 items-center justify-center gap-1 rounded-lg bg-[#f2f0ef] px-3 text-center text-[12px] font-bold text-[#393331] transition hover:bg-[#e9e5e3]">Lihat Detail Laporan &amp; Posisi Armada <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg></a>
                    </article>
                </section>
            @endif

            <section aria-labelledby="hotline-title" class="flex items-center gap-3 rounded-xl bg-[#e7f0ff] p-4 shadow-[0_3px_12px_rgba(50,80,130,0.08)]">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#0064ad] text-white shadow-sm"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4h4l2 5-2.5 1.5a15 15 0 0 0 6 6L15 14l5 2v4a1 1 0 0 1-1 1C9.6 21 3 14.4 3 5a1 1 0 0 1 1-1Z"/></svg></span>
                <div class="min-w-0 flex-1"><p class="text-[9px] font-extrabold uppercase tracking-wide text-[#075a9c]">Panggilan siaga 24 jam</p><h2 id="hotline-title" class="text-lg font-semibold leading-tight text-[#123452]">Hotline 113 Damkar</h2><p class="text-[11px] leading-tight text-[#756b69]">Bebas Pulsa &amp; Respons Tanggap</p></div>
                <a href="tel:113" class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-[#0064ad] px-3.5 py-3 text-[11px] font-bold text-white shadow-md transition hover:bg-[#00538f]">Panggil <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4h4l2 5-2.5 1.5a15 15 0 0 0 6 6L15 14l5 2v4a1 1 0 0 1-1 1C9.6 21 3 14.4 3 5a1 1 0 0 1 1-1Zm14 1a6 6 0 0 1 2 4m-2-8a10 10 0 0 1 4 8"/></svg></a>
            </section>

            <section aria-labelledby="education-title" class="space-y-2">
                <div class="flex items-center justify-between gap-2"><h2 id="education-title" class="text-sm font-bold">Edukasi &amp; Antisipasi Cepat</h2><a href="#edukasi" class="text-[10px] font-semibold text-[#bd101b]">Lihat Semua</a></div>
                <a id="edukasi" href="#edukasi" class="flex items-center gap-3 rounded-xl border border-[#f3eeeb] bg-white p-3.5 shadow-[0_3px_12px_rgba(65,45,40,0.04)]">
                    <span class="flex h-[58px] w-16 shrink-0 items-center justify-center rounded-lg bg-[#eef0ed] text-[#9a3026]"><svg class="h-11 w-11" viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M17 13h14v4H17z" fill="#77716b"/><path d="M20 17h8v23h-8z" rx="2" fill="#c8c7bf" stroke="#77716b" stroke-width="1.5"/><path d="M22 9h4v4h-4zM21 22h6v2h-6z" fill="#bd101b"/><path d="M18 19h-3v5h3m13-5h3v5h-3" stroke="#77716b" stroke-width="1.5" stroke-linecap="round"/><path d="M23 26h2m-1-1v4" stroke="#bd101b" stroke-width="1.5" stroke-linecap="round"/><path d="M24 9c-2-2-1-4 0-5 1 2 2 3 0 5Z" fill="#e9a22b"/></svg></span>
                    <span class="min-w-0 flex-1"><span class="flex flex-wrap items-center gap-2 text-[10px] text-[#766965]"><span class="rounded bg-[#fff0e5] px-1.5 py-0.5 font-semibold text-[#8b4c27]">Tips APAR</span>Baca 1 menit</span><span class="mt-1 block text-[13px] font-bold leading-tight">Metode T.A.T.A Saat Api Mulai Muncul</span><span class="mt-1 block truncate text-[11px] text-[#766965]">Tarik pin, Arahkan nozzle, Tekan tuas,...</span></span>
                    <svg class="h-4 w-4 shrink-0 text-[#6d514b]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                </a>
            </section>
        </main>

        <nav aria-label="Navigasi utama" class="sticky bottom-0 z-30 grid grid-cols-4 border-t border-[#f0e8e5] bg-[#fffaf8]/95 px-2 pb-[max(0.55rem,env(safe-area-inset-bottom))] pt-2 shadow-[0_-4px_18px_rgba(60,35,30,0.05)] backdrop-blur">
            <a href="{{ route('beranda') }}" aria-current="page" class="flex flex-col items-center gap-0.5 text-[#bd101b]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V10Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6c.8 1.5-.7 2.2.4 3 1-.5 1.3-1.4 1.3-1.4 1.2 1.7 1.3 2.6.3 3.7"/></svg><span class="text-[10px] font-bold">Beranda</span></a>
            <a href="{{ route('peta') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Zm6-3v15m6-12v15"/></svg><span class="text-[10px] font-bold">Peta</span></a>
            <a href="{{ route('laporan.saya') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6l1 2h4v15H4V6h4l1-2Zm1 6h4m-4 4h6m-6 4h6"/></svg><span class="text-[10px] font-bold">Laporan</span></a>
            <a href="@auth{{ route('profile.edit') }}@else{{ route('login') }}@endauth" class="flex flex-col items-center gap-0.5 text-[#705d58]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2H4Z"/></svg><span class="text-[10px] font-bold">Profil</span></a>
        </nav>
    </div>

    <script>
        (function() {
            const elLokasi = document.getElementById('lokasi-pengguna');
            const btnRefresh = document.getElementById('btn-refresh-lokasi');
            const btnAktivasi = document.getElementById('btn-aktivasi-lapor');

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

            deteksiLokasi();
        })();
    </script>
</body>
</html>
