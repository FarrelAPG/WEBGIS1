<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP Damkar — Profil Masyarakat</title>
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
                            <span class="block text-xl sm:text-2xl font-bold tracking-tight text-[#292626]">Profil</span>
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
                    <a href="{{ route('masyarakat.profile') }}" class="h-9 w-9 sm:h-10 sm:w-10 overflow-hidden rounded-full border-2 border-[#c41621] bg-white p-0.5 ring-2 ring-[#c41621]/30 transition" aria-label="Profil">
                        <img src="{{ asset('images/avatar.svg') }}" alt="Foto profil" class="h-full w-full rounded-full object-cover">
                    </a>
                </div>
            </div>
        </header>

        <main class="flex-1 w-full">
            <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-5 sm:py-7 space-y-6">

            <!-- Judul Halaman -->
            <section aria-labelledby="profil-title" class="space-y-1">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <h1 id="profil-title" class="text-xl sm:text-2xl font-bold tracking-tight text-[#292626]">Profil &amp; Kontak Pelapor</h1>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#f2f0ef] px-2.5 py-1 text-[10px] font-bold text-[#5c4f4c]">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>Akses Publik Terbuka
                    </span>
                </div>
                <p class="text-sm text-[#766965]">Kelola data identitas lokal untuk kemudahan verifikasi saat lapor kebakaran</p>
            </section>

            <!-- Responsive Grid: 2 Kolom di Desktop (lg:) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                <!-- Kolom Kiri: Form Kontak Default (8 cols on lg) -->
                <div class="lg:col-span-7 xl:col-span-8 space-y-6">

                    <!-- Form Isian Data Diri Statis / Lokal -->
                    <section aria-labelledby="kontak-title" class="rounded-2xl border border-[#f0e8e5] bg-white p-5 sm:p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-2 border-b border-slate-100 pb-3 mb-4">
                            <div>
                                <h2 id="kontak-title" class="text-base font-bold text-slate-900">Kontak Default Pelapor (Lokal)</h2>
                                <p class="mt-0.5 text-xs text-[#766965]">Tersimpan aman di browser Anda dan terisi otomatis pada formulir laporan.</p>
                            </div>
                            <span id="status-kontak" class="hidden inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-[10px] font-bold text-white bg-[#1c7a3a] shrink-0">
                                <span class="h-1.5 w-1.5 rounded-full bg-white"></span>Tersimpan
                            </span>
                        </div>

                        <form id="form-kontak-default" class="space-y-4" novalidate>
                            <div>
                                <label for="kontak-nama" class="block text-xs font-bold text-[#5c4f4c] uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                                <input type="text" id="kontak-nama" name="nama" placeholder="Contoh: Budi Santoso" class="w-full p-3 text-sm bg-[#faf8f7] border border-[#f0e8e5] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#c41621] transition">
                            </div>
                            <div>
                                <label for="kontak-telepon" class="block text-xs font-bold text-[#5c4f4c] uppercase tracking-wider mb-1.5">Nomor Telepon / WhatsApp Aktif</label>
                                <input type="tel" id="kontak-telepon" name="telepon" inputmode="tel" placeholder="08xxxxxxxxxx" class="w-full p-3 text-sm bg-[#faf8f7] border border-[#f0e8e5] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#c41621] transition">
                            </div>
                            <div>
                                <label for="kontak-alamat" class="block text-xs font-bold text-[#5c4f4c] uppercase tracking-wider mb-1.5">Alamat Domisili Patokan</label>
                                <textarea id="kontak-alamat" name="alamat" rows="2" placeholder="Contoh: Jalan Sudirman No. 10, Ilir Timur I, Palembang" class="w-full p-3 text-sm bg-[#faf8f7] border border-[#f0e8e5] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#c41621] resize-none transition"></textarea>
                            </div>
                            <button type="button" onclick="simpanKontakDefault()" class="w-full py-3 bg-[#c41621] hover:bg-[#a90d25] text-white font-bold rounded-full text-sm transition shadow-md shadow-red-900/15">
                                Simpan Kontak Default
                            </button>
                        </form>

                        <div id="ringkasan-kontak" class="hidden mt-4 rounded-xl border border-[#e3ecf7] bg-[#f8fafc] p-4">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#494442] border-b border-slate-200 pb-1.5 mb-2">Kontak default yang tersimpan (di browser ini):</p>
                            <p id="tampilan-nama" class="text-sm font-bold text-[#292626]"></p>
                            <p id="tampilan-telepon" class="text-xs text-[#766965] mt-0.5"></p>
                            <p id="tampilan-alamat" class="text-xs text-[#766965] mt-0.5"></p>
                            <button type="button" onclick="hapusKontakDefault()" class="mt-3 text-xs font-bold text-[#c41621] hover:underline">Hapus kontak tersimpan</button>
                        </div>
                    </section>

                </div>

                <!-- Kolom Kanan: Sesi & Panduan Penggunaan (4 cols on lg) -->
                <div class="lg:col-span-5 xl:col-span-4 space-y-6">

                    <!-- Identitas Sesi / Perangkat -->
                    <section aria-labelledby="identitas-title" class="rounded-2xl border border-[#f0e8e5] bg-white p-5 shadow-sm space-y-3">
                        <div class="flex items-center justify-between gap-2 border-b border-slate-100 pb-2.5">
                            <h2 id="identitas-title" class="text-sm font-bold text-slate-900">Identitas Perangkat</h2>
                            <span class="rounded bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-600">Publik</span>
                        </div>
                        <p class="text-xs text-[#766965]">ID berikut bersifat unik di perangkat ini dan digunakan sebagai tanda pengenal saat Anda mengirim laporan tanpa akun.</p>

                        <div class="space-y-2.5">
                            <div class="flex items-center justify-between gap-2 rounded-xl border border-[#f3eeeb] bg-[#f8f5f4] px-3.5 py-2.5">
                                <div class="min-w-0">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">ID Sesi Server</p>
                                    <p class="text-xs font-semibold text-[#292626] truncate" id="id-sesi">{{ $idSesi }}</p>
                                </div>
                                <button type="button" onclick="salinTeks('id-sesi')" class="shrink-0 text-xs font-bold text-[#c41621] hover:underline">Salin</button>
                            </div>

                            <div class="flex items-center justify-between gap-2 rounded-xl border border-[#f3eeeb] bg-[#f8f5f4] px-3.5 py-2.5">
                                <div class="min-w-0">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">ID Perangkat Lokal</p>
                                    <p class="text-xs font-semibold text-[#292626] truncate" id="id-perangkat">Memuat…</p>
                                </div>
                                <button type="button" onclick="salinTeks('id-perangkat')" class="shrink-0 text-xs font-bold text-[#c41621] hover:underline">Salin</button>
                            </div>
                        </div>
                    </section>

                    <!-- Panduan Penggunaan Sistem Lapor -->
                    <section aria-labelledby="panduan-title" class="rounded-2xl border border-[#f0e8e5] bg-white p-5 shadow-sm">
                        <h2 id="panduan-title" class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2.5">Panduan Pelaporan Warga</h2>
                        <ol class="mt-3 space-y-2.5 list-decimal list-inside text-xs text-[#5c4f4c] leading-relaxed">
                            <li>
                                <b>Laporkan Kebakaran:</b> Gunakan tombol SOS di Beranda atau tombol Buat Laporan, pilih titik peta / GPS, dan kirimkan.
                            </li>
                            <li>
                                <b>Pantau Status:</b> Cek <b>Laporan Saya</b> untuk mengetahui status penanganan real-time oleh petugas damkar.
                            </li>
                            <li>
                                <b>Lacak Armada:</b> Pantau pergerakan mobil damkar menuju lokasi Anda secara live.
                            </li>
                            <li>
                                <b>Darurat Eskalasi:</b> Hubungi <b>Hotline 112 Damkar</b> jika situasi api membesar seketika.
                            </li>
                        </ol>
                    </section>

                    <!-- Kartu Bantuan Darurat Hotline 112 -->
                    <div class="rounded-2xl border border-[#cfe1f5] bg-[#edf5fc] p-5 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#0064ad] text-white shadow-sm">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-[10px] font-extrabold uppercase tracking-wider text-[#0064ad]">Panggilan Siaga 24 Jam</p>
                                <h3 class="text-base font-bold text-slate-900 leading-tight">Hotline 112 Damkar</h3>
                                <p class="text-[11px] text-slate-500">Bebas Pulsa &amp; Respons Cepat</p>
                            </div>
                            <a href="tel:112" class="shrink-0 rounded-full bg-[#0064ad] hover:bg-[#00518c] px-4 py-2 text-xs font-bold text-white shadow transition">
                                Panggil
                            </a>
                        </div>
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
                        <a href="{{ route('laporan.saya') }}" class="hover:text-[#bd101b] transition">Laporan Saya</a>
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
                <a href="{{ route('laporan.saya') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6l1 2h4v15H4V6h4l1-2Zm1 6h4m-4 4h6m-6 4h6"/></svg>
                    <span class="text-[10px] font-bold">Laporan</span>
                </a>
                <a href="{{ route('masyarakat.profile') }}" aria-current="page" class="flex flex-col items-center gap-0.5 text-[#bd101b]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2H4Z"/></svg>
                    <span class="text-[10px] font-bold">Profil</span>
                </a>
            </div>
        </nav>

    </div>

    <script>
        (function () {
            const STORAGE_KEY = 'sigap_kontak_default';
            const DEVICE_KEY = 'sigap_device_id';

            // --- ID Perangkat (stabil per perangkat, disimpan lokal) ---
            function dapatkanIdPerangkat() {
                let id = localStorage.getItem(DEVICE_KEY);
                if (!id) {
                    id = 'dev-' + crypto.randomUUID().replace(/-/g, '').slice(0, 12);
                    try { localStorage.setItem(DEVICE_KEY, id); } catch (e) {}
                }
                return id;
            }

            const elPerangkat = document.getElementById('id-perangkat');
            if (elPerangkat) {
                elPerangkat.textContent = dapatkanIdPerangkat();
            }

            // --- Muat kontak default dari localStorage ---
            function muatKontak() {
                try {
                    const data = JSON.parse(localStorage.getItem(STORAGE_KEY) || 'null');
                    if (!data) return;
                    const elNama = document.getElementById('kontak-nama');
                    const elTelp = document.getElementById('kontak-telepon');
                    const elAlamat = document.getElementById('kontak-alamat');
                    const elRingkasan = document.getElementById('ringkasan-kontak');
                    const elStatus = document.getElementById('status-kontak');
                    const tNama = document.getElementById('tampilan-nama');
                    const tTelp = document.getElementById('tampilan-telepon');
                    const tAlamat = document.getElementById('tampilan-alamat');

                    if (elNama && data.nama) elNama.value = data.nama;
                    if (elTelp && data.telepon) elTelp.value = data.telepon;
                    if (elAlamat && data.alamat) elAlamat.value = data.alamat;

                    if (tNama) tNama.textContent = data.nama || '—';
                    if (tTelp) tTelp.textContent = data.telepon || '—';
                    if (tAlamat) tAlamat.textContent = data.alamat || '—';

                    if (elRingkasan) elRingkasan.classList.remove('hidden');
                    if (elStatus) elStatus.classList.remove('hidden');
                } catch (e) {}
            }

            // --- Simpan kontak default ke localStorage ---
            window.simpanKontakDefault = function () {
                const nama = document.getElementById('kontak-nama').value.trim();
                const telepon = document.getElementById('kontak-telepon').value.trim();
                const alamat = document.getElementById('kontak-alamat').value.trim();

                if (!nama && !telepon && !alamat) {
                    alert('Isi minimal satu field sebelum menyimpan.');
                    return;
                }

                const data = { nama, telepon, alamat, disimpan_pada: new Date().toISOString() };
                try {
                    localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
                } catch (e) {
                    alert('Gagal menyimpan ke penyimpanan lokal perangkat.');
                    return;
                }

                const elRingkasan = document.getElementById('ringkasan-kontak');
                const elStatus = document.getElementById('status-kontak');
                const tNama = document.getElementById('tampilan-nama');
                const tTelp = document.getElementById('tampilan-telepon');
                const tAlamat = document.getElementById('tampilan-alamat');

                if (tNama) tNama.textContent = nama || '—';
                if (tTelp) tTelp.textContent = telepon || '—';
                if (tAlamat) tAlamat.textContent = alamat || '—';
                if (elRingkasan) elRingkasan.classList.remove('hidden');
                if (elStatus) elStatus.classList.remove('hidden');

                elRingkasan?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            };

            // --- Hapus kontak default ---
            window.hapusKontakDefault = function () {
                try { localStorage.removeItem(STORAGE_KEY); } catch (e) {}
                document.getElementById('ringkasan-kontak')?.classList.add('hidden');
                document.getElementById('status-kontak')?.classList.add('hidden');
                document.getElementById('kontak-nama').value = '';
                document.getElementById('kontak-telepon').value = '';
                document.getElementById('kontak-alamat').value = '';
            };

            // --- Salin teks ke clipboard ---
            window.salinTeks = function (id) {
                const el = document.getElementById(id);
                if (!el) return;
                navigator.clipboard.writeText(el.textContent).then(function () {
                    const lama = el.textContent;
                    el.textContent = 'Disalin ✓';
                    setTimeout(function () { el.textContent = lama; }, 1200);
                });
            };

            muatKontak();
        })();
    </script>
</body>
</html>
