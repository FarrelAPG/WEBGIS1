<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP Damkar — Peta Pos Terdekat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
    <style>
        #public-map {
            height: 380px;
            width: 100%;
            z-index: 1;
        }
        @media (min-width: 640px) {
            #public-map {
                height: 420px;
            }
        }
        @media (min-width: 1024px) {
            #public-map {
                height: 480px;
            }
        }
        #public-map .leaflet-tile-container img {
            max-width: none !important;
            max-height: none !important;
        }

        /* Custom Scrollbar */
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: #f8fafc; border-radius: 9999px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Pulsing user location beacon */
        .user-pulse-container {
            position: relative;
            width: 24px;
            height: 24px;
        }
        .user-pulse-core {
            position: absolute;
            top: 4px;
            left: 4px;
            width: 16px;
            height: 16px;
            background-color: #2563eb;
            border: 3px solid #ffffff;
            border-radius: 9999px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.35);
        }
        .user-pulse-wave {
            position: absolute;
            top: -2px;
            left: -2px;
            width: 28px;
            height: 28px;
            background-color: rgba(37, 99, 235, 0.4);
            border-radius: 9999px;
            animation: user-wave 2s infinite ease-out;
        }
        @keyframes user-wave {
            0% {
                transform: scale(0.6);
                opacity: 1;
            }
            100% {
                transform: scale(2.4);
                opacity: 0;
            }
        }

        /* Custom Pos Damkar Pin */
        .pos-damkar-badge {
            background: linear-gradient(135deg, #e52329 0%, #bd101b 100%);
            color: #ffffff;
            width: 36px;
            height: 36px;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ffffff;
            box-shadow: 0 4px 10px rgba(189, 16, 27, 0.4);
            cursor: pointer;
            transition: transform 0.15s ease-in-out;
        }
        .pos-damkar-badge:hover {
            transform: rotate(-45deg) scale(1.12);
        }
        .pos-damkar-badge-icon {
            transform: rotate(45deg);
            font-size: 15px;
            line-height: 1;
        }

        /* Custom Leaflet Popup */
        .leaflet-popup-content-wrapper {
            border-radius: 1rem !important;
            padding: 0.25rem !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        }
        .leaflet-popup-content {
            margin: 0.75rem 0.85rem !important;
            line-height: 1.4 !important;
        }
    </style>
</head>
<body class="min-h-screen font-sans text-[#292626] antialiased sm:flex sm:justify-center sm:bg-gray-100">
    <div class="min-h-screen w-full max-w-2xl lg:max-w-6xl xl:max-w-7xl bg-[#fffaf8] shadow-[0_0_32px_rgba(75,35,35,0.06)] sm:shadow-xl flex flex-col justify-between">

        <!-- Top Header Bar (Masyarakat) -->
        <header class="sticky top-0 z-20 border-b border-[#f2e9e6] bg-[#fffaf8]/95 px-5 py-3 backdrop-blur">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <button type="button" onclick="history.back()" aria-label="Kembali" class="rounded-full p-1 text-[#473a38] transition hover:bg-[#f2e9e6]">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <a href="{{ route('peta') }}" aria-current="page" class="flex min-w-0 items-center gap-2.5">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-slate-100 bg-white p-2 shadow-sm">
                            <img src="{{ asset('images/sigap-logo.svg') }}" alt="SIGAP Logo" class="h-full w-full object-contain">
                        </span>
                        <span class="min-w-0 leading-tight">
                            <span class="block text-sm font-extrabold tracking-[0.08em] text-[#bd101b]">SIGAP</span>
                            <span class="block text-[11px] font-bold uppercase tracking-wide text-[#292626]">Peta Pos Damkar</span>
                        </span>
                    </a>
                </div>

                <div class="flex items-center gap-2">
                    @can('damkar')
                        <a href="{{ route('damkar.peta') }}" title="Beralih ke Peta Operasional Damkar" class="inline-flex items-center gap-1 rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[10px] font-bold text-slate-700 shadow-sm hover:bg-slate-50">
                            <span>Panel Petugas</span>
                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endcan
                    <a href="tel:113" class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-[#bd101b] px-3 py-1.5 text-[11px] font-bold text-white shadow-sm transition hover:bg-[#a00e17]">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>113 Darurat</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content Peta Publik -->
        <main class="flex-1 space-y-4 px-5 pb-6 pt-4 sm:px-7">

            <!-- Judul Halaman Publik -->
            <section aria-labelledby="peta-title" class="space-y-1">
                <div class="flex items-center justify-between gap-2">
                    <h1 id="peta-title" class="text-xl font-extrabold tracking-tight text-[#1d2b46]">Peta Pos Pemadam Kebakaran</h1>
                    <span class="rounded-full bg-red-50 px-2.5 py-1 text-[11px] font-bold text-[#bd101b]">{{ count($posDamkarList) }} Pos Siaga</span>
                </div>
                <p class="text-[13px] text-[#766965]">Pantau titik pos Damkar terdekat di sekitar lokasi Anda secara real-time.</p>
            </section>

            <!-- Layout Grid: Peta di Kiri & Daftar Pos di Kanan (Bisa di-scroll) -->
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_380px] xl:grid-cols-[minmax(0,1fr)_420px] items-start">
                
                <!-- Kolom Kiri: Peta Interaktif & Card Rekomendasi Terdekat -->
                <div class="space-y-4 min-w-0">
                    <!-- Card Peta Interaktif -->
                    <section aria-label="Peta lokasi pos pemadam" class="relative overflow-hidden rounded-2xl border border-[#f0e8e5] bg-white shadow-[0_4px_20px_rgba(65,45,40,0.06)]">
                        
                        <!-- Status GPS Pill (Overlay Atas Peta) -->
                        <div class="absolute left-3 top-3 z-10 flex flex-wrap items-center gap-2">
                            <div id="gps-status-badge" class="flex items-center gap-2 rounded-full border border-slate-200/80 bg-white/95 px-3 py-1.5 text-[11px] font-semibold text-slate-700 shadow-md backdrop-blur">
                                <span id="gps-status-dot" class="h-2.5 w-2.5 animate-ping rounded-full bg-blue-500"></span>
                                <span id="gps-status-text">Mendeteksi lokasi GPS Anda...</span>
                            </div>
                        </div>

                        <!-- Kontrol Peta Mengambang (Kanan Atas / Tengah) -->
                        <div class="absolute right-3 top-3 z-10 flex flex-col gap-2">
                            <button type="button" id="btn-my-location" title="Pusatkan ke Lokasi Saya" class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200/80 bg-white text-slate-700 shadow-md transition hover:bg-slate-50 hover:text-[#bd101b]">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <circle cx="12" cy="12" r="3"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v3m0 14v3M2 12h3m14 0h3"/>
                                </svg>
                            </button>
                            <button type="button" id="btn-fit-all" title="Tampilkan Semua Pos" class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200/80 bg-white text-slate-700 shadow-md transition hover:bg-slate-50 hover:text-[#bd101b]">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-5h-4m4 0v4m0-4l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Wadah Peta Leaflet -->
                        <div id="public-map" aria-label="Peta Pos Damkar Publik"></div>

                        <!-- Legenda Ringkas Peta (Bawah Peta) -->
                        <div class="flex flex-wrap items-center justify-between gap-2 border-t border-[#f4edea] bg-[#fffaf8] px-4 py-2.5 text-[11px] text-slate-600">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-blue-600"></span> Lokasi Anda</span>
                                <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-[#bd101b]"></span> Pos Damkar</span>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-400">Siaga 24 Jam • Palembang</span>
                        </div>
                    </section>

                    <!-- Card Rekomendasi: Pos Damkar Terdekat -->
                    <section id="nearest-pos-section" aria-labelledby="nearest-title" class="rounded-2xl border border-red-100 bg-gradient-to-br from-red-50/80 via-white to-white p-4 shadow-sm">
                        <div class="flex items-center justify-between gap-2">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#bd101b] px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wide text-white">
                                <span>⭐</span> Pos Terdekat
                            </span>
                            <span id="nearest-distance-badge" class="text-xs font-extrabold text-[#bd101b]">
                                Menghitung jarak...
                            </span>
                        </div>

                        <div class="mt-3 flex items-start justify-between gap-3">
                            <div class="min-w-0 flex-1">
                                <h2 id="nearest-name" class="text-base font-extrabold text-[#1d2b46]">Memuat pos terdekat...</h2>
                                <p id="nearest-address" class="mt-1 line-clamp-2 text-xs leading-relaxed text-[#766965]">Mendeteksi sinyal GPS perangkat untuk menentukan pos terdekat dari Anda...</p>
                                <div class="mt-2 flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center gap-1 rounded bg-emerald-50 px-2 py-0.5 text-[10px] font-bold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Siaga 24 Jam
                                    </span>
                                    <span id="nearest-unit-badge" class="rounded bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-600">
                                        -
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2 shrink-0">
                                <a href="tel:113" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-[#bd101b] px-3.5 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-[#a00e17]">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span>Panggil 113</span>
                                </a>
                                <button type="button" id="btn-focus-nearest" class="inline-flex items-center justify-center gap-1 rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                    <span>Lihat di Peta</span>
                                </button>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Kolom Kanan: Daftar Seluruh Pos Damkar (Bisa di-scroll) -->
                <aside aria-labelledby="daftar-pos-title" class="flex flex-col rounded-2xl border border-[#f0e8e5] bg-white p-5 shadow-sm max-h-[620px] lg:h-[620px] min-w-0">
                    <div class="flex items-center justify-between gap-2 border-b border-slate-100 pb-3 shrink-0">
                        <div>
                            <h2 id="daftar-pos-title" class="text-sm font-extrabold text-[#1d2b46]">Daftar Seluruh Pos Damkar</h2>
                            <p id="pos-sort-info" class="text-[11px] font-semibold text-slate-500 mt-0.5">Urut berdasarkan jarak terdekat</p>
                        </div>
                        <span class="rounded-full bg-red-50 px-2.5 py-1 text-[10px] font-bold text-[#bd101b] shrink-0">{{ count($posDamkarList) }} Pos</span>
                    </div>

                    <div id="pos-list-container" class="custom-scroll mt-3 flex-1 space-y-2.5 overflow-y-auto pr-1.5">
                        @foreach ($posDamkarList as $pos)
                            <div class="pos-card group flex items-start justify-between gap-3 rounded-xl border border-[#f0e8e5] bg-white p-3.5 shadow-sm transition hover:border-red-200 hover:shadow-md cursor-pointer"
                                 data-id="{{ $pos->id }}"
                                 data-lat="{{ $pos->latitude }}"
                                 data-lng="{{ $pos->longitude }}"
                                 data-nama="{{ $pos->nama }}"
                                 data-unit="{{ $pos->unit }}">
                                <div class="flex items-start gap-3 min-w-0">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#bd101b] font-bold text-xs group-hover:bg-[#bd101b] group-hover:text-white transition">
                                        🚒
                                    </span>
                                    <div class="min-w-0 leading-tight">
                                        <div class="flex items-center gap-1.5">
                                            <h3 class="text-xs font-extrabold text-slate-900 group-hover:text-[#bd101b] transition">{{ $pos->nama }}</h3>
                                        </div>
                                        <p class="mt-1 line-clamp-1 text-[11px] text-slate-500">{{ $pos->alamat }}</p>
                                        <div class="mt-1.5 flex items-center gap-2">
                                            <span class="pos-distance-text text-[11px] font-bold text-[#bd101b]">Menghitung...</span>
                                            <span class="text-slate-300">•</span>
                                            <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded">Siaga 24 Jam</span>
                                        </div>
                                    </div>
                                </div>

                                <a href="tel:113" onclick="event.stopPropagation()" title="Panggil Cepat 113" class="shrink-0 flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-[#bd101b] hover:bg-[#bd101b] hover:text-white transition">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </aside>

            </div>

        </main>

        <!-- Bottom Navigation Bar (Masyarakat) -->
        <nav aria-label="Navigasi utama" class="sticky bottom-0 z-30 grid grid-cols-4 border-t border-[#f0e8e5] bg-[#fffaf8]/95 px-2 pb-[max(0.55rem,env(safe-area-inset-bottom))] pt-2 shadow-[0_-4px_18px_rgba(60,35,30,0.05)] backdrop-blur">
            <a href="{{ route('beranda') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V10Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6c.8 1.5-.7 2.2.4 3 1-.5 1.3-1.4 1.3-1.4 1.2 1.7 1.3 2.6.3 3.7"/></svg>
                <span class="text-[10px] font-bold">Beranda</span>
            </a>
            <a href="{{ route('peta') }}" aria-current="page" class="flex flex-col items-center gap-0.5 text-[#bd101b]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Zm6-3v15m6-12v15"/></svg>
                <span class="text-[10px] font-bold">Peta</span>
            </a>
            <a href="{{ route('laporan.saya') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6l1 2h4v15H4V6h4l1-2Zm1 6h4m-4 4h6m-6 4h6"/></svg>
                <span class="text-[10px] font-bold">Laporan</span>
            </a>
            <a href="@auth{{ route('profile.edit') }}@else{{ route('login') }}@endauth" class="flex flex-col items-center gap-0.5 text-[#705d58]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2H4Z"/></svg>
                <span class="text-[10px] font-bold">Profil</span>
            </a>
        </nav>

    </div>

    <!-- Script Peta Interaktif & Real-Time Geolocation -->
    @php
        $posDataJson = $posDamkarList->map(fn ($p) => [
            'id' => $p->id,
            'nama' => $p->nama,
            'unit' => $p->unit,
            'alamat' => $p->alamat,
            'latitude' => (float) $p->latitude,
            'longitude' => (float) $p->longitude,
        ])->values()->toJson();
    @endphp

    <script>
    (function () {
        const DEFAULT_CENTER = [-2.9761, 104.7754]; // Pusat Kota Palembang
        const posDamkarList = {!! $posDataJson !!};

        // Inisialisasi Peta Leaflet
        const map = L.map('public-map', {
            zoomControl: false,
            attributionControl: false
        }).setView(DEFAULT_CENTER, 12);

        L.control.zoom({ position: 'bottomright' }).addTo(map);
        setTimeout(() => map.invalidateSize(), 300);

        // Tile layer OSM
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // State Pengguna & Marker
        let userLocation = null;
        let userAccuracy = 0;
        let userMarker = null;
        let userAccuracyCircle = null;
        let nearestPos = null;
        const posMarkers = {};

        // Custom Icon untuk Pos Damkar
        function createDamkarIcon() {
            return L.divIcon({
                className: '',
                html: `
                    <div class="pos-damkar-badge">
                        <span class="pos-damkar-badge-icon">🚒</span>
                    </div>
                `,
                iconSize: [36, 36],
                iconAnchor: [18, 36],
                popupAnchor: [0, -34]
            });
        }

        // Custom Icon untuk Lokasi Pengguna (Pulsing Beacon)
        function createUserIcon() {
            return L.divIcon({
                className: '',
                html: `
                    <div class="user-pulse-container">
                        <div class="user-pulse-wave"></div>
                        <div class="user-pulse-core"></div>
                    </div>
                `,
                iconSize: [24, 24],
                iconAnchor: [12, 12],
                popupAnchor: [0, -14]
            });
        }

        // Hitung jarak Haversine (km)
        function hitungJarakKm(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function formatJarak(km) {
            if (km === null || km === undefined) return 'Menghitung jarak...';
            if (km < 1) {
                return Math.round(km * 1000) + ' meter';
            }
            return km.toFixed(1) + ' km';
        }

        // Render Popup Pos Damkar (Khusus Publik)
        function buildPopupContent(pos, distanceKm) {
            const jarakInfo = distanceKm !== null
                ? `<span class="inline-flex items-center gap-1 font-bold text-[#bd101b]">📍 ${formatJarak(distanceKm)} dari lokasi Anda</span>`
                : `<span class="text-slate-400">Jarak belum dihitung (aktifkan GPS)</span>`;

            return `
                <div class="space-y-2.5 text-[#292626] min-w-[220px] max-w-[270px]">
                    <div class="flex items-center justify-between gap-2 border-b border-slate-100 pb-1.5">
                        <span class="inline-flex items-center gap-1 rounded bg-red-50 px-1.5 py-0.5 text-[10px] font-extrabold text-[#bd101b]">${pos.unit}</span>
                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-bold text-emerald-700">● Siaga 24 Jam</span>
                    </div>

                    <div>
                        <h3 class="text-xs font-extrabold text-slate-900 leading-tight">${pos.nama}</h3>
                        <p class="mt-1 text-[11px] leading-relaxed text-slate-500">${pos.alamat}</p>
                    </div>

                    <div class="rounded-lg bg-red-50/70 p-2 text-[11px] leading-none">
                        ${jarakInfo}
                    </div>

                    <div class="grid grid-cols-2 gap-2 pt-1">
                        <a href="tel:113" class="flex items-center justify-center gap-1 rounded-lg bg-[#bd101b] px-3 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-[#a00e17]">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            Panggil 113
                        </a>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=${pos.latitude},${pos.longitude}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-1 rounded-lg border border-slate-200 bg-white px-2 py-2 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 20 3-3m0 0 3 3m-3-3V4"/></svg>
                            Petunjuk
                        </a>
                    </div>
                </div>
            `;
        }

        // Pasang Marker Semua Pos Damkar
        const allLatLngs = [];
        posDamkarList.forEach(pos => {
            const marker = L.marker([pos.latitude, pos.longitude], {
                icon: createDamkarIcon(),
                title: pos.nama
            }).addTo(map);

            marker.bindPopup(() => {
                const dist = userLocation
                    ? hitungJarakKm(userLocation.lat, userLocation.lng, pos.latitude, pos.longitude)
                    : null;
                return buildPopupContent(pos, dist);
            });

            posMarkers[pos.id] = marker;
            allLatLngs.push([pos.latitude, pos.longitude]);
        });

        // Fit map bounds saat awal
        if (allLatLngs.length > 0) {
            map.fitBounds(L.latLngBounds(allLatLngs), { padding: [40, 40] });
        }

        // Perbarui Tampilan Jarak & Urutan Pos
        function updateDistanceAndSort() {
            if (!userLocation) return;

            let minDistance = Infinity;
            nearestPos = null;

            // Hitung jarak setiap pos dari pengguna
            const posWithDistance = posDamkarList.map(pos => {
                const distanceKm = hitungJarakKm(
                    userLocation.lat,
                    userLocation.lng,
                    pos.latitude,
                    pos.longitude
                );
                if (distanceKm < minDistance) {
                    minDistance = distanceKm;
                    nearestPos = { ...pos, distanceKm };
                }
                return { ...pos, distanceKm };
            });

            // Update Card Rekomendasi Terdekat
            if (nearestPos) {
                document.getElementById('nearest-name').innerText = nearestPos.nama;
                document.getElementById('nearest-address').innerText = nearestPos.alamat;
                document.getElementById('nearest-unit-badge').innerText = 'Kode ' + nearestPos.unit;
                document.getElementById('nearest-distance-badge').innerText = '📍 ' + formatJarak(nearestPos.distanceKm) + ' dari Anda';
            }

            // Urutkan daftar pos dari yang terdekat
            posWithDistance.sort((a, b) => a.distanceKm - b.distanceKm);

            const container = document.getElementById('pos-list-container');
            if (container) {
                container.innerHTML = '';
                posWithDistance.forEach((pos, idx) => {
                    const card = document.createElement('div');
                    card.className = `pos-card group flex items-start justify-between gap-3 rounded-xl border ${idx === 0 ? 'border-red-300 bg-red-50/30' : 'border-[#f0e8e5] bg-white'} p-3.5 shadow-sm transition hover:border-red-200 hover:shadow-md cursor-pointer`;
                    card.innerHTML = `
                        <div class="flex items-start gap-3 min-w-0">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl ${idx === 0 ? 'bg-[#bd101b] text-white' : 'bg-red-50 text-[#bd101b]'} font-bold text-xs group-hover:bg-[#bd101b] group-hover:text-white transition">
                                🚒
                            </span>
                            <div class="min-w-0 leading-tight">
                                <div class="flex items-center gap-1.5">
                                    <h3 class="text-xs font-extrabold text-slate-900 group-hover:text-[#bd101b] transition">${pos.nama}</h3>
                                    ${idx === 0 ? '<span class="rounded bg-red-100 px-1.5 py-0.2 text-[9px] font-extrabold text-[#bd101b]">Terdekat</span>' : ''}
                                </div>
                                <p class="mt-1 line-clamp-1 text-[11px] text-slate-500">${pos.alamat}</p>
                                <div class="mt-1.5 flex items-center gap-2">
                                    <span class="text-[11px] font-bold text-[#bd101b]">📍 ${formatJarak(pos.distanceKm)}</span>
                                    <span class="text-slate-300">•</span>
                                    <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded">Siaga 24 Jam</span>
                                </div>
                            </div>
                        </div>

                        <a href="tel:113" onclick="event.stopPropagation()" title="Panggil Cepat 113" class="shrink-0 flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-[#bd101b] hover:bg-[#bd101b] hover:text-white transition">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </a>
                    `;

                    card.addEventListener('click', () => {
                        focusPos(pos.id, pos.latitude, pos.longitude);
                    });

                    container.appendChild(card);
                });
            }
        }

        // Fokus ke Pos Tertentu
        function focusPos(id, lat, lng) {
            map.flyTo([lat, lng], 15, { duration: 1 });
            const m = posMarkers[id];
            if (m) {
                setTimeout(() => m.openPopup(), 600);
            }
        }

        // Event Tombol Fokus ke Pos Terdekat
        const btnFocusNearest = document.getElementById('btn-focus-nearest');
        if (btnFocusNearest) {
            btnFocusNearest.addEventListener('click', () => {
                if (nearestPos) {
                    focusPos(nearestPos.id, nearestPos.latitude, nearestPos.longitude);
                } else {
                    alert('Sedang menentukan pos terdekat...');
                }
            });
        }

        // Event Tombol "Lokasi Saya"
        const btnMyLocation = document.getElementById('btn-my-location');
        if (btnMyLocation) {
            btnMyLocation.addEventListener('click', () => {
                if (userLocation) {
                    map.flyTo([userLocation.lat, userLocation.lng], 16, { duration: 1 });
                    if (userMarker) userMarker.openPopup();
                } else {
                    requestGeolocation(true);
                }
            });
        }

        // Event Tombol "Semua Pos"
        const btnFitAll = document.getElementById('btn-fit-all');
        if (btnFitAll) {
            btnFitAll.addEventListener('click', () => {
                const points = [...allLatLngs];
                if (userLocation) points.push([userLocation.lat, userLocation.lng]);
                map.fitBounds(L.latLngBounds(points), { padding: [40, 40] });
            });
        }

        // Update Posisi Pengguna di Peta
        function updateUserPosition(lat, lng, accuracy, isFirstTime = false) {
            userLocation = { lat, lng };
            userAccuracy = accuracy;

            // Update Status Badge
            const badgeText = document.getElementById('gps-status-text');
            const badgeDot = document.getElementById('gps-status-dot');
            if (badgeText) badgeText.innerText = `GPS Aktif (±${Math.round(accuracy)}m)`;
            if (badgeDot) {
                badgeDot.className = 'h-2.5 w-2.5 rounded-full bg-emerald-500';
            }

            // Update Marker Pengguna
            if (!userMarker) {
                userMarker = L.marker([lat, lng], {
                    icon: createUserIcon(),
                    zIndexOffset: 1000
                }).addTo(map);

                userMarker.bindPopup(`
                    <div class="text-xs p-1 text-slate-800">
                        <strong class="text-blue-700 block font-bold">📍 Lokasi Anda Saat Ini</strong>
                        <span class="text-[11px] text-slate-500">Akurasi GPS: ±${Math.round(accuracy)} meter</span>
                    </div>
                `);
            } else {
                userMarker.setLatLng([lat, lng]);
            }

            // Update Lingkaran Akurasi
            if (userAccuracyCircle) {
                userAccuracyCircle.setLatLng([lat, lng]);
                userAccuracyCircle.setRadius(accuracy);
            } else {
                userAccuracyCircle = L.circle([lat, lng], {
                    radius: accuracy,
                    color: '#2563eb',
                    weight: 1,
                    fillColor: '#3b82f6',
                    fillOpacity: 0.12
                }).addTo(map);
            }

            // Jika pertama kali, arahkan peta agar mencakup user dan pos terdekat
            if (isFirstTime) {
                updateDistanceAndSort();
                if (nearestPos) {
                    const bounds = L.latLngBounds([
                        [lat, lng],
                        [nearestPos.latitude, nearestPos.longitude]
                    ]);
                    map.fitBounds(bounds, { padding: [60, 60], maxZoom: 15 });
                } else {
                    map.setView([lat, lng], 14);
                }
            } else {
                updateDistanceAndSort();
            }
        }

        // Penanganan Real-Time Geolocation
        let watchId = null;
        let isInitialFix = true;

        function requestGeolocation(userTriggered = false) {
            if (!navigator.geolocation) {
                const badgeText = document.getElementById('gps-status-text');
                const badgeDot = document.getElementById('gps-status-dot');
                if (badgeText) badgeText.innerText = 'GPS tidak didukung perangkat';
                if (badgeDot) badgeDot.className = 'h-2.5 w-2.5 rounded-full bg-amber-500';
                return;
            }

            const options = {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 5000
            };

            // Real-time tracking dengan watchPosition
            if (watchId !== null) {
                navigator.geolocation.clearWatch(watchId);
            }

            watchId = navigator.geolocation.watchPosition(
                pos => {
                    const { latitude, longitude, accuracy } = pos.coords;
                    updateUserPosition(latitude, longitude, accuracy, isInitialFix);
                    isInitialFix = false;
                },
                err => {
                    console.warn('Geolocation error:', err.message);
                    const badgeText = document.getElementById('gps-status-text');
                    const badgeDot = document.getElementById('gps-status-dot');
                    if (badgeText) {
                        badgeText.innerText = err.code === 1
                            ? 'Izin lokasi tidak diberikan'
                            : 'Mencari sinyal GPS...';
                    }
                    if (badgeDot) {
                        badgeDot.className = 'h-2.5 w-2.5 rounded-full bg-amber-500';
                    }
                    if (userTriggered && err.code === 1) {
                        alert('Silakan aktifkan izin lokasi di browser Anda agar peta dapat menampilkan pos damkar terdekat secara akurat.');
                    }
                },
                options
            );
        }

        // Mulai pelacakan lokasi saat halaman dimuat
        requestGeolocation(false);

    })();
    </script>
</body>
</html>

