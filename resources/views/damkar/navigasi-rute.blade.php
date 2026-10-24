@extends('layouts.damkar')

@section('judul', 'Navigasi Menuju TKP — Panel Damkar')

@section('main-class', 'flex-1 flex flex-col relative h-screen overflow-hidden')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />

<style>
    #osm-map .leaflet-tile-container img { max-width: none !important; max-height: none !important; }
    .leaflet-control-zoom { border: none !important; box-shadow: 0 4px 12px rgba(0,0,0,.1) !important; border-radius: 12px !important; overflow: hidden; }
    .custom-damkar-unit-icon, .custom-fire-target-icon { background: transparent; border: none; }
</style>

<!-- Header Mengambang di Atas Peta -->
<header class="absolute top-0 left-0 right-0 z-20 p-6 flex items-center justify-between pointer-events-none">
    <div class="bg-white/95 backdrop-blur-md px-4 py-2.5 rounded-2xl shadow-sm border border-slate-100 pointer-events-auto flex items-center gap-2 text-xs font-bold text-slate-700">
        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
        <span>{{ $posDamkar->nama ?? 'Pos Damkar' }}</span>
    </div>
    <div class="pointer-events-auto">
        <span class="inline-flex items-center gap-2 px-4 py-2 bg-[#E52329] text-white text-xs font-bold rounded-2xl shadow-md">
            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
            <span>Peta Insiden Aktif — {{ $laporan->kendaraan->kode ?? 'Armada Ditugaskan' }}</span>
        </span>
    </div>
    <div class="flex items-center gap-3 pointer-events-auto">
        <div class="bg-white/95 backdrop-blur-md px-4 py-2.5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-2 text-xs font-bold text-slate-700">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span id="realtime-clock">--:--:-- WIB</span>
        </div>
        <a href="{{ route('profile.edit') }}" class="w-10 h-10 bg-[#E52329] text-white rounded-2xl flex items-center justify-center shadow-md hover:bg-red-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </a>
    </div>
</header>

<!-- Kartu Kiri Atas: Status Navigasi -->
<div class="absolute top-20 left-6 z-20 max-w-sm pointer-events-auto">
    <div class="bg-white/95 backdrop-blur-md p-4 rounded-3xl shadow-xl border border-slate-100 flex items-center gap-3.5">
        <div class="w-10 h-10 rounded-2xl bg-[#E52329] text-white flex items-center justify-center shrink-0 shadow-md">
            <svg class="w-5 h-5 transform rotate-45" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
        </div>
        <div>
            <h4 class="text-sm font-extrabold text-slate-900 leading-tight">Navigasi Menuju TKP</h4>
            <p class="text-[11px] font-medium text-slate-500 mt-0.5">Rute tercepat via jalur utama</p>
        </div>
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-extrabold rounded-full shrink-0 ml-auto">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Panduan GPS Aktif</span>
        </span>
    </div>
</div>

<!-- Map Leaflet -->
<div id="osm-map" class="w-full h-full z-0"></div>

