<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGAP - Lapor Kebakaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
</head>
<body class="bg-gray-100 min-h-screen flex justify-center sm:items-center sm:py-6">

    <div class="flex min-h-screen w-full max-w-md flex-col bg-white shadow-lg sm:min-h-0 sm:rounded-2xl sm:overflow-hidden">
        <!-- Header -->
        <div class="flex items-center p-4 border-b">
            <button onclick="history.back()" class="p-2 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <div class="ml-3 flex items-center space-x-2">
                <span class="p-2 bg-red-100 text-red-600 rounded-lg">
                    🔥
                </span>
                <div>
                    <h1 class="text-sm font-bold text-red-600 tracking-wide uppercase">SIGAP</h1>
                    <p class="text-xs font-semibold text-gray-700">LAPOR KEBAKARAN</p>
                </div>
            </div>
        </div>

        <!-- Alert Danger -->
        <div class="m-4 p-3 bg-red-50 border border-red-200 rounded-xl flex items-start space-x-3 text-red-700 text-xs">
            <span class="text-lg leading-none">⚠️</span>
            <p><span class="font-bold">Laporkan situasi nyata.</span> Lokasi dan waktu akan langsung ditransmisikan ke Pos Damkar terdekat secara otomatis.</p>
        </div>

        <form action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data" class="p-4 space-y-4 flex-1">
            @csrf

            <!-- Hidden Input GPS & Device ID -->
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            <input type="hidden" name="device_id" id="device_id">

            <!-- Lokasi Kebakaran -->
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-3 space-y-3">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs font-bold text-gray-800 flex items-center">
                        <span class="text-red-500 mr-1">📍</span> Lokasi Kebakaran
                    </span>
                    <span id="gps-status" role="status" aria-live="polite" class="text-[10px] bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full font-semibold">Belum dipilih</span>
                </div>

                <p class="text-[11px] text-gray-500 -mt-1">Ketuk peta di titik kejadian, atau pakai GPS. Pin bisa digeser untuk menyesuaikan.</p>

                <!-- Peta -->
                <div class="relative">
                    <div id="map" class="h-64 w-full rounded-lg border border-gray-200 z-0"></div>

                    <button type="button" id="btn-gps"
                            class="absolute bottom-3 right-3 z-[500] flex items-center gap-1.5 rounded-full bg-white px-3.5 py-2 text-xs font-bold text-red-600 shadow-lg ring-1 ring-black/10 transition hover:bg-red-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 disabled:opacity-70">
                        <svg id="gps-icon" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path stroke-linecap="round" d="M12 2v3m0 14v3M2 12h3m14 0h3"/><circle cx="12" cy="12" r="7"/></svg>
                        <span id="gps-label">Lokasi saya</span>
                    </button>

                    <div id="peta-hint" class="pointer-events-none absolute left-1/2 top-3 z-[500] -translate-x-1/2 rounded-full bg-gray-900/80 px-3 py-1.5 text-[11px] font-semibold text-white shadow">
                        Ketuk peta untuk menaruh pin
                    </div>
                </div>

                <!-- Pesan GPS (error / bantuan) -->
                <div id="gps-pesan" role="alert" class="hidden rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-[11px] font-medium text-amber-800"></div>

                <!-- Bantuan saat izin lokasi diblokir -->
                <div id="izin-bantuan" class="hidden rounded-lg border border-red-200 bg-red-50 px-3 py-3 space-y-2">
                    <p class="text-[12px] font-bold text-red-700">Izin lokasi diblokir di browser</p>
                    <p class="text-[11px] text-red-700/90">Browser tidak akan menampilkan permintaan izin lagi setelah ditolak. Izinkan manual lewat pengaturan situs:</p>
                    <ol id="izin-langkah" class="list-decimal space-y-1 pl-4 text-[11px] text-gray-700"></ol>
                    <p id="izin-inapp" class="hidden text-[11px] font-semibold text-red-700">Anda membuka halaman ini dari dalam aplikasi lain. Buka lewat Chrome atau Safari agar izin lokasi bisa diatur.</p>
                    <button type="button" id="btn-izin-coba" class="w-full rounded-lg bg-red-600 py-2 text-[12px] font-bold text-white hover:bg-red-700">Sudah diizinkan, coba lagi</button>
                    <p class="text-[10px] text-gray-500">Atau tetap bisa lapor: ketuk peta di titik kejadian.</p>
                </div>

                <p id="koordinat-info" class="hidden text-[11px] font-medium text-gray-500"></p>

                <div class="space-y-2">
                    <label for="alamat" class="text-[11px] font-bold text-gray-500 uppercase">Alamat kejadian</label>
                    <textarea name="alamat" id="alamat" rows="2" required placeholder="Alamat terisi otomatis setelah lokasi dipilih. Bisa Anda ubah." class="w-full p-2.5 text-sm bg-gray-100 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 resize-none"></textarea>
                    <p id="alamat-info" class="hidden text-[10px] text-gray-400"></p>
                </div>

                <div class="space-y-2">
                    <label for="nomor_telepon" class="text-[11px] font-bold text-gray-500 uppercase">Nomor telepon pelapor</label>
                    <input type="text" id="nomor_telepon" name="nomor_telepon" required placeholder="08xxxxxxxxxx" class="w-full p-2.5 text-sm bg-gray-100 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
            </div>

            <!-- Foto Bukti Lapangan -->
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-3 space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-xs font-bold text-gray-800 flex items-center">📷 Foto Bukti Lapangan</span>
                    <span class="text-[10px] text-gray-400">Opsional</span>
                </div>

                <div class="flex space-x-3 items-center">
                    <label class="cursor-pointer bg-red-50 border border-red-200 text-red-600 rounded-xl p-3 flex flex-col items-center justify-center w-24 h-24 hover:bg-red-100">
                        <span class="text-xl">📷</span>
                        <span class="text-[10px] font-bold mt-1">Ambil Foto</span>
                        <span class="text-[8px] text-gray-500">Geotag otomatis</span>
                        <input type="file" name="foto" accept="image/*" class="hidden" onchange="previewImage(event)">
                    </label>

                    <div id="image-preview" class="hidden relative w-24 h-24 rounded-xl overflow-hidden border">
                        <img id="preview-img" class="w-full h-full object-cover">
                    </div>
                </div>

                <p class="text-[10px] text-gray-400">Format JPG, PNG (Maks 10MB). Petugas dapat memperkirakan armada yang dibutuhkan lewat foto.</p>
            </div>

            <!-- Keterangan Singkat -->
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-3 space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-xs font-bold text-gray-800 flex items-center">📝 Keterangan Singkat</span>
                    <span class="text-[10px] text-gray-400">Info Penyelamatan</span>
                </div>
                <textarea name="keterangan" rows="3" placeholder="Contoh: Asap tebal membubung dari lantai 2, ada 4 orang penghuni terjebak di balkon belakang..." class="w-full p-2.5 text-xs bg-gray-100 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 resize-none"></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-full shadow-lg text-sm tracking-wide flex items-center justify-center space-x-2 transition sticky bottom-0 mt-6">
                <span>🚨</span> <span>KIRIM LAPORAN SEKARANG</span>
            </button>
        </form>
    </div>

    <script>
        // ===== Pilih lokasi: ketuk peta + GPS =====
        const DEFAULT_PUSAT = [-2.9761, 104.7754]; // Palembang. Hanya pusat awal peta, BUKAN lokasi laporan
        const map = L.map('map', { zoomControl: true }).setView(DEFAULT_PUSAT, 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap',
        }).addTo(map);

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
            gpsStatus.className = 'text-[10px] px-2 py-0.5 rounded-full font-semibold ' + (palet[warna] || palet.abu);
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
            // Alamat lama milik titik sebelumnya, jadi diganti agar tidak menyesatkan petugas
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
                    // Ditolak: browser tidak bisa dipaksa menampilkan popup izin lagi
                    tampilBantuanIzin(true);
                } else {
                    tampilPesan(pesanErrorGps(err));
                }
            }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 });
        }

        btnGps.addEventListener('click', () => pakaiGps(false));
        el('btn-izin-coba').addEventListener('click', () => pakaiGps(false));

        // Cek status izin lebih dulu: kalau sudah diblokir, jangan minta lagi (tidak akan muncul popup)
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
                    pakaiGps(true); // 'prompt' → popup izin muncul; 'granted' → langsung jalan
                }
                // Otomatis jalan begitu pengguna mengizinkan lewat pengaturan browser
                status.onchange = () => {
                    if (status.state === 'granted') {
                        tampilBantuanIzin(false);
                        pakaiGps(true);
                    } else if (status.state === 'denied') {
                        setStatus(marker ? 'Dipilih di peta' : 'Izin lokasi diblokir', marker ? 'biru' : 'kuning');
                    }
                };
            }).catch(() => pakaiGps(true)); // Safari lama: Permissions API tidak mendukung geolocation
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

        // Inisialisasi atau ambil Device ID unik khusus perangkat ini
        function dapatkanDeviceId() {
            const KEY = 'sigap_device_id';
            let devId = localStorage.getItem(KEY);
            if (!devId) {
                // Buat unique ID acak bila belum ada di perangkat ini
                devId = 'dev_' + Date.now().toString(36) + '_' + Math.random().toString(36).substring(2, 10);
                localStorage.setItem(KEY, devId);
            }
            // Simpan juga ke cookie agar controller Laravel dapat membaca langsung
            document.cookie = KEY + '=' + encodeURIComponent(devId) + '; path=/; max-age=31536000; SameSite=Lax';
            const inputDev = document.getElementById('device_id');
            if (inputDev) inputDev.value = devId;
            return devId;
        }
        dapatkanDeviceId();

        // Titik kebakaran wajib ditentukan sebelum laporan dikirim
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!inputLat.value || !inputLng.value) {
                e.preventDefault();
                tampilPesan('Tentukan titik kebakaran dulu: ketuk peta atau tekan "Lokasi saya".');
                el('map').scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }
            // Cegah klik ganda: tombol dikunci dan teksnya berubah selama laporan dikirim
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

        // Nomor telepon: hanya angka (dan tanda + di awal)
        const inputTelp = document.querySelector('input[name="nomor_telepon"]');
        if (inputTelp) {
            inputTelp.setAttribute('inputmode', 'tel');
            inputTelp.addEventListener('input', function () {
                this.value = this.value.replace(/(?!^\+)[^0-9]/g, '');
            });
        }

        // Aktifkan lagi tombol bila halaman dibuka lewat tombol "Kembali" browser
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

        // Image Preview Handler
        function previewImage(event) {
            const file = event.target.files[0];
            if (file && file.size > 10 * 1024 * 1024) {
                alert('Ukuran foto maksimal 10 MB. Pilih foto yang lebih kecil.');
                event.target.value = '';
                document.getElementById('image-preview').classList.add('hidden');
                return;
            }
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>