<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP Damkar — Siapkan Jalur Evakuasi di Rumah</title>
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
                        <img src="{{ asset('images/logo-sigap-red.png') }}" alt="SIGAP DAMKAR" class="h-10 w-10 sm:h-11 sm:w-11 shrink-0 rounded-xl object-contain shadow-sm">
                        <span class="min-w-0 leading-tight">
                            <span class="block text-[10px] sm:text-xs font-extrabold tracking-[0.14em] text-[#bd101b]">SIGAP DAMKAR</span>
                            <span class="block text-xl sm:text-2xl font-bold tracking-tight text-[#292626]">Evakuasi</span>
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
                <span class="font-bold text-[#bd101b]">Jalur Evakuasi Rumah</span>
            </nav>

            <!-- Judul Artikel -->
            <section aria-labelledby="evakuasi-title" class="space-y-2">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#fdecea] text-[#c41621] text-2xl" aria-hidden="true">🚪</span>
                    <div>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#fff0e5] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide text-[#8b4c27]">Penyelamatan Diri · Waktu Baca 2 Menit</span>
                        <h1 id="evakuasi-title" class="text-xl sm:text-2xl font-bold leading-tight tracking-tight text-slate-900 mt-1">Siapkan Rencana &amp; Jalur Evakuasi Kebakaran di Rumah</h1>
                    </div>
                </div>
                <p class="text-sm text-[#766965]">Panduan penting menyiapkan jalur penyelamatan mandiri keluarga agar setiap anggota keluarga dapat menyelamatkan diri dengan cepat saat terjadi kebakaran mendadak.</p>
            </section>

            <!-- Responsive Grid: 2 Kolom di Desktop (lg:) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                <!-- Kolom Kiri: 5 Langkah Jalur Evakuasi (8 cols on lg) -->
                <div class="lg:col-span-7 xl:col-span-8 space-y-6">

                    <!-- Detail Langkah-langkah Pokok -->
                    <section class="space-y-3" aria-label="Langkah Menyiapkan Jalur Evakuasi">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-[#766965]">5 Langkah Utama Perencanaan Jalur Evakuasi</h2>

                        <!-- Langkah 1: Tentukan 2 Rute Keluar -->
                        <div class="flex items-start gap-4 rounded-2xl border border-[#f0e8e5] bg-white p-4 sm:p-5 shadow-sm transition hover:border-red-200">
                            <span class="flex shrink-0 h-10 w-10 items-center justify-center rounded-xl bg-[#dc2626] text-white text-base font-extrabold shadow-sm">1</span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900">Tentukan Minimal 2 Rute Keluar dari Setiap Ruangan</h3>
                                <p class="mt-1 text-xs text-[#5c4f4c] leading-relaxed">Setiap kamar tidur harus memiliki rute keluar utama (pintu kamar ke pintu depan/belakang) dan rute cadangan (jendela lantai 1 yang mudah dibuka, atau akses ke teras/balkon jika jalur utama terhalang api).</p>
                            </div>
                            <span class="flex shrink-0 text-2xl text-[#c41621]" aria-hidden="true">🗺️</span>
                        </div>

                        <!-- Langkah 2: Koridor Bebas Hambatan -->
                        <div class="flex items-start gap-4 rounded-2xl border border-[#f0e8e5] bg-white p-4 sm:p-5 shadow-sm transition hover:border-red-200">
                            <span class="flex shrink-0 h-10 w-10 items-center justify-center rounded-xl bg-[#dc2626] text-white text-base font-extrabold shadow-sm">2</span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900">Jaga Koridor &amp; Pintu Keluar Selalu Bebas Hambatan</h3>
                                <p class="mt-1 text-xs text-[#5c4f4c] leading-relaxed">Jangan pernah menumpuk kardus, jemuran baju, tumpukan koran, atau perabotan besar di lorong sempit dan di depan pintu keluar darurat. Jalur harus cukup lapang untuk dilewati dalam kondisi gelap gulita.</p>
                            </div>
                            <span class="flex shrink-0 text-2xl text-[#c41621]" aria-hidden="true">🧹</span>
                        </div>

                        <!-- Langkah 3: Kunci di Tempat Terjangkau -->
                        <div class="flex items-start gap-4 rounded-2xl border border-[#f0e8e5] bg-white p-4 sm:p-5 shadow-sm transition hover:border-red-200">
                            <span class="flex shrink-0 h-10 w-10 items-center justify-center rounded-xl bg-[#dc2626] text-white text-base font-extrabold shadow-sm">3</span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900">Gantung Kunci Pintu di Lokasi Tetap yang Mudah Dijangkau</h3>
                                <p class="mt-1 text-xs text-[#5c4f4c] leading-relaxed">Banyak korban terjebak karena pintu terkunci dan kunci hilang di kegelapan. Selalu gantung kunci pintu utama dan gembok teralis pada gantungan dekat pintu, pada ketinggian yang bisa dijangkau anak-anak dan lansia.</p>
                            </div>
                            <span class="flex shrink-0 text-2xl text-[#c41621]" aria-hidden="true">🔑</span>
                        </div>

                        <!-- Langkah 4: Titik Kumpul Aman -->
                        <div class="flex items-start gap-4 rounded-2xl border border-[#f0e8e5] bg-white p-4 sm:p-5 shadow-sm transition hover:border-red-200">
                            <span class="flex shrink-0 h-10 w-10 items-center justify-center rounded-xl bg-[#dc2626] text-white text-base font-extrabold shadow-sm">4</span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900">Tetapkan Titik Kumpul Aman di Luar Rumah (Assembly Point)</h3>
                                <p class="mt-1 text-xs text-[#5c4f4c] leading-relaxed">Sepakati lokasi pertemuan di luar rumah dengan jarak aman dari kobaran api (misalnya: tiang lampu seberang jalan, pohon tertentu, atau halaman tetangga). Ini memudahkan memastikan seluruh anggota keluarga sudah keluar dengan selamat.</p>
                            </div>
                            <span class="flex shrink-0 text-2xl text-[#c41621]" aria-hidden="true">🚩</span>
                        </div>

                        <!-- Langkah 5: Teknik Merangkak di Bawah Asap -->
                        <div class="flex items-start gap-4 rounded-2xl border border-[#f0e8e5] bg-white p-4 sm:p-5 shadow-sm transition hover:border-red-200">
                            <span class="flex shrink-0 h-10 w-10 items-center justify-center rounded-xl bg-[#dc2626] text-white text-base font-extrabold shadow-sm">5</span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900">Merangkak Rendah Saat Asap Tebal (Crawl Low Under Smoke)</h3>
                                <p class="mt-1 text-xs text-[#5c4f4c] leading-relaxed">Asap panas dan gas monoksida beracun selalu membubung ke atas plafon. Lapisan udara yang masih kaya oksigen dan sejuk berada di ketinggian 30–60 cm dari lantai. Merangkaklah dengan lutut dan siku sambil menutup hidung.</p>
                            </div>
                            <span class="flex shrink-0 text-2xl text-[#c41621]" aria-hidden="true">🧎</span>
                        </div>
                    </section>

                    <!-- Latihan Rutin Bersama Keluarga -->
                    <section class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm space-y-3">
                        <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <span class="text-lg">👨‍👩‍👧‍👦</span>
                            <span>Latihan Simulasi Evakuasi Rutin (Home Fire Drill)</span>
                        </h2>
                        <p class="text-xs text-[#5c4f4c] leading-relaxed">
                            Rencana evakuasi tidak akan bekerja bila anggota keluarga panik. Lakukan simulasi sederhana bersama seluruh penghuni rumah setiap <b>6 bulan sekali</b>:
                        </p>
                        <ul class="space-y-1.5 list-disc list-inside text-xs text-[#5c4f4c] leading-relaxed">
                            <li>Latih anak-anak untuk mengenali bunyi alarm kebakaran atau teriakan peringatan "Kebakaran!".</li>
                            <li>Tentukan siapa yang bertanggung jawab membantu lansia, balita, atau anggota keluarga disabilitas keluar rumah.</li>
                            <li>Latih cara membuka jendela dan pintu gerbang dalam kondisi mata tertutup atau lampu padam.</li>
                        </ul>
                    </section>

                </div>

                <!-- Kolom Kanan: Aturan Emas Keselamatan & Hotline (4 cols on lg) -->
                <div class="lg:col-span-5 xl:col-span-4 space-y-6">

                    <!-- Aturan Emas Penyelamatan Jiwa -->
                    <section class="rounded-2xl border border-red-200 bg-[#fef7f7] p-5 shadow-sm space-y-3">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-[#bd101b] flex items-center gap-1.5">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z"/></svg>
                            <span>3 ATURAN EMAS KESELAMATAN JIWA</span>
                        </h3>
                        <div class="space-y-2.5 text-xs text-[#792429]">
                            <div class="rounded-xl bg-white/80 p-3 border border-red-100">
                                <p class="font-bold text-red-700">1. Sekali Keluar, Jangan Kembali Masuk!</p>
                                <p class="mt-0.5 text-[11px] text-slate-600 leading-relaxed">Jangan pernah masuk kembali ke rumah yang terbakar untuk mengambil surat penting, perhiasan, atau hewan peliharaan. Biarkan petugas Damkar yang terlatih melakukannya.</p>
                            </div>
                            <div class="rounded-xl bg-white/80 p-3 border border-red-100">
                                <p class="font-bold text-red-700">2. Raba Pintu Sebelum Dibuka</p>
                                <p class="mt-0.5 text-[11px] text-slate-600 leading-relaxed">Gunakan punggung tangan untuk meraba daun pintu dan gagang pintu. Bila terasa hangat atau panas, <b>jangan buka</b> karena kobaran api dan gas bertekanan ada di baliknya. Gunakan jalur alternatif.</p>
                            </div>
                            <div class="rounded-xl bg-white/80 p-3 border border-red-100">
                                <p class="font-bold text-red-700">3. Bila Terjebak di Kamar Lantai Atas</p>
                                <p class="mt-0.5 text-[11px] text-slate-600 leading-relaxed">Tutup rapat pintu kamar dan sumpal celah bawah pintu dengan kain/sprei basah agar asap tidak masuk. Buka jendela dan lambaikan kain warna terang sambil berteriak minta tolong.</p>
                            </div>
                        </div>
                    </section>

                    <!-- Hotline 112 Card -->
                    <div class="rounded-2xl border border-[#cfe1f5] bg-[#edf5fc] p-5 shadow-sm">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#0064ad] text-white">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Terjadi Kebakaran di Rumah / Tetangga?</p>
                                <p class="text-[11px] text-slate-600">Hubungi 112 Damkar Palembang segera.</p>
                            </div>
                        </div>
                        <a href="tel:112" class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#0064ad] hover:bg-[#00518c] px-4 py-2.5 text-xs font-bold text-white shadow transition">
                            <span>Panggil Darurat 112 (Bebas Pulsa)</span>
                        </a>
                    </div>

                    <!-- Tombol Kembali ke Edukasi -->
                    <a href="{{ route('edukasi.index') }}" class="flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 px-4 py-3 text-xs font-bold text-slate-700 transition shadow-sm">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m15 19-7-7 7-7"/></svg>
                        <span>Kembali ke Daftar Edukasi</span>
                    </a>

                </div>

            </div>

            <!-- Sumber Referensi Resmi -->
            <div class="mt-8 rounded-xl border border-slate-100 bg-slate-50/80 p-3.5 text-center text-[11px] text-slate-500">
                <span class="font-semibold text-slate-600">Sumber Referensi:</span> Badan Nasional Penanggulangan Bencana (BNPB) - Buku Saku Siaga Bencana Kebakaran Rumah Tangga, NFPA (National Fire Protection Association) Escape Planning Standard, dan Dinas Pemadam Kebakaran dan Penyelamatan RI.
            </div>

            </div>
        </main>

        <!-- Desktop Footer -->
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

        <!-- Bottom Navigation Bar (Mobile) -->
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
                <a href="{{ route('edukasi.index') }}" aria-current="page" class="flex flex-col items-center gap-0.5 text-[#bd101b]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span class="text-[10px] font-bold">Edukasi</span>
                </a>
            </div>
        </nav>

    </div>
</body>
</html>
