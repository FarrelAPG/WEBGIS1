<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP Damkar — Lapor Kebakaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
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
                            <span class="block text-xl sm:text-2xl font-bold tracking-tight text-[#bd101b]">Lapor Kebakaran</span>
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
                    <a href="{{ route('masyarakat.profile') }}" class="h-9 w-9 sm:h-10 sm:w-10 overflow-hidden rounded-full border-2 border-[#e7b5ae] bg-white p-0.5 transition hover:ring-2 hover:ring-[#c41621]/30" aria-label="Profil">
                        <img src="{{ asset('images/avatar.svg') }}" alt="Foto profil" class="h-full w-full rounded-full object-cover">
                    </a>
                </div>
            </div>
        </header>

        <main class="flex-1 w-full">
            <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-5 sm:py-7 space-y-6">

            <!-- Alert Peringatan Kondisi Darurat -->
            <div class="rounded-2xl border border-red-200 bg-red-50 p-4 flex items-start gap-3 text-red-800 text-xs sm:text-sm shadow-sm">
                <span class="text-xl leading-none shrink-0">⚠️</span>
                <p><span class="font-bold">Laporkan situasi kebakaran nyata.</span> Titik koordinat GPS dan rincian yang Anda kirim akan langsung diproses oleh Command Center Damkar 112 Kota Palembang untuk penugasan pos terdekat.</p>
            </div>

            <!-- Formulir Pelaporan Kebakaran (2 Kolom di Desktop) -->
            <form action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Hidden Input GPS -->
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                    <!-- Kolom Kiri: Peta Pemilihan Titik Kebakaran (7 atau 8 cols on lg) -->
                    <div class="lg:col-span-7 xl:col-span-7 space-y-4">
                        <div class="rounded-2xl border border-[#f0e8e5] bg-white p-4 sm:p-5 shadow-sm space-y-3">
                            <div class="flex items-center justify-between gap-2 border-b border-slate-100 pb-3">
                                <span class="text-sm font-bold text-slate-900 flex items-center gap-1.5">
                                    <span class="text-red-500">📍</span> Titik Lokasi Kebakaran
                                </span>
                                <span id="gps-status" role="status" aria-live="polite" class="text-[10px] bg-gray-200 text-gray-600 px-2.5 py-0.5 rounded-full font-bold">Belum dipilih</span>
                            </div>

                            <p class="text-xs text-[#766965]">Ketuk peta tepat pada titik kebakaran, atau gunakan tombol GPS. Pin penanda dapat digeser untuk penyesuaian posisi presisi.</p>

                            <!-- Peta Interaktif Leaflet -->
                            <div class="relative overflow-hidden rounded-xl border border-slate-200">
                                <div id="map" class="h-72 sm:h-96 lg:h-[460px] w-full z-0"></div>

                                <button type="button" id="btn-gps"
                                        class="absolute bottom-3 right-3 z-[500] flex items-center gap-1.5 rounded-full bg-white px-4 py-2 text-xs font-bold text-[#bd101b] shadow-lg ring-1 ring-black/10 transition hover:bg-red-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 disabled:opacity-70">
                                    <svg id="gps-icon" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path stroke-linecap="round" d="M12 2v3m0 14v3M2 12h3m14 0h3"/><circle cx="12" cy="12" r="7"/></svg>
                                    <span id="gps-label">Lokasi saya</span>
                                </button>

                                <div id="peta-hint" class="pointer-events-none absolute left-1/2 top-3 z-[500] -translate-x-1/2 rounded-full bg-gray-900/80 px-3.5 py-1.5 text-[11px] font-semibold text-white shadow backdrop-blur">
                                    Ketuk peta untuk menaruh pin kejadian
                                </div>
                            </div>

                            <!-- Pesan GPS (error / bantuan) -->
                            <div id="gps-pesan" role="alert" class="hidden rounded-xl border border-amber-200 bg-amber-50 px-3.5 py-2.5 text-xs font-medium text-amber-800"></div>

                            <!-- Bantuan saat izin lokasi diblokir -->
                            <div id="izin-bantuan" class="hidden rounded-xl border border-red-200 bg-red-50 p-4 space-y-2">
                                <p class="text-xs font-bold text-red-700">Izin lokasi diblokir di browser</p>
                                <p class="text-xs text-red-700/90">Browser memblokir deteksi GPS. Anda dapat mengizinkannya lewat pengaturan browser atau cukup ketuk titik kejadian pada peta di atas.</p>
                                <ol id="izin-langkah" class="list-decimal space-y-1 pl-4 text-xs text-gray-700"></ol>
                                <p id="izin-inapp" class="hidden text-xs font-semibold text-red-700">Anda membuka halaman ini dari aplikasi lain. Buka lewat browser Chrome/Safari.</p>
                                <button type="button" id="btn-izin-coba" class="w-full rounded-full bg-[#bd101b] py-2 text-xs font-bold text-white hover:bg-[#a00e17]">Sudah diizinkan, coba lagi</button>
                            </div>

                            <p id="koordinat-info" class="hidden text-xs font-mono font-medium text-slate-500"></p>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Rincian Form & Submit (5 cols on lg) -->
                    <div class="lg:col-span-5 xl:col-span-5 space-y-4">

                        <!-- Alamat & Telepon -->
                        <div class="rounded-2xl border border-[#f0e8e5] bg-white p-5 shadow-sm space-y-4">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 border-b border-slate-100 pb-2">Informasi Kejadian &amp; Pelapor</h3>

                            <div class="space-y-1.5">
                                <label for="alamat" class="text-xs font-bold text-[#5c4f4c] uppercase tracking-wider">Alamat Kejadian <span class="text-red-500">*</span></label>
                                <textarea name="alamat" id="alamat" rows="2" required placeholder="Alamat otomatis terisi setelah lokasi dipilih di peta. Dapat Anda lengkapi." class="w-full p-3 text-sm bg-[#faf8f7] border border-[#f0e8e5] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#bd101b] resize-none transition"></textarea>
                                <p id="alamat-info" class="hidden text-[11px] text-slate-500"></p>
                            </div>

                            <div class="space-y-1.5">
                                <label for="nomor_telepon" class="text-xs font-bold text-[#5c4f4c] uppercase tracking-wider">Nomor Telepon / HP Pelapor <span class="text-red-500">*</span></label>
                                <input type="text" id="nomor_telepon" name="nomor_telepon" required placeholder="08xxxxxxxxxx" class="w-full p-3 text-sm bg-[#faf8f7] border border-[#f0e8e5] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#bd101b] transition">
                                <p class="text-[11px] text-slate-400">Petugas command center akan menghubungi nomor ini untuk konfirmasi cepat.</p>
                            </div>
                        </div>

                        <!-- Foto Bukti Lapangan -->
                        <div class="rounded-2xl border border-[#f0e8e5] bg-white p-5 shadow-sm space-y-3">
                            <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                                    <span>📷</span> Foto Kejadian
                                </span>
                                <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-500">Opsional</span>
                            </div>

                            <div class="flex items-center gap-4">
                                <label class="cursor-pointer bg-red-50 hover:bg-red-100 border-2 border-dashed border-red-200 text-[#bd101b] rounded-2xl p-4 flex flex-col items-center justify-center w-28 h-28 transition shrink-0">
                                    <span class="text-2xl">📸</span>
                                    <span class="text-[11px] font-bold mt-1 text-center leading-tight">Unggah Foto</span>
                                    <span class="text-[9px] text-slate-400 mt-0.5">Maks 4 MB</span>
                                    <input type="file" name="foto" id="input-foto" accept="image/*" class="hidden" onchange="previewImage(event)">
                                </label>

                                <div id="image-preview" class="hidden relative w-28 h-28 rounded-2xl overflow-hidden border border-slate-200 shadow-sm shrink-0">
                                    <img id="preview-img" alt="Pratinjau foto kejadian" class="w-full h-full object-cover">
                                </div>

                                <p class="text-xs text-[#766965] leading-relaxed">
                                    Foto membantu komandan regu memperkirakan jumlah armada damkar dan jenis zat pemadam yang diperlukan ke lokasi.
                                </p>
                            </div>
                        </div>

                        <!-- Keterangan Tambahan -->
                        <div class="rounded-2xl border border-[#f0e8e5] bg-white p-5 shadow-sm space-y-2">
                            <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                                    <span>📝</span> Keterangan Tambahan
                                </span>
                                <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-500">Opsional</span>
                            </div>
                            <textarea name="keterangan" rows="3" placeholder="Contoh: Asap tebal dari lantai 2 ruko, ada korban atau barang mudah meledak..." class="w-full p-3 text-xs sm:text-sm bg-[#faf8f7] border border-[#f0e8e5] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#bd101b] resize-none transition"></textarea>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit" class="w-full py-4 bg-[#bd101b] hover:bg-[#a00e17] text-white font-extrabold rounded-full shadow-lg shadow-red-900/25 text-sm tracking-wide flex items-center justify-center space-x-2 transition cursor-pointer">
                            <span>🚨</span>
                            <span>KIRIM LAPORAN SEKARANG</span>
                        </button>

                    </div>

                </div>
            </form>

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
                <a href="{{ route('masyarakat.profile') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2H4Z"/></svg>
                    <span class="text-[10px] font-bold">Profil</span>
                </a>
            </div>
        </nav>

    </div>

    <script>
        // ===== Pilih lokasi: ketuk peta + GPS =====
        const DEFAULT_PUSAT = [-2.9761, 104.7754]; // Palembang. Hanya pusat awal peta, BUKAN lokasi laporan
        const map = L.map('map', { zoomControl: true }).setView(DEFAULT_PUSAT, 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap',
        }).addTo(map);

        setTimeout(() => map.invalidateSize(), 300);

        const el = id => document.getElementById(id);
        const inputLat = el('latitude');
        const inputLng = el('longitude');
        const inputAlamat = el('alamat');
        const gpsStatus = el('gps-status');
        const gpsPesan = el('gps-pesan');
        const btnGps = el('btn-gps');
        const gpsLabel = el('gps-label');
        const hint = el('peta-hint');
        const koordInfo = el('koordinat-info');
        const alamatInfo = el('alamat-info');

        let marker = null;       // baru dibuat setelah lokasi dipilih
        let lingkaranAkurasi = null;
        let nomorGeocode = 0;    // cegah hasil alamat lama menimpa lokasi yang lebih baru
        let geocodeCtrl = null;

        function setStatus(teks, warna) {
            const palet = {
                abu:   'bg-gray-200 text-gray-600',
                biru:  'bg-blue-100 text-blue-700',
                hijau: 'bg-green-100 text-green-700',
                kuning:'bg-amber-100 text-amber-700',
            };
            gpsStatus.textContent = teks;
            gpsStatus.className = 'text-[10px] px-2.5 py-0.5 rounded-full font-bold ' + (palet[warna] || palet.abu);
        }

        function tampilPesan(teks) {
            if (!teks) { gpsPesan.classList.add('hidden'); gpsPesan.textContent = ''; return; }
            gpsPesan.textContent = teks;
            gpsPesan.classList.remove('hidden');
        }

        function setTombolGps(sedangMencari) {
            btnGps.disabled = sedangMencari;
            gpsLabel.textContent = sedangMencari ? 'Mencari GPS…' : 'Lokasi saya';
            el('gps-icon').classList.toggle('animate-pulse', sedangMencari);
        }

        // Taruh / pindahkan pin, isi koordinat, lalu cari alamatnya
        function pilihTitik(lat, lng, opsi = {}) {
            lat = Number(lat.toFixed(7));
            lng = Number(lng.toFixed(7));

            if (!marker) {
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                marker.on('dragend', () => {
                    const c = marker.getLatLng();
                    hapusAkurasi();
                    pilihTitik(c.lat, c.lng, { sumber: 'manual' });
                });
            } else {
                marker.setLatLng([lat, lng]);
            }

            inputLat.value = lat;
            inputLng.value = lng;
            hint.classList.add('hidden');
            koordInfo.textContent = 'Koordinat: ' + lat.toFixed(5) + ', ' + lng.toFixed(5);
            koordInfo.classList.remove('hidden');

            if (opsi.sumber === 'gps') {
                const m = Math.round(opsi.akurasi || 0);
                setStatus('GPS aktif' + (m ? ' ±' + m + ' m' : ''), 'hijau');
            } else {
                setStatus('Dipilih di peta', 'biru');
            }

            cariAlamat(lat, lng);
        }

        function hapusAkurasi() {
            if (lingkaranAkurasi) { map.removeLayer(lingkaranAkurasi); lingkaranAkurasi = null; }
        }

        // Alamat dari koordinat (Nominatim). Gagal/lambat tidak memblokir laporan.
        function cariAlamat(lat, lng) {
            const giliran = ++nomorGeocode;
            if (geocodeCtrl) geocodeCtrl.abort();
            geocodeCtrl = new AbortController();

            inputAlamat.placeholder = 'Mencari alamat…';
            alamatInfo.classList.add('hidden');

            fetch('https://nominatim.openstreetmap.org/reverse?format=jsonv2&accept-language=id&zoom=18&lat=' + lat + '&lon=' + lng,
                  { signal: geocodeCtrl.signal })
                .then(r => { if (!r.ok) throw new Error('http ' + r.status); return r.json(); })
                .then(data => {
                    if (giliran !== nomorGeocode) return;
                    if (data && data.display_name) {
                        inputAlamat.value = data.display_name;
                        alamatInfo.textContent = 'Alamat diisi otomatis dari peta. Tambahkan patokan (nama gedung, RT/RW) bila perlu.';
                    } else {
                        isiAlamatCadangan(lat, lng);
                    }
                    alamatInfo.classList.remove('hidden');
                })
                .catch(err => {
                    if (err.name === 'AbortError' || giliran !== nomorGeocode) return;
                    isiAlamatCadangan(lat, lng);
                });
        }

        function isiAlamatCadangan(lat, lng) {
            inputAlamat.value = 'Titik koordinat ' + lat.toFixed(5) + ', ' + lng.toFixed(5);
            alamatInfo.textContent = 'Alamat otomatis tidak tersedia. Mohon lengkapi alamat atau patokan terdekat.';
            alamatInfo.classList.remove('hidden');
        }

        // Ketuk peta = taruh pin di titik itu
        map.on('click', e => {
            hapusAkurasi();
            tampilPesan('');
            pilihTitik(e.latlng.lat, e.latlng.lng, { sumber: 'manual' });
        });

        // ---- Bantuan saat izin diblokir ----
        const izinBantuan = el('izin-bantuan');

        function tampilBantuanIzin(tampil) {
            if (!tampil) { izinBantuan.classList.add('hidden'); return; }

            const ua = navigator.userAgent;
            const ios = /iPhone|iPad|iPod/i.test(ua);
            const android = /Android/i.test(ua);
            const dalamApp = /FBAN|FBAV|Instagram|Line\/|WhatsApp|Telegram|TikTok|MicroMessenger|; wv\)/i.test(ua);

            let langkah;
            if (ios) {
                langkah = [
                    'Ketuk ikon <b>aA</b> di sebelah alamat, lalu <b>Pengaturan Situs Web</b>.',
                    'Ubah <b>Lokasi</b> menjadi <b>Izinkan</b> (atau <b>Tanya</b>).',
                    'Pastikan <b>Pengaturan iPhone → Privasi → Layanan Lokasi</b> menyala.',
                    'Kembali ke halaman ini lalu tekan tombol di bawah.',
                ];
            } else if (android) {
                langkah = [
                    'Ketuk ikon <b>pengaturan/gembok</b> di sebelah alamat (bagian atas).',
                    'Pilih <b>Izin</b> → <b>Lokasi</b> → <b>Izinkan</b>.',
                    'Pastikan <b>Lokasi</b> di panel notifikasi HP menyala.',
                    'Kembali ke halaman ini lalu tekan tombol di bawah.',
                ];
            } else {
                langkah = [
                    'Klik ikon <b>gembok</b> di sebelah alamat situs.',
                    'Ubah <b>Lokasi</b> menjadi <b>Izinkan</b>.',
                    'Muat ulang halaman, atau tekan tombol di bawah.',
                ];
            }
            el('izin-langkah').innerHTML = langkah.map(t => '<li>' + t + '</li>').join('');
            el('izin-inapp').classList.toggle('hidden', !dalamApp);
            izinBantuan.classList.remove('hidden');
        }

        function pesanErrorGps(err) {
            if (!window.isSecureContext) {
                return 'GPS hanya berfungsi di halaman HTTPS. Ketuk peta untuk memilih lokasi secara manual.';
            }
            switch (err.code) {
                case 2: return 'Posisi tidak terdeteksi. Pastikan GPS/lokasi HP menyala, atau ketuk peta untuk memilih lokasi.';
                case 3: return 'GPS terlalu lama merespons. Coba lagi, atau ketuk peta untuk memilih lokasi.';
                default: return 'GPS tidak bisa dipakai. Ketuk peta untuk memilih lokasi.';
            }
        }

        function pakaiGps(otomatis) {
            if (!navigator.geolocation) {
                setStatus('GPS tidak tersedia', 'kuning');
                tampilPesan('Perangkat ini tidak mendukung GPS. Ketuk peta untuk memilih lokasi.');
                return;
            }
            tampilPesan('');
            setTombolGps(true);
            setStatus('Mencari GPS…', 'biru');

            navigator.geolocation.getCurrentPosition(pos => {
                setTombolGps(false);
                tampilBantuanIzin(false);
                const { latitude, longitude, accuracy } = pos.coords;

                hapusAkurasi();
                lingkaranAkurasi = L.circle([latitude, longitude], {
                    radius: accuracy, color: '#2563eb', weight: 1, fillColor: '#3b82f6', fillOpacity: 0.12,
                }).addTo(map);

                map.setView([latitude, longitude], accuracy > 200 ? 16 : 18);
                pilihTitik(latitude, longitude, { sumber: 'gps', akurasi: accuracy });

                if (accuracy > 100) {
                    tampilPesan('Akurasi GPS rendah (±' + Math.round(accuracy) + ' m). Geser pin ke titik yang tepat sebelum mengirim.');
                }
            }, err => {
                setTombolGps(false);
                setStatus(marker ? 'Dipilih di peta' : 'Belum dipilih', marker ? 'biru' : 'kuning');

                if (err.code === 1 && window.isSecureContext) {
                    tampilBantuanIzin(true);
                } else {
                    tampilPesan(pesanErrorGps(err));
                }
            }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 });
        }

        btnGps.addEventListener('click', () => pakaiGps(false));
        el('btn-izin-coba').addEventListener('click', () => pakaiGps(false));

        function mulaiGps() {
            if (!navigator.permissions || !navigator.permissions.query) {
                pakaiGps(true);
                return;
            }
            navigator.permissions.query({ name: 'geolocation' }).then(status => {
                if (status.state === 'denied') {
                    setStatus('Izin lokasi diblokir', 'kuning');
                    tampilBantuanIzin(true);
                } else {
                    pakaiGps(true);
                }
                status.onchange = () => {
                    if (status.state === 'granted') {
                        tampilBantuanIzin(false);
                        pakaiGps(true);
                    } else if (status.state === 'denied') {
                        setStatus(marker ? 'Dipilih di peta' : 'Izin lokasi diblokir', marker ? 'biru' : 'kuning');
                    }
                };
            }).catch(() => pakaiGps(true));
        }

        const urlParams = new URLSearchParams(window.location.search);
        const qLat = parseFloat(urlParams.get('lat'));
        const qLng = parseFloat(urlParams.get('lng'));

        if (!isNaN(qLat) && !isNaN(qLng) && qLat !== 0 && qLng !== 0) {
            map.setView([qLat, qLng], 17);
            pilihTitik(qLat, qLng, { sumber: 'gps', akurasi: 15 });
        } else {
            mulaiGps();
        }

        document.querySelector('form').addEventListener('submit', function(e) {
            if (!inputLat.value || !inputLng.value) {
                e.preventDefault();
                tampilPesan('Tentukan titik kebakaran dulu: ketuk peta atau tekan "Lokasi saya".');
                el('map').scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }

            const inputFoto = document.getElementById('input-foto');
            if (inputFoto && inputFoto.files && inputFoto.files[0] && inputFoto.files[0].size > 4.2 * 1024 * 1024) {
                e.preventDefault();
                tampilPesan('Ukuran foto melebihi batas 4 MB server. Silakan pilih foto dengan resolusi lebih kecil.');
                return;
            }

            const tombolKirim = e.target.querySelector('button[type="submit"]');
            if (tombolKirim) {
                setTimeout(function () {
                    tombolKirim.disabled = true;
                    tombolKirim.classList.add('opacity-70', 'cursor-not-allowed');
                    const teks = tombolKirim.querySelectorAll('span')[1];
                    if (teks) teks.textContent = 'MENGIRIM LAPORAN...';
                }, 0);
            }
        });

        // Otomatis isi kontak default dari localStorage jika ada
        (function() {
            try {
                const data = JSON.parse(localStorage.getItem('sigap_kontak_default') || 'null');
                if (data) {
                    const inputTelp = document.getElementById('nomor_telepon');
                    if (inputTelp && !inputTelp.value && data.telepon) {
                        inputTelp.value = data.telepon;
                    }
                    if (data.alamat && !inputAlamat.value) {
                        inputAlamat.placeholder = 'Alamat domisili tersimpan: ' + data.alamat + ' (atau pilih titik peta)';
                    }
                }
            } catch (e) {}
        })();

        const inputTelp = document.querySelector('input[name="nomor_telepon"]');
        if (inputTelp) {
            inputTelp.setAttribute('inputmode', 'tel');
            inputTelp.addEventListener('input', function () {
                this.value = this.value.replace(/(?!^\+)[^0-9]/g, '');
            });
        }

        window.addEventListener('pageshow', function (e) {
            if (!e.persisted) return;
            const t = document.querySelector('form button[type="submit"]');
            if (t) {
                t.disabled = false;
                t.classList.remove('opacity-70', 'cursor-not-allowed');
                const teks = t.querySelectorAll('span')[1];
                if (teks) teks.textContent = 'KIRIM LAPORAN SEKARANG';
            }
        });

        function compressImage(file, maxDimension = 1600, quality = 0.75) {
            return new Promise((resolve) => {
                if (!file || !file.type.startsWith('image/')) {
                    resolve(file);
                    return;
                }
                const reader = new FileReader();
                reader.onerror = () => resolve(file);
                reader.onload = function(e) {
                    const img = new Image();
                    img.onerror = () => resolve(file);
                    img.onload = function() {
                        let { width, height } = img;
                        if (width > maxDimension || height > maxDimension) {
                            if (width > height) {
                                height = Math.round((height * maxDimension) / width);
                                width = maxDimension;
                            } else {
                                width = Math.round((width * maxDimension) / height);
                                height = maxDimension;
                            }
                        }
                        const canvas = document.createElement('canvas');
                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);
                        canvas.toBlob((blob) => {
                            if (!blob || blob.size >= file.size) {
                                resolve(file);
                                return;
                            }
                            const compressedFile = new File([blob], file.name.replace(/\.[^/.]+$/, '') + '.jpg', {
                                type: 'image/jpeg',
                                lastModified: Date.now()
                            });
                            resolve(compressedFile);
                        }, 'image/jpeg', quality);
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        }

        async function previewImage(event) {
            const input = event.target;
            const file = input.files && input.files[0];
            if (!file) return;

            // Batas maksimal awal sebelum kompresi (misal file > 25 MB)
            if (file.size > 25 * 1024 * 1024) {
                alert('Ukuran foto terlalu besar. Silakan pilih foto dengan resolusi lebih kecil.');
                input.value = '';
                document.getElementById('image-preview').classList.add('hidden');
                return;
            }

            // Tampilkan preview foto langsung
            const previewImg = document.getElementById('preview-img');
            const previewContainer = document.getElementById('image-preview');
            previewImg.src = URL.createObjectURL(file);
            previewContainer.classList.remove('hidden');

            // Kompres otomatis gambar agar muat dalam batas 4.5 MB Vercel Serverless
            try {
                const compressedFile = await compressImage(file, 1600, 0.75);
                if (window.DataTransfer) {
                    const dt = new DataTransfer();
                    dt.items.add(compressedFile);
                    input.files = dt.files;
                }
            } catch (err) {
                console.warn('Gagal mengompres foto di browser:', err);
            }
        }
    </script>
</body>
</html>
