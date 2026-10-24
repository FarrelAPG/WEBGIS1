<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP Damkar — Metode T.A.T.A</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans text-[#292626] antialiased sm:flex sm:justify-center sm:bg-gray-100">
    <div class="min-h-screen w-full max-w-2xl bg-[#fffaf8] shadow-[0_0_32px_rgba(75,35,35,0.06)] sm:shadow-xl flex flex-col justify-between">

        <!-- Header -->
        <header class="sticky top-0 z-20 border-b border-[#f2e9e6] bg-[#fffaf8]/95 px-5 py-3 backdrop-blur">
            <div class="flex items-center gap-3">
                <button type="button" onclick="history.back()" aria-label="Kembali" class="rounded-full p-1 text-[#473a38] transition hover:bg-[#f2e9e6]">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <a href="{{ route('beranda') }}" class="flex min-w-0 items-center gap-2.5" aria-label="SIGAP Damkar Beranda">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-slate-100 bg-white p-1.5 shadow-sm">
                        <img src="{{ asset('images/sigap-logo.svg') }}" alt="" class="h-full w-full object-contain">
                    </span>
                    <span class="min-w-0 leading-tight">
                        <span class="block text-[10px] font-extrabold tracking-[0.12em] text-[#bd101b]">SIGAP DAMKAR</span>
                        <span class="block text-xl font-semibold tracking-tight text-[#292626]">Metode T.A.T.A</span>
                    </span>
                </a>
            </div>
        </header>

        <main class="flex-1 space-y-5 px-5 pb-6 pt-4 sm:px-7">

            <!-- Judul Artikel -->
            <section aria-labelledby="tata-title" class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#fdecea] text-[#c41621] text-lg" aria-hidden="true">🧯</span>
                    <div>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#fff0e5] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-[#8b4c27"]>Tips APAR · 1 menit</span>
                        <h1 id="tata-title" class="text-xl font-bold leading-tight tracking-tight">Metode T.A.T.A Saat Api Mulai Muncul</h1>
                    </div>
                </div>
                <p class="text-sm text-[#766965]">Cara cepat dan benar memadamkan api kecil dengan APAR (Alat Pemadam Api Ringan) sebelum membesar.</p>
            </section>

            <!-- Gambar Demonstrasi APAR -->
            <section class="rounded-xl bg-white p-4 shadow-[0_3px_12px_rgba(65,45,40,0.04)]">
                <div class="relative overflow-hidden rounded-lg border border-[#f3eeeb] bg-[#f2f0ef]">
                    <img
                        src="{{ asset('images/apar-demo.jpg') }}"
                        alt="Petugas latihan memadam api kecil menggunakan APAR (metode T.A.T.A)"
                        class="w-full h-48 object-cover"
                    />
                    <div class="absolute inset-0 flex items-center justify-center bg-black/10 group-hover:bg-black/20 transition-opacity opacity-0 group-hover:opacity-100">
                        <span class="text-white font-semibold text-sm bg-black/60 px-2 py-1 rounded">Lihat demonstrasi APAR</span>
                    </div>
                </div>
                <p class="mt-2 text-[11px] text-[#766965] text-center">
                    Demonstrasi penggunaan APAR dalam latihan keselamatan kebakaran. Langkah T.A.T.A dilakukan langsung pada api yang masih kecil.
                </p>
            </section>

            <!-- Detail 4 langkah (kartu kotak) -->
            <section class="space-y-3" aria-label="Detail Langkah Metode T.A.T.A">
                <!-- Langkah 1: Tarik Pin -->
                <div class="flex items-start gap-3 rounded-lg border border-[#f3eeeb] bg-white p-3 shadow-sm">
                    <span class="flex shrink-0 h-8 w-8 items-center justify-center rounded-full bg-[#dc2626] text-white text-sm font-bold">1</span>
                    <div class="min-w-0 flex-1">
                        <p class="text-[13px] font-bold leading-snug text-[#292626]">Tarik Pin (Pull)</p>
                        <p class="mt-0.5 text-[11px] text-[#5c4f4c]">Cabut pin pengaman di bagian handle APAR agar nozzle bisa ditekan.</p>
                    </div>
                    <span class="flex shrink-0 text-[#c41621]" aria-hidden="title">🔒</span>
                </div>

                <!-- Langkah 2: Arahkan Nozzle -->
                <div class="flex items-start gap-3 rounded-lg border border-[#f3eeeb] bg-white p-3 shadow-sm">
                    <span class="flex shrink-0 h-8 w-8 items-center justify-center rounded-full bg-[#dc2626] text-white text-sm font-bold">2</span>
                    <div class="min-w-0 flex-1">
                        <p class="text-[13px] font-bold leading-snug text-[#292626]">Arahkan Nozzle (Aim)</p>
                        <p class="mt-0.5 text-[11px] text-[#5c4f4c]">Bidik nozzle ke pangkalan api, bukan ke asapnya. Pegang ujung selang dengan kokoh.</p>
                    </div>
                    <span class="flex shrink-0 text-[#c41621]" aria-hidden="true">🔒</span>
                </div>

                <!-- Langkah 3: Tekan Tuas -->
                <div class="flex items-start gap-3 rounded-lg border border-[#f3eeeb] bg-white p-3 shadow-sm">
                    <span class="flex shrink-0 h-8 w-8 items-center justify-center rounded-full bg-[#dc2626] text-white text-sm font-bold">3</span>
                    <div class="min-w-0 flex-1">
                        <p class="text-[13px] font-bold leading-snug text-[#292626]">Tekan Tuas (Squeeze)</p>
                        <p class="mt-0.5 text-[11px] text-[#5c4f4c]">Tekan tuas/handle dengan kuat dan stabil agar zat pemadam keluar maksimal.</p>
                    </div>
                    <span class="flex shrink-0 text-[#c41621]" aria-hidden="true">🔒</span>
                </div>

                <!-- Langkah 4: Sapukan ke Sumber Api -->
                <div class="flex items-start gap-3 rounded-lg border border-[#f3eeeb] bg-white p-3 shadow-sm">
                    <span class="flex shrink-0 h-8 w-8 items-center justify-center rounded-full bg-[#dc2626] text-white text-sm font-bold">4</span>
                    <div class="min-w-0 flex-1">
                        <p class="text-[13px] font-bold leading-snug text-[#292626]">Sapukan ke Sumber Api (Sweep)</p>
                        <p class="mt-0.5 text-[11px] text-[#5c4f4c]">Gerakkan nozzle dari kiri ke kanan (sapuan) menyelimuti dasar api hingga padam.</p>
                    </div>
                    <span class="flex shrink-0 text-[#c41621]" aria-hidden="true">🔒</span>
                </div>
            </section>

            <!-- Langkah darurat awal -->
            <section aria-labelledby="darurat-title" class="rounded-xl border border-[#c41621]/20 bg-[#fef7f7] p-4 shadow-[0_3px_12px_rgba(65,45,40,0.04)]">
                <h2 id="darurat-title" class="text-sm font-bold text-[#c41621] flex items-center gap-2 mb-3">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z"/></svg>
                    Langkah Darurat Awal Saat Api Muncul
                </h2>
                <ul class="space-y-2 list-disc list-inside text-[12px] text-[#5c4f4c]">
                    <li>Tenang dan berdiri pada posisi yang aman, dengan jalan keluar di belakang Anda.</li>
                    <li>Jika api masih kecil, gunakan APAR dengan metode T.A.T.A di atas.</li>
                    <li>Jika tidak ada APAR atau api sudah menyebar, <b>jangan memaksakan diri</b> memadamkannya.</li>
                    <li>Keluarkan semua orang dari ruangan dan tutup pintu untuk memperlambat penyebaran api &amp; asap.</li>
                    <li>Hubungi <b>113 Damkar</b> (bebas pulsa) dari luar bangunan yang aman.</li>
                </ul>
            </section>

            <!-- Kapan evakuasi -->
            <section aria-labelledby="evakuasi-title" class="rounded-xl bg-white p-4 shadow-[0_3px_12px_rgba(65,45,40,0.04)]">
                <h2 id="evakuasi-title" class="text-sm font-bold mb-3">Kapan Harus Segera Evakuasi?</h2>
                <div class="grid grid-cols-1 gap-2">
                    <div class="flex items-start gap-2 rounded-lg border border-[#f3eeeb] bg-[#fef7f7] p-3">
                        <span class="flex shrink-0 h-5 w-5 items-center justify-center rounded-full bg-[#c41621] text-white text-[10px] font-bold">⚠️</span>
                        <div class="min-w-0">
                            <p class="text-[12px] font-bold text-[#c41621]">Api sudah menyebar ke dinding / langit-langkap</p>
                            <p class="mt-0.5 text-[11px] text-[#5c4f4c]">Jangan coba memadamkan sendiri, evakuasi segera.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2 rounded-lg border border-[#f3eeeb] bg-[#fef7f7] p-3">
                        <span class="flex shrink-0 h-5 w-5 items-center justify-center rounded-full bg-[#c41621] text-white text-[10px] font-bold">⚠️</span>
                        <div class="min-w-0">
                            <p class="text-[12px] font-bold text-[#c41621]">Asap tebal &amp; sulit bernapas</p>
                            <p class="mt-0.5 text-[11px] text-[#5c4f4c]">Tutup hidung, rampang, dan keluar dengan cepat.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2 rounded-lg border border-[#f3eeeb] bg-[#fef7f7] p-3">
                        <span class="flex shrink-0 h-5 w-5 items-center justify-center rounded-full bg-[#c41621] text-white text-[10px] font-bold">⚠️</span>
                        <div class="min-w-0">
                            <p class="text-[12px] font-bold text-[#c41621]">Tidak ada APAR atau APAR sudah habis</p>
                            <p class="mt-0.5 text-[11px] text-[#5c4f4c]">Segera keluar dan hubungi 113 Damkar.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2 rounded-lg border border-[#f3eeeb] bg-[#fef7f7] p-3">
                        <span class="flex shrink-0 h-5 w-5 items-center justify-center rounded-full bg-[#c41621] text-white text-[10px] font-bold">⚠️</span>
                        <div class="min-w-0">
                            <p class="text-[12px] font-bold text-[#c41621]">Jalur keluar mulai tersumbat api / asap</p>
                            <p class="mt-0.5 text-[11px] text-[#5c4f4c]">Cari jalur keluar alternatif atau menempel di dinding.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Nomor darurat -->
            <section aria-labelledby="darurat-number" class="rounded-xl bg-[#c41621] text-white p-5 shadow-[0_10px_24px_rgba(168,12,24,0.2)]">
                <div class="flex items-start gap-3">
                    <span class="flex shrink-0 h-10 w-10 items-center justify-center rounded-full bg-white/20 text-2xl" aria-hidden="true">📞</span>
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-[#fecaca]">Nomor Darurat</p>
                        <h2 id="darurat-number" class="text-2xl font-black leading-none">113</h2>
                        <p class="mt-1 text-sm text-[#fecaca]">Hotline Damkar — Bebas Pulsa &amp; Respons Tanggap (24 jam)</p>
                    </div>
                    <a href="tel:113" class="mt-auto inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-[#c41621] font-bold text-sm transition hover:bg-[#f8fafc]">
                        Panggil 113
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.5 19.5 0 0 1-3-8.7A2 2 0 0 1 4.1 4h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 2.8a2 2 0 0 1-.4 2.1L8.1 12a16 16 0 0 0 6 6l1.4-1.3a2 2 0 0 1 2.1-.4c.9.3 1.9.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg>
                    </a>
                </div>
            </section>

            <!-- Tombol kembali -->
            <section class="flex justify-center">
                <a href="{{ route('beranda') }}" class="inline-flex items-center gap-1.5 rounded-full bg-[#dc2626] hover:bg-[#b91c1c] px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-red-900/20 transition">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5m6-6-6 6 6 6"/></svg>
                    Kembali ke Beranda
                </a>
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
