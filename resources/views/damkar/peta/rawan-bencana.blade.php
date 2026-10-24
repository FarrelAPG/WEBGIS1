@extends('layouts.damkar')

@section('judul', 'Peta Rawan Kebakaran — Operasional Lapangan')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<style>
    #rawan-map {
        min-height: 520px;
        border-radius: 0.75rem;
    }
    #rawan-map .leaflet-tile-container img {
        max-width: none !important;
        max-height: none !important;
    }
    /* Custom scrollbar */
    .zona-scroll::-webkit-scrollbar { width: 5px; }
    .zona-scroll::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 999px; }
    .zona-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
    .zona-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

{{-- ── Header ── --}}
<header class="space-y-1">
    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#E52329]">Modul Peta</p>
    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Peta Daerah Rawan Kebakaran</h1>
    <p class="text-sm text-slate-500">Zonasi risiko kebakaran lahan & hutan berdasarkan data hotspot terkini dari BMKG/Karhutla.</p>
</header>

@include('damkar.peta._navigation')

@php
    $zonaData = $zonaRawan->map(fn ($z) => [
        'id'      => $z->id,
        'lat'     => (float) $z->latitude,
        'lng'     => (float) $z->longitude,
        'radius'  => (int)   $z->radius_m,
        'nama'    => $z->nama,
        'ciri'    => $z->ciri ?? '',
        'jumlah'  => (int)   $z->jumlah_kejadian,
        'tinggi'  => $z->risikoTinggi(),
    ])->values()->toJson();
@endphp

