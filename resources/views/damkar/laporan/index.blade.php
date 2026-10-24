@extends('layouts.damkar')

@section('judul', 'Laporan — Pemantauan')

{{-- Halaman peta layar penuh, bukan konten ber-scrollbar --}}
@section('main-class', 'flex-1 flex flex-col relative h-screen overflow-hidden')

@section('content')
<!-- CSS Leaflet OpenStreetMap -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />

<style>
    #osm-map .leaflet-tile-container img { max-width: none !important; max-height: none !important; }

    .leaflet-control-zoom { border: none !important; box-shadow: 0 4px 12px rgba(0,0,0,.1) !important; border-radius: 12px !important; overflow: hidden; }
    .leaflet-control-zoom-in, .leaflet-control-zoom-out {
        display: flex !important; align-items: center !important; justify-content: center !important;
        background-color: #fff !important; color: #334155 !important; font-weight: bold !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    .leaflet-popup-content-wrapper { padding: 0 !important; border-radius: 20px !important; box-shadow: 0 10px 25px -5px rgba(0,0,0,.15) !important; overflow: hidden; }
    .leaflet-popup-content { margin: 0 !important; width: 310px !important; }
    .leaflet-popup-tip { background: #fff !important; }
    .custom-fire-marker, .custom-pos-building-marker, .custom-unit-label { background: transparent; border: none; }
</style>

<!-- Header Mengambang di Peta -->
<header class="pointer-events-none absolute left-0 right-0 top-0 z-20 flex items-center justify-between p-6">
    <div class="pointer-events-auto flex items-center gap-2 rounded-2xl border border-slate-100 bg-white/95 px-4 py-2.5 text-xs font-bold text-slate-700 shadow-sm backdrop-blur-md">
        <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
        <span>Semua Pos — Palembang</span>
    </div>
    <div class="pointer-events-auto flex items-center gap-3">
        <div class="flex items-center gap-2 rounded-2xl border border-slate-100 bg-white/95 px-4 py-2.5 text-xs font-bold text-slate-700 shadow-sm backdrop-blur-md">
            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span id="realtime-clock">00:00:00 WIB</span>
        </div>
        <a href="{{ route('profile.edit') }}" class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#E52329] text-white shadow-md transition-colors hover:bg-red-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </a>
    </div>
</header>

<!-- Peta OpenStreetMap -->
<div id="osm-map" class="z-0 h-full w-full"></div>

<!-- Legenda -->
<div class="absolute bottom-6 left-6 z-20">
    <div class="flex items-center gap-5 rounded-2xl border border-slate-100 bg-white/95 px-5 py-3 text-xs font-bold text-slate-700 shadow-lg backdrop-blur-md">
        <div class="flex items-center gap-2"><span class="h-3 w-3 rounded-full bg-[#E52329] ring-4 ring-red-100"></span><span>Titik Api</span></div>
        <span class="text-slate-300">•</span>
        <div class="flex items-center gap-2"><span class="h-3 w-3 rounded-full bg-[#1E293B]"></span><span>Unit Bergerak</span></div>
        <span class="text-slate-300">•</span>
        <div class="flex items-center gap-2"><div class="flex h-4 w-4 items-center justify-center rounded border border-slate-300 bg-white text-slate-600"><svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9"/></svg></div><span>Pos Siaga</span></div>
    </div>
</div>

<!-- Badge Peringatan -->
@if ($pendingCount > 0)
    <div class="absolute bottom-6 right-6 z-20 max-w-sm">
        <div class="flex items-start gap-3.5 rounded-3xl border border-red-100 bg-white/95 p-4 shadow-xl backdrop-blur-md">
            <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl bg-red-100 text-[#E52329]">
                <svg class="h-5 w-5 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <div>
                <h4 class="text-xs font-extrabold leading-tight text-slate-900">{{ $pendingCount }} Kebakaran Membutuhkan Verifikasi</h4>
                <p class="mt-1 text-[11px] font-medium text-slate-500">Semua Pos siap melakukan pengerahan</p>
            </div>
        </div>
    </div>
@endif

<!-- JS Leaflet OpenStreetMap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
@include('damkar.partials.pos-icon')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Laporan nyata dari database (titik api) + pos damkar + unit simulasi
        const laporanList = @json($laporanList);
        const posDamkarList = @json($posDamkarList);
        const fleetUnits = @json($fleetUnits);

        const titikApi = laporanList.filter(l => l.status === 'pending' || l.status === 'diproses');
        const insidenUtama = titikApi.length ? titikApi[0] : null;

        const pusat = insidenUtama ? [insidenUtama.lat, insidenUtama.lng] : [-2.985, 104.755];
        const map = L.map('osm-map', { zoomControl: true, scrollWheelZoom: true }).setView(pusat, insidenUtama ? 14 : 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Ikon Titik Api (berdenyut)
        const fireIcon = L.divIcon({
            className: 'custom-fire-marker',
            html: `<div class="relative flex items-center justify-center">
                <span class="absolute h-12 w-12 animate-ping rounded-2xl bg-red-500/30"></span>
                <div class="relative z-10 flex h-10 w-10 items-center justify-center rounded-2xl border-2 border-white bg-[#E52329] text-white shadow-lg">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 23c6.075 0 11-4.925 11-11 0-4.04-2.18-7.572-5.434-9.524a.75.75 0 0 0-1.096.862C17.065 5.508 17.5 7.95 17.5 10c0 .605-.06 1.196-.176 1.767a8.96 8.96 0 0 0-3.324-2.767.75.75 0 0 0-1.077.72c.078 1.488-.363 2.981-1.282 4.108C10.59 15.12 9.297 15.75 8 15.75c-.88 0-1.725-.262-2.45-.733A6.974 6.974 0 0 1 4.5 12c0-2.316.892-4.423 2.352-6.002a.75.75 0 0 0-.58-1.222C3.132 5.378 1 8.442 1 12c0 6.075 4.925 11 11 11z"/></svg>
                </div></div>`,
            iconSize: [40, 40], iconAnchor: [20, 20], popupAnchor: [0, -22]
        });

        // Pasang titik api untuk setiap laporan aktif dengan popup kartu
        const markerKejadian = [];
        titikApi.forEach((kejadian, indeks) => {
            const popupKartu = `
                <div class="p-4 bg-white space-y-3 font-sans" style="text-align:left">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1 text-[10px] font-extrabold ${kejadian.status === 'pending' ? 'bg-amber-50 text-amber-600' : 'bg-red-50 text-red-600'}">
                            <span class="h-1.5 w-1.5 animate-pulse rounded-full ${kejadian.status === 'pending' ? 'bg-amber-500' : 'bg-red-500'}"></span>${kejadian.status_label}
                        </span>
                        <span class="flex items-center gap-1 text-xs font-bold text-slate-400">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            ${kejadian.waktu}
                        </span>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold leading-snug text-slate-900">${kejadian.judul_lokasi}</h3>
                        <p class="mt-0.5 text-xs font-medium text-slate-500">Pelapor: ${kejadian.nama_pelapor}</p>
                    </div>
                    <div class="flex items-center gap-1.5 border-t border-slate-100 pt-1 text-[11px] font-medium text-slate-400">
                        <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>${kejadian.keterangan_waktu}</span>
                    </div>
                    <a href="${kejadian.detail_url}" class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#E52329] px-4 py-2.5 text-xs font-bold text-white shadow-sm transition-colors hover:bg-red-700">
                        <span>Lihat Detail</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>`;

            const marker = L.marker([kejadian.lat, kejadian.lng], { icon: fireIcon }).addTo(map);
            marker.bindPopup(popupKartu);
            markerKejadian.push(marker);
        });

        // Buka popup kejadian terbaru otomatis
        if (markerKejadian.length) {
            setTimeout(() => markerKejadian[0].openPopup(), 300);
        }

        // Marker Pos Pemadam (ikon gedung pos) dengan label nama pos
        posDamkarList.forEach(pos => {
            L.marker([pos.lat, pos.lng], { icon: buatIkonPosDamkar(pos.nama) })
                .addTo(map)
                .bindPopup(`<strong>${pos.nama}</strong><br>${pos.alamat ?? ''}`);
        });

        // Label Unit Bergerak (posisi simulasi sampai GPS armada terpasang)
        fleetUnits.forEach(unit => {
            const unitIcon = L.divIcon({
                className: 'custom-unit-label',
                html: `<div class="flex items-center gap-1.5 whitespace-nowrap rounded-xl border border-slate-700 bg-[#1E293B] px-3 py-1 text-white shadow-lg">
                    <span class="h-2 w-2 rounded-full ${unit.status === 'bergerak' ? 'animate-pulse bg-emerald-400' : 'bg-slate-400'}"></span>
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    <span class="text-[11px] font-extrabold">${unit.code}</span></div>`,
                iconSize: [90, 26]
            });
            L.marker([unit.lat, unit.lng], { icon: unitIcon }).addTo(map);
        });

        // Garis jalur unit terdekat menuju kejadian terbaru (mengikuti jalan via OSRM)
        const unitTarget = fleetUnits[0];
        if (unitTarget && insidenUtama) {
            const gayaRute = { color: '#E52329', weight: 2.5, dashArray: '6, 8', opacity: 0.8 };

            // Cadangan: garis siku jika routing gagal
            const garisCadangan = () => L.polyline([
                [unitTarget.lat, unitTarget.lng],
                [unitTarget.lat, insidenUtama.lng],
                [insidenUtama.lat, insidenUtama.lng]
            ], gayaRute).addTo(map);

            // OSRM memakai urutan lng,lat
            const urlRute = `https://router.project-osrm.org/route/v1/driving/${unitTarget.lng},${unitTarget.lat};${insidenUtama.lng},${insidenUtama.lat}?overview=full&geometries=geojson`;
            fetch(urlRute)
                .then(res => { if (!res.ok) throw new Error('HTTP ' + res.status); return res.json(); })
                .then(data => {
                    if (data.code !== 'Ok' || !data.routes.length) throw new Error('Rute tidak ditemukan');
                    L.geoJSON(data.routes[0].geometry, { style: gayaRute }).addTo(map);
                })
                .catch(err => { console.warn('Routing gagal, memakai garis cadangan:', err); garisCadangan(); });
        }

        // Jam realtime
        function perbaruiJam() {
            const sekarang = new Date();
            const jamEl = document.getElementById('realtime-clock');
            if (jamEl) jamEl.innerText = sekarang.toLocaleTimeString('id-ID', { hour12: false }) + ' WIB';
        }
        setInterval(perbaruiJam, 1000);
        perbaruiJam();

        setTimeout(() => map.invalidateSize(), 300);
    });
</script>
@endsection
