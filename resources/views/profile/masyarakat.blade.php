<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP Damkar — Profil Masyarakat</title>
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
                        <span class="block text-xl font-semibold tracking-tight text-[#292626]">Profil Masyarakat</span>
                    </span>
                </a>
            </div>
        </header>

        <main class="flex-1 space-y-5 px-5 pb-6 pt-4 sm:px-7">

            <!-- Identitas Sesi / Perangkat -->
            <section aria-labelledby="identitas-title" class="rounded-xl bg-white p-4 shadow-[0_3px_12px_rgba(65,45,40,0.04)]">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <h2 id="identitas-title" class="text-sm font-bold">Identitas Sesi &amp; Perangkat</h2>
                    <span class="inline-flex items-center gap-1 rounded-full bg-[#f2f0ef] px-2.5 py-1 text-[10px] font-medium text-[#5c4f4c]"><span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>Akses Publik</span>
                </div>
                <p class="text-[11px] text-[#766965] mb-3">Anda mengakses sebagai warga publik tanpa login. ID berikut bersifat lokal di perangkat ini dan berguna sebagai referensi pelapor laporan kebakaran.</p>

                <div class="space-y-2.5">
                    <div class="flex items-center gap-2 rounded-lg border border-[#f3eeeb] bg-[#f2f0ef] px-3 py-2">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-[#eef0ed] text-[#9a3026]">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2Zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9Z"/></svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold text-[#292626]">ID Sesi (Server)</p>
                            <p class="text-[11px] text-[#766965] truncate" id="id-sesi">{{ $idSesi }}</p>
                        </div>
                        <button type="button" onclick="salinTeks('id-sesi')" class="text-[10px] font-bold text-[#c41621] hover:underline">Salin</button>
                    </div>

                    <div class="flex items-center gap-2 rounded-lg border border-[#f3eeeb] bg-[#f2f0ef] px-3 py-2">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-[#eef0ed] text-[#9a3026]">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4Z"/></svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold text-[#292626]">ID Perangkat (Lokal)</p>
                            <p class="text-[11px] text-[#766965] truncate" id="id-perangkat">Memuat…</p>
                        </div>
                        <button type="button" onclick="salinTeks('id-perangkat')" class="text-[10px] font-bold text-[#c41621] hover:underline">Salin</button>
                    </div>
                </div>
            </section>

            <!-- Panduan Penggunaan Sistem Lapor -->
            <section aria-labelledby="panduan-title" class="rounded-xl bg-white p-4 shadow-[0_3px_12px_rgba(65,45,40,0.04)]">
                <h2 id="panduan-title" class="text-sm font-bold">Panduan Penggunaan Sistem Lapor</h2>
                <p class="mt-1 text-[11px] text-[#766965]">Panduan singkat bagi warga dalam menggunakan sistem pelaporan kebakaran SIGAP Damkar.</p>
                <ol class="mt-3 space-y-3 list-decimal list-inside text-[12px] text-[#5c4f4c]">
                    <li>
                        <b>Laporkan kebakaran.</b> Masuk ke halaman <b>Laporan</b> di navigasi bawah, ketuk titik kejadian di peta (atau gunakan GPS), isi alamat dan nomor telepon, lalu kirim laporan.
                    </li>
                    <li>
                        <b>Pantau status.</b> Buka <b>Laporan Saya</b> untuk melihat progres penanganan petugas (diterima → verifikasi → meluncur → penanganan → selesai).
                    </li>
                    <li>
                        <b>Lacak armada.</b> Saat petugas ditugaskan, gunakan tombol <b>Lacak Armada</b> untuk melihat posisi unit damkar menuju lokasi Anda.
                    </li>
                    <li>
                        <b>Darurat?</b> Hubungi <b>Hotline 113 Damkar</b> (bebas pulsa, respons tanggap) yang tersedia di halaman <b>Beranda</b>.
                    </li>
                    <li>
                        <b>Simpan kontak default.</b> Di halaman ini, isi nama dan telepon Anda sebagai kontak default. Data hanya tersimpan di perangkat Anda (lokal), tidak dikirim ke server, dan akan diisi ulang otomatis saat membuat laporan baru.
                    </li>
                </ol>
            </section>

            <!-- Form Isian Data Diri Statis / Lokal -->
            <section aria-labelledby="kontak-title" class="rounded-xl bg-white p-4 shadow-[0_3px_12px_rgba(65,45,40,0.04)]">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <h2 id="kontak-title" class="text-sm font-bold">Kontak Default Pelapor (Lokal)</h2>
                    <span id="status-kontak" class="hidden inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-[10px] font-bold text-white bg-[#1c7a3a]"><span class="h-1.5 w-1.5 rounded-full bg-white"></span>Disimpan di perangkat</span>
                </div>
                <p class="mt-1 text-[11px] text-[#766965]">Isi kontak default Anda. Data hanya disimpan di browser perangkat ini (localStorage), <b>tidak</b> dikirim ke server, dan akan diisi ulang otomatis di formulir laporan kebakaran.</p>

                <form id="form-kontak-default" class="mt-3 space-y-3" novalidate>
                    <div>
                        <label for="kontak-nama" class="block text-[11px] font-bold text-[#5c4f4c] uppercase mb-1">Nama Lengkap</label>
                        <input type="text" id="kontak-nama" name="nama" placeholder="Contoh: Budi Santoso" class="w-full p-2.5 text-sm bg-[#f2f0ef] border border-[#f3eeeb] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c41621]">
                    </div>
                    <div>
                        <label for="kontak-telepon" class="block text-[11px] font-bold text-[#5c4f4c] uppercase mb-1">Nomor Telepon</label>
                        <input type="tel" id="kontak-telepon" name="telepon" inputmode="tel" placeholder="08xxxxxxxxxx" class="w-full p-2.5 text-sm bg-[#f2f0ef] border border-[#f3eeeb] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c41621]">
                    </div>
                    <div>
                        <label for="kontak-alamat" class="block text-[11px] font-bold text-[#5c4f4c] uppercase mb-1">Alamat Domisili</label>
                        <textarea id="kontak-alamat" name="alamat" rows="2" placeholder="Contoh: Jalan Sudirman No. 10, Ilir Timur I, Palembang" class="w-full p-2.5 text-sm bg-[#f2f0ef] border border-[#f3eeeb] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c41621] resize-none"></textarea>
                    </div>
                    <button type="button" onclick="simpanKontakDefault()" class="w-full py-3 bg-[#c41621] hover:bg-[#a90d25] text-white font-bold rounded-full text-sm transition shadow-md shadow-red-900/15">Simpan Kontak Default</button>
                </form>

                <div id="ringkasan-kontak" class="hidden mt-3 rounded-lg border border-[#e3ecf7] bg-[#f8fafc] p-3">
                    <p class="text-[9px] font-bold uppercase tracking-wide text-[#494442]">Kontak default yang tersimpan (lokal)</p>
                    <p id="tampilan-nama" class="text-[12px] font-semibold text-[#292626]"></p>
                    <p id="tampilan-telepon" class="text-[12px] text-[#766965]"></p>
                    <p id="tampilan-alamat" class="text-[12px] text-[#766965]"></p>
                    <button type="button" onclick="hapusKontakDefault()" class="mt-2 text-[10px] font-bold text-[#c41621] hover:underline">Hapus kontak tersimpan</button>
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
            <a href="{{ route('masyarakat.profile') }}" aria-current="page" class="flex flex-col items-center gap-0.5 text-[#bd101b]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2H4Z"/></svg><span class="text-[10px] font-bold">Profil</span>
            </a>
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

                // Scroll ringkasan ke tampilan
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