{{-- ── Layout 2 kolom ── --}}
<section class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_340px]">

    {{-- ── Peta ── --}}
    <div class="flex flex-col gap-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        {{-- Toolbar filter --}}
        <div class="flex flex-wrap items-center gap-3 border-b border-slate-100 px-4 py-3">
            <span class="text-xs font-bold text-slate-700">Filter Risiko:</span>
            <label class="flex cursor-pointer items-center gap-1.5 text-xs font-semibold text-slate-600">
                <input type="checkbox" id="filter-tinggi" checked class="h-3.5 w-3.5 rounded accent-red-600"> Risiko Tinggi
            </label>
            <label class="flex cursor-pointer items-center gap-1.5 text-xs font-semibold text-slate-600">
                <input type="checkbox" id="filter-sedang" checked class="h-3.5 w-3.5 rounded accent-amber-500"> Risiko Sedang
            </label>
            <div class="ml-auto flex items-center gap-1 text-[11px] text-slate-400">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 8v4l3 3"/></svg>
                Data: {{ \Carbon\Carbon::now()->format('d M Y') }}
            </div>
        </div>

        {{-- Map container --}}
        <div id="rawan-map" aria-label="Peta zona rawan kebakaran"></div>

        {{-- Legenda --}}
        <div class="flex flex-wrap items-center gap-5 border-t border-slate-100 px-4 py-3">
            <span class="flex items-center gap-2 text-[11px] font-semibold text-slate-600">
                <span class="h-3 w-3 rounded-full bg-red-600 opacity-70 ring-2 ring-red-200"></span>
                Risiko Tinggi (≥ 3 hotspot)
            </span>
            <span class="flex items-center gap-2 text-[11px] font-semibold text-slate-600">
                <span class="h-3 w-3 rounded-full bg-amber-500 opacity-70 ring-2 ring-amber-200"></span>
                Risiko Sedang (1–2 hotspot)
            </span>
            <span class="flex items-center gap-2 text-[11px] font-semibold text-slate-600">
                <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="4"/><path d="M12 2v3m0 14v3M2 12h3m14 0h3"/></svg>
                Centroid cluster
            </span>
            <span class="ml-auto text-[10px] text-slate-400">
                Sumber: Data Karhutla Sumsel {{ \Carbon\Carbon::now()->year }}
            </span>
        </div>
    </div>

    {{-- ── Sidebar info ── --}}
    <aside class="space-y-4">

        {{-- Ringkasan statistik --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-extrabold text-slate-800">Ringkasan Hotspot</h2>
            <div class="grid grid-cols-3 gap-3">
                <div class="rounded-xl bg-red-50 p-3 text-center">
                    <p class="text-2xl font-black text-[#E52329]">{{ $zonaRawan->where('jumlah_kejadian', '>=', 3)->count() }}</p>
                    <p class="mt-0.5 text-[10px] font-bold text-red-700 leading-tight">Zona<br>Kritis</p>
                </div>
                <div class="rounded-xl bg-amber-50 p-3 text-center">
                    <p class="text-2xl font-black text-amber-600">{{ $zonaRawan->where('jumlah_kejadian', '<', 3)->count() }}</p>
                    <p class="mt-0.5 text-[10px] font-bold text-amber-700 leading-tight">Zona<br>Sedang</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-3 text-center">
                    <p class="text-2xl font-black text-slate-700">{{ $zonaRawan->sum('jumlah_kejadian') }}</p>
                    <p class="mt-0.5 text-[10px] font-bold text-slate-600 leading-tight">Total<br>Hotspot</p>
                </div>
            </div>
        </div>

        {{-- Daftar zona – scrollable --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-5 py-3.5">
                <h2 class="text-sm font-extrabold text-slate-800">Daftar Zona Rawan</h2>
                <p class="text-[11px] text-slate-400 mt-0.5">Klik nama zona untuk fokus ke peta</p>
            </div>
            <ol class="zona-scroll max-h-[440px] divide-y divide-slate-50 overflow-y-auto">
                @forelse ($zonaRawan->sortByDesc('jumlah_kejadian') as $i => $zona)
                @php
                    $tinggi   = $zona->risikoTinggi();
                    $warnaBg  = $tinggi ? 'bg-red-50' : 'bg-amber-50';
                    $warnaTag = $tinggi ? 'bg-red-600 text-white' : 'bg-amber-500 text-white';
                    $labelTag = $tinggi ? 'Kritis' : 'Sedang';
                @endphp
                <li>
                    <button type="button"
                            onclick="focusZona({{ $zona->id }})"
                            class="flex w-full items-start gap-3 px-5 py-3.5 text-left transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500">
                        <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-lg {{ $tinggi ? 'bg-[#E52329]' : 'bg-amber-500' }} text-[11px] font-black text-white shadow-sm">
                            {{ $i + 1 }}
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-[12px] font-extrabold text-slate-800">{{ $zona->nama }}</p>
                            <p class="mt-0.5 text-[11px] text-slate-500">
                                {{ $zona->jumlah_kejadian }} hotspot
                                · radius {{ number_format($zona->radius_m / 1000, 1) }} km
                                @if($zona->ciri)· {{ $zona->ciri }}@endif
                            </p>
                        </div>
                        <span class="shrink-0 rounded-full {{ $warnaTag }} px-2.5 py-0.5 text-[10px] font-bold shadow-sm">
                            {{ $labelTag }}
                        </span>
                    </button>
                </li>
                @empty
                <li class="px-5 py-8 text-center text-xs text-slate-400">Belum ada data zona rawan.</li>
                @endforelse
            </ol>
        </div>

        {{-- Info metodologi --}}
        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-[11px] text-blue-800">
            <p class="font-bold">ℹ️ Metodologi Zona</p>
            <p class="mt-1 leading-relaxed">Titik-titik hotspot dikelompokkan (clustering) berdasarkan jarak ≤ 5 km. Radius buffer = jangkauan max titik terluar + 500 m cadangan. Risiko tinggi bila terdapat ≥ 3 hotspot dalam satu zona.</p>
        </div>

    </aside>
</section>

{{-- ── Script Leaflet ── --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
<script>
const ZONA_DATA = {!! $zonaData !!};

const map = L.map('rawan-map', { zoomControl: false }).setView([-3.2, 104.95], 9);
L.control.zoom({ position: 'bottomright' }).addTo(map);

// Basemap OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© <a href="https://openstreetmap.org">OpenStreetMap</a>'
}).addTo(map);

// Simpan layer per zona untuk filtering & focusZona
const layerMap = {};   // id → { circle, marker }
const bounds   = [];

ZONA_DATA.forEach(zona => {
    const warna   = zona.tinggi ? '#dc2626' : '#f59e0b';
    const warnaRg = zona.tinggi ? 'rgba(220,38,38,.18)' : 'rgba(245,158,11,.18)';

    // Lingkaran buffer radius
    const circle = L.circle([zona.lat, zona.lng], {
        radius:      zona.radius,
        color:       warna,
        weight:      2,
        fillColor:   warna,
        fillOpacity: 0.18,
    }).addTo(map);

    // Popup detail
    const popupHtml = `
        <div style="min-width:200px;font-family:sans-serif;font-size:12px;">
            <p style="font-weight:800;font-size:13px;margin:0 0 4px;">${zona.nama}</p>
            <table style="width:100%;border-collapse:collapse;">
                <tr><td style="color:#64748b;padding:2px 0;">Hotspot</td><td style="font-weight:700;padding:2px 0;">${zona.jumlah} titik</td></tr>
                <tr><td style="color:#64748b;padding:2px 0;">Radius zona</td><td style="font-weight:700;padding:2px 0;">${(zona.radius/1000).toFixed(1)} km</td></tr>
                <tr><td style="color:#64748b;padding:2px 0;">Status</td>
                    <td style="padding:2px 0;"><span style="background:${warna};color:#fff;border-radius:999px;padding:1px 8px;font-weight:700;font-size:10px;">${zona.tinggi ? 'Risiko Tinggi' : 'Risiko Sedang'}</span></td></tr>
                ${zona.ciri ? `<tr><td style="color:#64748b;padding:2px 0;">Ciri</td><td style="font-weight:600;padding:2px 0;">${zona.ciri}</td></tr>` : ''}
            </table>
        </div>`;

    circle.bindPopup(popupHtml, { maxWidth: 260 });

    // Marker centroid
    const centroidIcon = L.divIcon({
        html: `<div style="width:12px;height:12px;background:${warna};border:2px solid #fff;border-radius:50%;box-shadow:0 0 0 2px ${warna}55;"></div>`,
        className: '',
        iconSize: [12, 12],
        iconAnchor: [6, 6],
    });
    const marker = L.marker([zona.lat, zona.lng], { icon: centroidIcon }).addTo(map);
    marker.bindPopup(popupHtml, { maxWidth: 260 });

    layerMap[zona.id] = { circle, marker, zona };
    bounds.push([zona.lat, zona.lng]);
});

// Auto-fit bounds
if (bounds.length) {
    map.fitBounds(L.latLngBounds(bounds).pad(0.3));
}

// Fokus ke zona dari sidebar
function focusZona(id) {
    const item = layerMap[id];
    if (!item) return;
    map.fitBounds(item.circle.getBounds().pad(0.2));
    item.circle.openPopup();
}

// Filter checkbox
function updateFilter() {
    const tampilTinggi = document.getElementById('filter-tinggi').checked;
    const tampilSedang = document.getElementById('filter-sedang').checked;
    Object.values(layerMap).forEach(({ circle, marker, zona }) => {
        const tampil = zona.tinggi ? tampilTinggi : tampilSedang;
        if (tampil) {
            if (!map.hasLayer(circle)) { map.addLayer(circle); map.addLayer(marker); }
        } else {
            if (map.hasLayer(circle)) { map.removeLayer(circle); map.removeLayer(marker); }
        }
    });
}

document.getElementById('filter-tinggi').addEventListener('change', updateFilter);
document.getElementById('filter-sedang').addEventListener('change', updateFilter);
</script>
@endsection
