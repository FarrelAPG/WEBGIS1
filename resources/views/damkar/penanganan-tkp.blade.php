@extends('layouts.damkar')

@section('judul', 'Penanganan TKP — Panel Damkar')

@section('main-class', 'flex-1 p-6 space-y-6 overflow-y-auto bg-[#F8FAFC]')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />

<style>
    #osm-map .leaflet-tile-container img { max-width: none !important; max-height: none !important; }
    .leaflet-control-zoom { border: none !important; box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important; border-radius: 12px !important; overflow: hidden; }
    .custom-fire-tkp, .custom-damkar-unit-tkp { background: transparent; border: none; }
</style>

<!-- Header Info Lokasi & Waktu Operasi -->
<div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex items-center gap-4">
        <a href="{{ route('damkar.laporan.navigasi-rute', $laporan) }}" class="w-10 h-10 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl flex items-center justify-center shrink-0 transition-colors" title="Kembali ke Navigasi">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        </a>
        <div>
            <h2 class="text-base font-extrabold text-slate-900 leading-snug">{{ $laporan->alamat }}</h2>
            <div class="flex items-center gap-3 text-xs font-semibold text-slate-400 mt-0.5">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Mulai Operasi: {{ ($laporan->mulai_penanganan_at ?? $laporan->updated_at) ? ($laporan->mulai_penanganan_at ?? $laporan->updated_at)->format('H:i').' WIB' : '-' }}</span>
                </span>
                <span>•</span>
                <span class="text-slate-600 font-bold">Unit: {{ $laporan->kendaraan->kode ?? 'Armada' }}</span>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-[#E52329] text-xs font-extrabold rounded-full">
            <span class="w-2 h-2 rounded-full bg-[#E52329] animate-pulse"></span>
            Operasi Pemadaman Aktif
        </span>
    </div>
</div>

<!-- Grid Peta TKP & Aksi -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
    <!-- Peta TKP (8/12) -->
    <div class="lg:col-span-8 bg-white rounded-3xl p-5 shadow-sm border border-slate-100 space-y-4">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-red-100 text-[#E52329] flex items-center justify-center">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 23c6.075 0 11-4.925 11-11 0-4.04-2.18-7.572-5.434-9.524a.75.75 0 0 0-1.096.862C17.065 5.508 17.5 7.95 17.5 10c0 .605-.06 1.196-.176 1.767a8.96 8.96 0 0 0-3.324-2.767.75.75 0 0 0-1.077.72c.078 1.488-.363 2.981-1.282 4.108C10.59 15.12 9.297 15.75 8 15.75c-.88 0-1.725-.262-2.45-.733A6.974 6.974 0 0 1 4.5 12c0-2.316.892-4.423 2.352-6.002a.75.75 0 0 0-.58-1.222C3.132 5.378 1 8.442 1 12c0 6.075 4.925 11 11 11z"/></svg>
                </div>
                <h3 class="text-sm font-extrabold text-slate-900">Peta TKP</h3>
                <span class="px-2.5 py-1 bg-blue-50 text-blue-600 text-[11px] font-bold rounded-lg border border-blue-100">Radius 50m</span>
            </div>
            <div class="flex items-center gap-4 text-xs font-bold text-slate-600">
                <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#E52329]"></span><span>Titik Api</span></div>
                <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#1E293B]"></span><span>Unit Damkar</span></div>
            </div>
        </div>

        <div class="w-full h-[400px] rounded-2xl overflow-hidden border border-slate-200 relative" id="map-tkp-container">
            <div id="osm-map" class="w-full h-full z-0"></div>
        </div>
    </div>

    <!-- Kartu Aksi Penyelesaian Insiden (4/12) -->
    <div class="lg:col-span-4 bg-white rounded-3xl p-6 shadow-sm border border-slate-100 space-y-6">
        <div class="flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-2xl bg-[#E52329] text-white flex items-center justify-center shrink-0 shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Penyelesaian Insiden</h3>
                <p class="text-xs font-semibold text-slate-400 mt-1 leading-relaxed">
                    Tekan tombol di bawah jika api pokok telah padam sepenuhnya dan proses pendinginan telah selesai.
                </p>
            </div>
        </div>

        <div class="rounded-2xl bg-amber-50 border border-amber-100 p-4">
            <div class="flex items-center gap-2 text-xs font-bold text-amber-800">
                <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Perhatian Komandan Regu</span>
            </div>
            <p class="text-[11px] font-medium text-amber-700 mt-1">
                Menyelesaikan penanganan akan mengembalikan status armada menjadi siaga dan membuka formulir evaluasi akhir laporan.
            </p>
        </div>

        <form method="POST" action="{{ route('damkar.laporan.selesai', $laporan) }}" onsubmit="return confirm('Yakin api pokok sudah padam sepenuhnya? Status laporan akan menjadi selesai.')">
            @csrf
            @method('PATCH')
            <button type="submit" class="w-full bg-[#E52329] hover:bg-red-700 text-white font-extrabold text-sm py-4 px-4 rounded-2xl shadow-md hover:shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                <span>Selesaikan Penanganan & Buat Laporan</span>
            </button>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fireLat = {{ (float) ($laporan->latitude ?? -2.989) }};
    const fireLng = {{ (float) ($laporan->longitude ?? 104.758) }};
    const unitKode = @json($laporan->kendaraan->kode ?? 'DAMKAR');
    const unitNama = @json($laporan->kendaraan->nama ?? 'Unit Lapangan');

    const map = L.map('osm-map', { zoomControl: true, scrollWheelZoom: false }).setView([fireLat, fireLng], 17);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Lingkaran zona api 50m
    L.circle([fireLat, fireLng], {
        color: '#E52329',
        dashArray: '6, 6',
        fillColor: '#E52329',
        fillOpacity: 0.08,
        radius: 50
    }).addTo(map);

    // Marker Titik Api
    const fireIcon = L.divIcon({
        className: 'custom-fire-tkp',
        html: `
            <div class="flex flex-col items-center">
                <div class="w-9 h-9 bg-[#E52329] text-white rounded-2xl flex items-center justify-center shadow-lg border-2 border-white relative">
                    <span class="absolute w-12 h-12 bg-red-500/30 rounded-2xl animate-ping"></span>
                    <svg class="w-5 h-5 relative z-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 23c6.075 0 11-4.925 11-11 0-4.04-2.18-7.572-5.434-9.524a.75.75 0 0 0-1.096.862C17.065 5.508 17.5 7.95 17.5 10c0 .605-.06 1.196-.176 1.767a8.96 8.96 0 0 0-3.324-2.767.75.75 0 0 0-1.077.72c.078 1.488-.363 2.981-1.282 4.108C10.59 15.12 9.297 15.75 8 15.75c-.88 0-1.725-.262-2.45-.733A6.974 6.974 0 0 1 4.5 12c0-2.316.892-4.423 2.352-6.002a.75.75 0 0 0-.58-1.222C3.132 5.378 1 8.442 1 12c0 6.075 4.925 11 11 11z"/>
                    </svg>
                </div>
                <span class="text-[9px] font-extrabold text-white bg-[#1E293B] px-2 py-0.5 rounded-md shadow mt-1 whitespace-nowrap">Titik Kejadian</span>
            </div>`,
        iconSize: [110, 55],
        iconAnchor: [55, 27]
    });
    L.marker([fireLat, fireLng], { icon: fireIcon }).addTo(map);

    // Marker Unit Damkar Bertugas
    const unitIcon = L.divIcon({
        className: 'custom-damkar-unit-tkp',
        html: `
            <div class="bg-[#1E293B] text-white px-2.5 py-1 rounded-xl shadow-md border border-slate-700 text-[9px] font-extrabold whitespace-nowrap flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
                <span>${unitKode} (${unitNama})</span>
            </div>`,
        iconSize: [150, 30],
        iconAnchor: [75, 15]
    });

    // Tempatkan unit dekat titik api (sekitar 30-40 meter)
    L.marker([fireLat + 0.0003, fireLng + 0.0002], { icon: unitIcon }).addTo(map);

    setTimeout(() => map.invalidateSize(), 300);
});
</script>
@endsection