<!-- Kartu Bawah Tengah -->
<div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 z-20 w-full max-w-4xl px-4 pointer-events-auto">
    <div class="bg-white/95 backdrop-blur-md p-5 rounded-3xl shadow-2xl border border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 flex-1 w-full border-b md:border-b-0 md:border-r border-slate-100 pb-4 md:pb-0 md:pr-6">
            <div class="space-y-1">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">ESTIMASI WAKTU</span>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-black text-slate-900" id="duration-val">--</span>
                    <span class="text-xs font-bold text-slate-500">menit</span>
                </div>
            </div>
            <div class="space-y-1">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">JARAK TEMPUH</span>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-black text-slate-900" id="distance-val">--</span>
                    <span class="text-xs font-bold text-slate-500">km</span>
                </div>
            </div>
            <div class="space-y-1">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">UNIT BERTUGAS</span>
                <span class="text-base font-extrabold text-slate-900 block mt-1">{{ $laporan->kendaraan->kode ?? 'UNIT DAMKAR' }}</span>
            </div>
            <div class="space-y-1">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">TUJUAN</span>
                <span class="text-xs font-bold text-slate-800 line-clamp-2 mt-1 leading-snug">{{ $laporan->alamat }}</span>
            </div>
        </div>

        <a href="{{ route('damkar.laporan.penanganan-tkp', $laporan) }}"
           class="w-full md:w-auto bg-[#E52329] hover:bg-red-700 text-white font-extrabold text-sm px-6 py-4 rounded-2xl flex items-center justify-center gap-2.5 shadow-lg hover:shadow-red-900/20 transition-all active:scale-95 shrink-0">
            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            <span>Mulai Penanganan</span>
        </a>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    @php
        $posLat = (float) ($laporan->kendaraan?->latitude ?? $posDamkar?->latitude ?? -2.985);
        $posLng = (float) ($laporan->kendaraan?->longitude ?? $posDamkar?->longitude ?? 104.755);
        $fireLat = (float) ($laporan->latitude ?? -2.989);
        $fireLng = (float) ($laporan->longitude ?? 104.758);
        $unitKode = $laporan->kendaraan?->kode ?? 'DAMKAR';
        $posNama = $posDamkar?->nama ?? 'Pos Damkar';
        $alamat = $laporan->alamat;
    @endphp

    const routeData = {
        unit: @json($unitKode),
        pos_nama: @json($posNama),
        lokasi: @json($alamat),
        pos_lat: {{ $posLat }},
        pos_lng: {{ $posLng }},
        fire_lat: {{ $fireLat }},
        fire_lng: {{ $fireLng }}
    };

    const map = L.map('osm-map', { zoomControl: true, scrollWheelZoom: true })
        .setView([routeData.fire_lat, routeData.fire_lng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const damkarUnitIcon = L.divIcon({
        className: 'custom-damkar-unit-icon',
        html: `
            <div class="flex flex-col items-center">
                <div class="bg-[#1E293B] text-white px-2.5 py-1 rounded-xl shadow-md border border-slate-700 text-[10px] font-extrabold whitespace-nowrap mb-1">${routeData.unit}</div>
                <div class="w-10 h-10 bg-white text-[#E52329] rounded-2xl flex items-center justify-center shadow-lg border-2 border-[#E52329]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
                <span class="text-[9px] font-bold text-slate-600 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded shadow-sm mt-1 whitespace-nowrap">Titik Awal: ${routeData.pos_nama}</span>
            </div>`,
        iconSize: [110, 70],
        iconAnchor: [55, 35]
    });

    const fireTargetIcon = L.divIcon({
        className: 'custom-fire-target-icon',
        html: `
            <div class="flex flex-col items-center">
                <span class="bg-[#E52329] text-white text-[10px] font-extrabold px-3 py-1 rounded-xl shadow-md mb-1 whitespace-nowrap">Tujuan Kejadian</span>
                <div class="w-10 h-10 bg-[#E52329] text-white rounded-2xl flex items-center justify-center shadow-lg border-2 border-white relative">
                    <span class="absolute w-12 h-12 bg-red-500/30 rounded-2xl animate-ping"></span>
                    <svg class="w-6 h-6 relative z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 23c6.075 0 11-4.925 11-11 0-4.04-2.18-7.572-5.434-9.524a.75.75 0 0 0-1.096.862C17.065 5.508 17.5 7.95 17.5 10c0 .605-.06 1.196-.176 1.767a8.96 8.96 0 0 0-3.324-2.767.75.75 0 0 0-1.077.72c.078 1.488-.363 2.981-1.282 4.108C10.59 15.12 9.297 15.75 8 15.75c-.88 0-1.725-.262-2.45-.733A6.974 6.974 0 0 1 4.5 12c0-2.316.892-4.423 2.352-6.002a.75.75 0 0 0-.58-1.222C3.132 5.378 1 8.442 1 12c0 6.075 4.925 11 11 11z"/></svg>
                </div>
                <span class="text-[9px] font-bold text-slate-700 bg-white/95 backdrop-blur-sm px-2 py-0.5 rounded shadow-sm mt-1 whitespace-nowrap">${routeData.lokasi}</span>
            </div>`,
        iconSize: [120, 75],
        iconAnchor: [60, 37]
    });

    L.marker([routeData.pos_lat, routeData.pos_lng], { icon: damkarUnitIcon }).addTo(map);
    L.marker([routeData.fire_lat, routeData.fire_lng], { icon: fireTargetIcon }).addTo(map);

    const durationEl = document.getElementById('duration-val');
    const distanceEl = document.getElementById('distance-val');

    function tampilkanJarakWaktu(km, menit) {
        if (durationEl) durationEl.innerText = menit;
        if (distanceEl) distanceEl.innerText = km.toFixed(1).replace('.', ',');
    }

    // Cadangan: garis lurus + estimasi jarak (dipakai jika routing gagal)
    function rutePerkiraan() {
        const toRad = d => d * Math.PI / 180;
        const dLat = toRad(routeData.fire_lat - routeData.pos_lat);
        const dLng = toRad(routeData.fire_lng - routeData.pos_lng);
        const a = Math.sin(dLat/2)**2 + Math.cos(toRad(routeData.pos_lat)) * Math.cos(toRad(routeData.fire_lat)) * Math.sin(dLng/2)**2;
        const roadKm = Math.max(0.5, 2 * 6371 * Math.asin(Math.sqrt(a)) * 1.3);
        tampilkanJarakWaktu(roadKm, Math.max(2, Math.round(roadKm / 35 * 60)));

        const garis = L.polyline(
            [[routeData.pos_lat, routeData.pos_lng], [routeData.fire_lat, routeData.fire_lng]],
            { color: '#E52329', weight: 6, opacity: 0.9, lineCap: 'round', lineJoin: 'round' }
        ).addTo(map);
        map.fitBounds(garis.getBounds(), { padding: [80, 80] });
    }

    // Rute mengikuti jalan (OSRM). OSRM memakai urutan lng,lat
    async function gambarRuteJalan() {
        const url = `https://router.project-osrm.org/route/v1/driving/${routeData.pos_lng},${routeData.pos_lat};${routeData.fire_lng},${routeData.fire_lat}?overview=full&geometries=geojson`;
        try {
            const res = await fetch(url);
            if (!res.ok) throw new Error('HTTP ' + res.status);
            const data = await res.json();
            if (data.code !== 'Ok' || !data.routes.length) throw new Error('Rute tidak ditemukan');

            const rute = data.routes[0];
            const garis = L.geoJSON(rute.geometry, {
                style: { color: '#E52329', weight: 6, opacity: 0.9, lineCap: 'round', lineJoin: 'round' }
            }).addTo(map);

            tampilkanJarakWaktu(rute.distance / 1000, Math.max(1, Math.round(rute.duration / 60)));
            map.fitBounds(garis.getBounds(), { padding: [80, 80] });
        } catch (err) {
            console.warn('Routing gagal, memakai garis lurus:', err);
            rutePerkiraan();
        }
    }
    gambarRuteJalan();

    function updateClock() {
        const now = new Date();
        const clockEl = document.getElementById('realtime-clock');
        if (clockEl) clockEl.innerText = now.toLocaleTimeString('id-ID', { hour12: false }) + ' WIB';
    }
    setInterval(updateClock, 1000);
    updateClock();

    setTimeout(() => map.invalidateSize(), 300);
});
</script>
@endsection

