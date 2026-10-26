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
</style>

<header class="space-y-1">
    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#E52329]">Modul Peta</p>
    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Peta Daerah Rawan Kebakaran</h1>
    <p class="text-sm text-slate-500">Sebaran titik hotspot satelit VIIRS di wilayah Palembang.</p>
</header>

@include('damkar.peta._navigation')

<section class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_340px]">
    <div class="flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-wrap items-center gap-3 border-b border-slate-100 px-4 py-3">
            <form method="GET" action="{{ route('damkar.peta.rawan-bencana') }}" class="flex items-center gap-2">
                <label for="filter-bulan" class="text-xs font-bold text-slate-700">Bulan:</label>
                <select id="filter-bulan"
                        name="month"
                        onchange="this.form.submit()"
                        class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 focus:border-red-400 focus:outline-none focus:ring-2 focus:ring-red-100">
                    @foreach ($monthOptions as $month => $label)
                        <option value="{{ $month }}" @selected($selectedMonth === $month)>{{ $label }}</option>
                    @endforeach
                </select>
            </form>
            <span class="ml-auto text-[11px] text-slate-400">
                Hotspot bulan terpilih:
                {{ $tanggalDataset ?: 'Tidak tersedia' }}
            </span>
        </div>

        <div id="rawan-map" aria-label="Peta sebaran titik hotspot rawan kebakaran"></div>

        <div class="flex flex-wrap items-center gap-5 border-t border-slate-100 px-4 py-3">
            <span class="flex items-center gap-2 text-[11px] font-semibold text-slate-600">
                <span class="inline-block h-3 w-3 rounded-full bg-red-600 ring-2 ring-red-200"></span>
                Titik Hotspot (Satelit VIIRS)
            </span>
            <span class="ml-auto text-[10px] text-slate-400">Sumber: dataset hotspot SNPP / VIIRS</span>
        </div>
    </div>

    <aside class="space-y-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-extrabold text-slate-800">Ringkasan Hotspot</h2>
            <div class="grid grid-cols-2 gap-3">
                <div class="rounded-xl bg-red-50 p-3 text-center">
                    <p class="text-2xl font-black text-[#E52329]">{{ $totalHotspot }}</p>
                    <p class="mt-0.5 text-[10px] font-bold leading-tight text-red-700">Total<br>Titik Hotspot</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-3 text-center">
                    <p class="text-sm font-black text-slate-700 mt-1">{{ $selectedMonth ?: '-' }}</p>
                    <p class="mt-1 text-[10px] font-bold leading-tight text-slate-600">Periode<br>Bulan</p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-[11px] text-blue-800">
            <p class="font-bold">Informasi Sebaran Titik Panas</p>
            <p class="mt-1 leading-relaxed">Peta ini menampilkan setiap titik indikasi kebakaran (hotspot) secara murni dan individual. Klik pada setiap titik merah untuk melihat detail koordinat, tanggal akuisisi, tingkat kepercayaan (confidence), dan nilai FRP.</p>
        </div>
    </aside>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
<script>
const ALL_HOTSPOTS = {{ \Illuminate\Support\Js::from($hotspots) }};

// Peta terpusat di Kota Palembang
const map = L.map('rawan-map', { zoomControl: false }).setView([-2.9761, 104.7754], 12);
L.control.zoom({ position: 'bottomright' }).addTo(map);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a>'
}).addTo(map);

const escapeHtml = (value) => String(value).replace(/[&<>"']/g, (character) => ({
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
}[character]));

function hotspotPopup(hotspot) {
    const confidenceLabels = { l: 'Rendah (l)', n: 'Nominal (n)', h: 'Tinggi (h)' };
    const confidence = hotspot.confidence !== null
        ? `${hotspot.confidence.toFixed(0)}%`
        : (confidenceLabels[hotspot.confidenceKategori] || 'Tidak tersedia');

    return `<div style="min-width:200px;font-family:sans-serif;font-size:12px;line-height:1.4;">
        <div style="font-weight:800;font-size:13px;color:#dc2626;margin-bottom:8px;padding-bottom:4px;border-bottom:1px solid #fee2e2;">
            🔥 Titik Panas Hotspot
        </div>
        <table style="width:100%;border-collapse:collapse;font-size:11.5px;">
            <tr>
                <td style="color:#64748b;padding:3px 0;width:90px;">Latitude</td>
                <td style="font-weight:700;color:#1e293b;padding:3px 0;">${hotspot.lat.toFixed(5)}</td>
            </tr>
            <tr>
                <td style="color:#64748b;padding:3px 0;">Longitude</td>
                <td style="font-weight:700;color:#1e293b;padding:3px 0;">${hotspot.lng.toFixed(5)}</td>
            </tr>
            <tr>
                <td style="color:#64748b;padding:3px 0;">Tanggal</td>
                <td style="font-weight:700;color:#1e293b;padding:3px 0;">${escapeHtml(hotspot.tanggal)}</td>
            </tr>
            <tr>
                <td style="color:#64748b;padding:3px 0;">Waktu</td>
                <td style="font-weight:600;color:#1e293b;padding:3px 0;">${escapeHtml(hotspot.waktu)}</td>
            </tr>
            <tr>
                <td style="color:#64748b;padding:3px 0;">Confidence</td>
                <td style="font-weight:700;color:#0284c7;padding:3px 0;">${escapeHtml(confidence)}</td>
            </tr>
            <tr>
                <td style="color:#64748b;padding:3px 0;">FRP</td>
                <td style="font-weight:700;color:#dc2626;padding:3px 0;">${hotspot.frp.toFixed(1)} MW</td>
            </tr>
            <tr>
                <td style="color:#64748b;padding:3px 0;">Satelit</td>
                <td style="font-weight:600;color:#475569;padding:3px 0;">${escapeHtml(hotspot.satelit)}</td>
            </tr>
        </table>
    </div>`;
}

// ── Render setiap titik hotspot sebagai L.circleMarker individual ───
ALL_HOTSPOTS.forEach((hotspot) => {
    L.circleMarker([hotspot.lat, hotspot.lng], {
        radius: 4.5,
        color: '#b91c1c',
        weight: 1.5,
        fillColor: '#ef4444',
        fillOpacity: 0.85
    })
    .bindPopup(hotspotPopup(hotspot))
    .addTo(map);
});
</script>
@endsection
