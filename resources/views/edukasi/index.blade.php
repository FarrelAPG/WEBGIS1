<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP Damkar — Edukasi &amp; Antisipasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans text-[#292626] antialiased sm:flex sm:justify-center sm:bg-gray-100">
    <div class="min-h-screen w-full max-w-2xl bg-[#fffaf8] shadow-[0_0_32px_rgba(75,35,35,0.06)] sm:shadow-xl flex flex-col justify-between">

        <!-- Header -->
        <header class="sticky top-0 z-20 border-b border-[#f2e9e6] bg-[#fffaf8]/95 px-5 py-3 backdrop-blur">
            <div class="flex items-center gap-3">
                <a href="{{ route('beranda') }}" class="flex min-w-0 items-center gap-2.5" aria-label="SIGAP Damkar Beranda">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-slate-100 bg-white p-1.5 shadow-sm">
                        <img src="{{ asset('images/sigap-logo.svg') }}" alt="" class="h-full w-full object-contain">
                    </span>
                    <span class="min-w-0 leading-tight">
                        <span class="block text-[10px] font-extrabold tracking-[0.12em] text-[#bd101b]">SIGAP DAMKAR</span>
                        <span class="block text-xl font-semibold tracking-tight text-[#292626]">Edukasi</span>
                    </span>
                </a>
                <button type="button" onclick="location.href='{{ route('beranda') }}'" aria-label="Kembali ke Beranda" class="ml-auto rounded-full p-1 text-[#473a38] transition hover:bg-[#f2e9e6]">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
            </div>
        </header>

        <main class="flex-1 space-y-5 px-5 pb-6 pt-4 sm:px-7">

            <!-- Judul Halaman -->
            <section aria-labelledby="daftar-title" class="space-y-1">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <h1 id="daftar-title" class="text-xl font-bold tracking-tight">Edukasi &amp; Antisipasi Cepat</h1>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#f2f0ef] px-2.5 py-1 text-[10px] font-medium text-[#5c4f4c]">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#dc2626]"></span>Publik
                    </span>
                </div>
                <p class="text-sm text-[#766965]">Pelajari cara mencegah, menangani, dan evakuasi dari kebakaran di rumah maupun lingkungan.</p>
            </section>

            <!-- Daftar Artikel Edukasi -->
            <section aria-labelledby="artikel-title" class="space-y-3">
                <h2 id="artikel-title" class="text-sm font-bold uppercase tracking-wide text-[#766965]">Semua Artikel</h2>

                <div class="grid grid-cols-1 gap-3">
                    @foreach ($artikel as $a)
                    <a href="{{ $a['slug'] === 'metode-tata' ? route('edukasi.tata') : route('edukasi.tata') }}" class="group flex items-center gap-3 rounded-xl border border-[#f3eeeb] bg-white p-3.5 shadow-[0_3px_12px_rgba(65,45,40,0.04)] transition hover:border-[#dc2626]/40">
                        <span class="flex h-[56px] w-16 shrink-0 items-center justify-center rounded-lg bg-[#fdecea] text-[#c41621] group-hover:bg-[#fee2e2] text-2xl" aria-hidden="true">{{ $a['ikonen'] }}</span>
                        <span class="min-w-0 flex-1">
                            <span class="flex flex-wrap items-center gap-2 text-[10px] text-[#766965]">
                                <span class="rounded bg-[#fff0e5] px-1.5 py-0.5 font-semibold text-[#8b4c27]">{{ $a['kategori'] }}</span>
                                <span class="text-[#c41621]">{{ $a['waktuBaca'] }}</span>
                            </span>
                            <span class="mt-1 block text-[13px] font-bold leading-tight group-hover:text-[#dc2626] transition-colors">{{ $a['judul'] }}</span>
                            <span class="mt-1 block truncate text-[11px] text-[#766965]">{{ $a['deskripsi'] }}</span>
                        </span>
                        <svg class="h-4 w-4 shrink-0 text-[#b8b2af] group-hover:text-[#dc2626] transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                    </a>
                    @endforeach
                </div>
            </section>

            <!-- Catatan Penting -->
            <section class="rounded-xl border border-[#fdecea] bg-[#fef7f7] p-4 shadow-sm">
                <div class="flex gap-3">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#fee2e2] text-[#c41621] text-lg" aria-hidden="true">ℹ️</span>
                    <div class="min-w-0">
                        <p class="text-[11px] font-bold text-[#c41621]">Selalu prioritaskan keselamatan diri</p>
                        <p class="mt-0.5 text-[11px] text-[#766965]">Jika api sudah besar atau tidak bisa dipadamkan dengan APAR, lakukan evakuasi segera dan hubungi <b>Hotline 113 Damkar</b> (bebas pulsa). Jangan memaksakan diri memadamkan api besar.</p>
                    </div>
                </div>
            </section>

        </main>

        <!-- Navigasi bawah (konsisten dengan halaman masyarakat lainnya) -->
        <nav aria-label="Navigasi utama" class="sticky bottom-0 z-30 grid grid-cols-4 border-t border-[#f0e8e5] bg-[#fffaf8]/95 px-2 pb-[max(0.55rem,env(safe-area-inset-bottom))] pt-2 shadow-[0_-4px_18px_rgba(60,35,30,0.05)] backdrop-blur">
            <a href="{{ route('beranda') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V10Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6c.8 1.5-.7 2.2.4 3 1-.5 1.3-1.4 1.3-1.4 1.2 1.7 1.3 2.6.3 3.7"/></svg><span class="text-[10px] font-bold">Beranda</span>
            </a>
            <a href="{{ route('peta') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Zm6-3v15m6-12v15"/></svg><span class="text-[10px] font-bold">Peta</span>
            </a>
            <a href="{{ route('laporan.saya') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6l1 2h4v15H4V6h4l1-2Zm1 6h4m-4 4h6m-6 4h6"/></svg><span class="text-[10px] font-bold">Laporan</span>
            </a>
            <a href="{{ route('masyarakat.profile') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2H4Z"/></svg><span class="text-[10px] font-bold">Profil</span>
            </a>
        </nav>
    </div>
</body>
</html>
