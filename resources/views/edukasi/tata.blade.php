<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP Damkar — Metode T.A.T.A</title>
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
                            <span class="block text-xl sm:text-2xl font-bold tracking-tight text-[#292626]">Edukasi APAR</span>
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
                    <a href="{{ route('laporan.saya') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:text-[#bd101b] hover:bg-[#fff0ed] transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6l1 2h4v15H4V6h4l1-2Zm1 6h4m-4 4h6m-6 4h6"/></svg>
                        <span>Laporan Saya</span>
                    </a>
                    <a href="{{ route('edukasi.index') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[#bd101b] bg-red-50 font-bold transition">
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
            <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-5 sm:py-7 space-y-6">

            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center gap-2 text-xs text-[#766965]">
                <a href="{{ route('beranda') }}" class="hover:text-[#bd101b] transition">Beranda</a>
                <span>›</span>
                <a href="{{ route('edukasi.index') }}" class="hover:text-[#bd101b] transition">Edukasi</a>
                <span>›</span>
                <span class="font-bold text-[#bd101b]">Metode T.A.T.A</span>
            </nav>

            <!-- Judul Artikel -->
            <section aria-labelledby="tata-title" class="space-y-2">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#fdecea] text-[#c41621] text-2xl" aria-hidden="true">🧯</span>
                    <div>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#fff0e5] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide text-[#8b4c27]">Tips APAR · Waktu Baca 1 Menit</span>
                        <h1 id="tata-title" class="text-xl sm:text-2xl font-bold leading-tight tracking-tight text-slate-900 mt-1">Metode T.A.T.A Saat Api Mulai Muncul</h1>
                    </div>
                </div>
                <p class="text-sm text-[#766965]">Cara cepat, tepat, dan aman memadamkan api kecil dengan APAR (Alat Pemadam Api Ringan) sebelum membesar.</p>
            </section>

            <!-- Responsive Grid: 2 Kolom di Desktop (lg:) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                <!-- Kolom Kiri: 4 Langkah & Langkah Darurat Awal (8 cols on lg) -->
                <div class="lg:col-span-7 xl:col-span-8 space-y-6">

                    <!-- Detail 4 langkah (kartu kotak) -->
                    <section class="space-y-3" aria-label="Detail Langkah Metode T.A.T.A">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-[#766965]">Empat Langkah Pokok (T - A - T - A)</h2>

                        <!-- Langkah 1: Tarik Pin -->
                        <div class="flex items-start gap-4 rounded-2xl border border-[#f0e8e5] bg-white p-4 sm:p-5 shadow-sm transition hover:border-red-200">
                            <span class="flex shrink-0 h-10 w-10 items-center justify-center rounded-xl bg-[#dc2626] text-white text-base font-extrabold shadow-sm">1</span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900">T - Tarik Pin Pengaman (Pull)</h3>
                                <p class="mt-1 text-xs text-[#5c4f4c] leading-relaxed">Cabut pin pengaman yang ada di bagian tuas/handle APAR. Pastikan segel plastik terlepas sehingga tuas siap ditekan.</p>
                            </div>
                            <span class="flex shrink-0 text-2xl text-[#c41621]" aria-hidden="true">🧷</span>
                        </div>

                        <!-- Langkah 2: Arahkan Nozzle -->
                        <div class="flex items-start gap-4 rounded-2xl border border-[#f0e8e5] bg-white p-4 sm:p-5 shadow-sm transition hover:border-red-200">
                            <span class="flex shrink-0 h-10 w-10 items-center justify-center rounded-xl bg-[#dc2626] text-white text-base font-extrabold shadow-sm">2</span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900">A - Arahkan Nozzle / Selang (Aim)</h3>
                                <p class="mt-1 text-xs text-[#5c4f4c] leading-relaxed">Arahkan corong/ujung selang APAR langsung ke dasar/pangkalan api, bukan ke bagian lidah api atau kepulan asapnya.</p>
                            </div>
                            <span class="flex shrink-0 text-2xl text-[#c41621]" aria-hidden="true">🎯</span>
                        </div>

                        <!-- Langkah 3: Tekan Tuas -->
                        <div class="flex items-start gap-4 rounded-2xl border border-[#f0e8e5] bg-white p-4 sm:p-5 shadow-sm transition hover:border-red-200">
                            <span class="flex shrink-0 h-10 w-10 items-center justify-center rounded-xl bg-[#dc2626] text-white text-base font-extrabold shadow-sm">3</span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900">T - Tekan Tuas Katup (Squeeze)</h3>
                                <p class="mt-1 text-xs text-[#5c4f4c] leading-relaxed">Tekan tuas pegangan dengan kuat, rapat, dan stabil agar serbuk kimia atau CO2 di dalam tabung menyembur secara optimal.</p>
                            </div>
                            <span class="flex shrink-0 text-2xl text-[#c41621]" aria-hidden="true">✊</span>
                        </div>

                        <!-- Langkah 4: Sapukan ke Sumber Api -->
                        <div class="flex items-start gap-4 rounded-2xl border border-[#f0e8e5] bg-white p-4 sm:p-5 shadow-sm transition hover:border-red-200">
                            <span class="flex shrink-0 h-10 w-10 items-center justify-center rounded-xl bg-[#dc2626] text-white text-base font-extrabold shadow-sm">4</span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900">A - Ayunkan / Sapukan Rata (Sweep)</h3>
                                <p class="mt-1 text-xs text-[#5c4f4c] leading-relaxed">Sapukan semburan dari kiri ke kanan secara merata hingga seluruh dasar api terselimuti bahan pemadam dan padam sempurna.</p>
                            </div>
                            <span class="flex shrink-0 text-2xl text-[#c41621]" aria-hidden="true">↔️</span>
                        </div>
                    </section>

                    <!-- Langkah darurat awal -->
                    <section aria-labelledby="darurat-title" class="rounded-2xl border border-[#c41621]/20 bg-[#fef7f7] p-5 shadow-sm">
                        <h2 id="darurat-title" class="text-sm font-bold text-[#c41621] flex items-center gap-2 mb-3">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z"/></svg>
                            <span>Protokol Keamanan Warga Saat Api Muncul</span>
                        </h2>
                        <ul class="space-y-2 list-disc list-inside text-xs text-[#5c4f4c] leading-relaxed">
                            <li>Tetap tenang, perhatikan posisi jalan keluar agar selalu berada di belakang Anda (jangan sampai terjebak).</li>
                            <li>Jika api masih kecil (tahap awal), segera gunakan APAR dengan metode T.A.T.A di atas.</li>
                            <li>Jika tidak tersedia APAR atau kobaran api membesar dalam hitungan detik, <b>jangan memaksakan diri</b>.</li>
                            <li>Keluarkan seluruh penghuni ruangan dan segera tutup pintu akses untuk memperlambat oksigen masuk.</li>
                            <li>Gunakan aplikasi SIGAP untuk lapor darurat atau hubungi <b>112 Damkar</b> (bebas pulsa).</li>
                        </ul>
                    </section>

                </div>

                <!-- Kolom Kanan: Media Demonstrasi, Evakuasi & Hotline (4 cols on lg) -->
                <div class="lg:col-span-5 xl:col-span-4 space-y-6">

                    <!-- Gambar Demonstrasi APAR -->
                    <section class="rounded-2xl border border-[#f0e8e5] bg-white p-5 shadow-sm space-y-3">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Demonstrasi Latihan APAR</h3>
                        <div class="relative overflow-hidden rounded-xl border border-[#f3eeeb] bg-[#f2f0ef]">
                            <img
                                src="{{ asset('images/apar-demo.jpg') }}"
                                alt="Petugas latihan memadamkan api kecil menggunakan APAR (metode T.A.T.A)"
                                class="w-full h-52 object-cover"
                            />
                        </div>
                        <p class="text-xs text-[#766965] leading-relaxed">
                            Demonstrasi penggunaan APAR oleh tim pemadam kebakaran. Semburan dilakukan dengan jarak aman 2–3 meter dari pangkalan api.
                        </p>
                    </section>

                    <!-- Kapan evakuasi -->
                    <section aria-labelledby="evakuasi-title" class="rounded-2xl border border-[#f0e8e5] bg-white p-5 shadow-sm space-y-3">
                        <h2 id="evakuasi-title" class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2">Kapan Harus Segera Evakuasi?</h2>
                        <div class="space-y-2.5">
                            <div class="flex items-start gap-2.5 rounded-xl border border-red-100 bg-[#fef7f7] p-3 text-xs">
                                <span class="flex shrink-0 h-5 w-5 items-center justify-center rounded-full bg-[#c41621] text-white text-[10px] font-bold">!</span>
                                <div class="min-w-0">
                                    <p class="font-bold text-[#c41621]">Api merembet ke langit-langit / plafon</p>
                                    <p class="mt-0.5 text-[11px] text-[#5c4f4c]">Bahaya runtuhan material membara sangat tinggi.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2.5 rounded-xl border border-red-100 bg-[#fef7f7] p-3 text-xs">
                                <span class="flex shrink-0 h-5 w-5 items-center justify-center rounded-full bg-[#c41621] text-white text-[10px] font-bold">!</span>
                                <div class="min-w-0">
                                    <p class="font-bold text-[#c41621]">Asap tebal &amp; gas beracun</p>
                                    <p class="mt-0.5 text-[11px] text-[#5c4f4c]">Rundukkan badan dan tutup saluran napas.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2.5 rounded-xl border border-red-100 bg-[#fef7f7] p-3 text-xs">
                                <span class="flex shrink-0 h-5 w-5 items-center justify-center rounded-full bg-[#c41621] text-white text-[10px] font-bold">!</span>
                                <div class="min-w-0">
                                    <p class="font-bold text-[#c41621]">APAR habis namun api belum padam</p>
                                    <p class="mt-0.5 text-[11px] text-[#5c4f4c]">Segera tinggalkan area dan hubungi 112.</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Kartu Bantuan Darurat Hotline 112 -->
                    <div class="rounded-2xl border border-[#cfe1f5] bg-[#edf5fc] p-5 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#0064ad] text-white shadow-sm">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-[10px] font-extrabold uppercase tracking-wider text-[#0064ad]">Hotline 24 Jam Bebas Pulsa</p>
                                <h3 class="text-base font-bold text-slate-900 leading-tight">Damkar 112 Palembang</h3>
                                <p class="text-[11px] text-slate-500">Panggilan Darurat Cepat</p>
                            </div>
                            <a href="tel:112" class="shrink-0 rounded-full bg-[#0064ad] hover:bg-[#00518c] px-4 py-2 text-xs font-bold text-white shadow transition">
                                Panggil
                            </a>
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <a href="{{ route('edukasi.index') }}" class="w-full inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 bg-white hover:bg-slate-50 py-3 text-xs font-bold text-slate-700 shadow-sm transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        <span>Kembali ke Daftar Edukasi</span>
                    </a>

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
                        <a href="{{ route('laporan.saya') }}" class="hover:text-[#bd101b] transition">Laporan Saya</a>
                        <a href="{{ route('edukasi.index') }}" class="hover:text-[#bd101b] transition font-bold text-[#bd101b]">Edukasi</a>
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
</body>
</html>
