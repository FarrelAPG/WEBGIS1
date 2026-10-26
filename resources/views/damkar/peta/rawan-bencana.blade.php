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
    .zona-scroll::-webkit-scrollbar { width: 5px; }
    .zona-scroll::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 999px; }
    .zona-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
    .zona-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

<header class="space-y-1">
    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#E52329]">Modul Peta</p>
    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Peta Daerah Rawan Kebakaran</h1>
    <p class="text-sm text-slate-500">Sebaran zona merah berdasarkan cluster hotspot satelit VIIRS di Palembang.</p>
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

        <div id="rawan-map" aria-label="Peta zona rawan kebakaran dan titik hotspot"></div>

        <div class="flex flex-wrap items-center gap-5 border-t border-slate-100 px-4 py-3">
            <span class="flex items-center gap-2 text-[11px] font-semibold text-slate-600">
                <span class="h-3 w-3 rounded-full bg-red-600 opacity-70 ring-2 ring-red-200"></span>
                Zona Merah / Kritis (&ge; 3 hotspot)
            </span>
            <span class="flex items-center gap-2 text-[11px] font-semibold text-slate-600">
                <span class="inline-block h-3 w-3 rounded-full" style="background: radial-gradient(circle, #ff4500, #dc2626);"></span>
                Titik Hotspot
            </span>
            <span class="flex items-center gap-2 text-[11px] font-semibold text-slate-600">
                <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v3m0 14v3M2 12h3m14 0h3"/></svg>
                Centroid cluster
            </span>
            <span class="ml-auto text-[10px] text-slate-400">Sumber: dataset hotspot SNPP / VIIRS</span>
        </div>
    </div>

    <aside class="space-y-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-extrabold text-slate-800">Ringkasan Zona Rawan</h2>
            <div class="grid grid-cols-2 gap-3">
                <div class="rounded-xl bg-red-50 p-3 text-center">
                    <p class="text-2xl font-black text-[#E52329]">{{ $jumlahZonaKritis }}</p>
                    <p class="mt-0.5 text-[10px] font-bold leading-tight text-red-700">Zona<br>Kritis</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-3 text-center">
                    <p class="text-2xl font-black text-slate-700">{{ $totalHotspot }}</p>
                    <p class="mt-0.5 text-[10px] font-bold leading-tight text-slate-600">Total<br>Hotspot</p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-5 py-3.5">
                <h2 class="text-sm font-extrabold text-slate-800">Daftar Zona Rawan</h2>
                <p class="mt-0.5 text-[11px] text-slate-400">Klik sektor untuk fokus ke centroid zona</p>
            </div>
            <ol class="zona-scroll max-h-[440px] divide-y divide-slate-50 overflow-y-auto">
                @forelse ($zonaRawan as $i => $zona)
                    @php
                        $confidenceKategori = collect($zona['confidenceKategori'])
                            ->filter(fn (int $jumlah): bool => $jumlah > 0)
                            ->map(fn (int $jumlah, string $kategori): string => [
                                'l' => 'Rendah',
                                'n' => 'Nominal',
                                'h' => 'Tinggi',
                            ][$kategori].' '.$jumlah)
                            ->implode(', ');
                    @endphp
                    <li>
                        <button type="button"
                                data-zone-id="{{ $zona['id'] }}"
                                class="flex w-full items-start gap-3 px-5 py-3.5 text-left transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500">
                            <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-[#E52329] text-[11px] font-black text-white shadow-sm">
                                {{ $i + 1 }}
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block truncate text-[12px] font-extrabold text-slate-800">{{ $zona['nama'] }}</span>
                                <span class="mt-0.5 block text-[11px] leading-relaxed text-slate-500">
                                    {{ $zona['jumlah'] }} hotspot
                                    &middot; radius {{ number_format($zona['radius'] / 1000, 1) }} km
                                    &middot; FRP {{ number_format($zona['rataFrp'], 1) }} MW
                                    &middot; confidence
                                    @if ($zona['rataConfidence'] !== null)
                                        {{ number_format($zona['rataConfidence'], 1) }}%
                                    @else
                                        {{ $confidenceKategori ?: 'Tidak tersedia' }}
                                    @endif
                                </span>
                                <span class="mt-0.5 block text-[10px] text-slate-400">
                                    {{ number_format($zona['lat'], 5) }}, {{ number_format($zona['lng'], 5) }}
                                </span>
                            </span>
                            <span class="shrink-0 rounded-full bg-red-600 px-2.5 py-0.5 text-[10px] font-bold text-white shadow-sm">
                                Zona Merah
                            </span>
                        </button>
                    </li>
                @empty
                    <li class="px-5 py-8 text-center text-xs text-slate-400">Belum ada data hotspot.</li>
                @endforelse
            </ol>
        </div>

        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-[11px] text-blue-800">
            <p class="font-bold">Metodologi Zona</p>
            <p class="mt-1 leading-relaxed">Hotspot yang saling terhubung dalam jarak maksimal 5 km dikelompokkan menjadi satu sektor. Centroid dihitung dari rata-rata koordinat; radius mencakup titik terjauh ditambah buffer 500 m. Halaman ini hanya menampilkan zona merah/kritis dengan &ge; 3 hotspot.</p>
        </div>
    </aside>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
<script>
const ZONA_DATA = {{ \Illuminate\Support\Js::from($zonaRawan) }};
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
const layerMap = new Map();

// ── Ikon api untuk marker hotspot ───────────────────────────────────
const fireIcon = L.divIcon({
    html: '<div style="font-size:20px;line-height:1;filter:drop-shadow(0 1px 2px rgba(0,0,0,.35));">🔥</div>',
    className: '',
    iconSize: [20, 20],
    iconAnchor: [10, 10]
});

function clusterPopup(zona) {
    const warna = '#dc2626';
    const waktuAkuisisi = [...new Set(zona.hotspots.map((hotspot) => `${hotspot.tanggal} ${hotspot.waktu}`))].join(', ');
    const satelit = [...new Set(zona.hotspots.map((hotspot) => hotspot.satelit))].join(', ');
    const confidenceCategories = [
        ['Rendah', zona.confidenceKategori.l],
        ['Nominal', zona.confidenceKategori.n],
        ['Tinggi', zona.confidenceKategori.h]
    ].filter(([, count]) => count > 0).map(([label, count]) => `${label} ${count}`).join(', ');
    const confidence = zona.rataConfidence !== null
        ? `${zona.rataConfidence.toFixed(1)}%`
        : (confidenceCategories || 'Tidak tersedia');

    return `<div style="min-width:210px;font-family:sans-serif;font-size:12px;">
        <p style="font-weight:800;font-size:13px;margin:0 0 6px;">${escapeHtml(zona.nama)}</p>
        <table style="width:100%;border-collapse:collapse;">
            <tr><td style="color:#64748b;padding:2px 0;">Hotspot</td><td style="font-weight:700;padding:2px 0;">${zona.jumlah} titik</td></tr>
            <tr><td style="color:#64748b;padding:2px 0;">Akuisisi</td><td style="font-weight:700;padding:2px 0;">${escapeHtml(waktuAkuisisi)}</td></tr>
            <tr><td style="color:#64748b;padding:2px 0;">Satelit</td><td style="font-weight:700;padding:2px 0;">${escapeHtml(satelit)}</td></tr>
            <tr><td style="color:#64748b;padding:2px 0;">Radius</td><td style="font-weight:700;padding:2px 0;">${(zona.radius / 1000).toFixed(1)} km</td></tr>
            <tr><td style="color:#64748b;padding:2px 0;">Rata-rata FRP</td><td style="font-weight:700;padding:2px 0;">${zona.rataFrp.toFixed(1)} MW</td></tr>
            <tr><td style="color:#64748b;padding:2px 0;">Confidence</td><td style="font-weight:700;padding:2px 0;">${escapeHtml(confidence)}</td></tr>
            <tr><td style="color:#64748b;padding:2px 0;">Koordinat</td><td style="font-weight:700;padding:2px 0;">${zona.lat.toFixed(5)}, ${zona.lng.toFixed(5)}</td></tr>
            <tr><td style="color:#64748b;padding:2px 0;">Status</td><td style="color:${warna};font-weight:700;padding:2px 0;">Zona Merah / Kritis</td></tr>
        </table>
    </div>`;
}

function hotspotPopup(hotspot) {
    const confidenceLabels = { l: 'Rendah (l)', n: 'Nominal (n)', h: 'Tinggi (h)' };
    const confidence = hotspot.confidence !== null
        ? `${hotspot.confidence.toFixed(0)}%`
        : (confidenceLabels[hotspot.confidenceKategori] || 'Tidak tersedia');

    return `<div style="min-width:190px;font-family:sans-serif;font-size:12px;">
        <p style="font-weight:800;font-size:13px;margin:0 0 6px;">🔥 Hotspot ${escapeHtml(hotspot.satelit)}</p>
        <table style="width:100%;border-collapse:collapse;">
            <tr><td style="color:#64748b;padding:2px 0;">Akuisisi</td><td style="font-weight:700;padding:2px 0;">${escapeHtml(hotspot.tanggal)} ${escapeHtml(hotspot.waktu)}</td></tr>
            <tr><td style="color:#64748b;padding:2px 0;">FRP</td><td style="font-weight:700;padding:2px 0;">${hotspot.frp.toFixed(1)} MW</td></tr>
            <tr><td style="color:#64748b;padding:2px 0;">Confidence</td><td style="font-weight:700;padding:2px 0;">${escapeHtml(confidence)}</td></tr>
            <tr><td style="color:#64748b;padding:2px 0;">Koordinat</td><td style="font-weight:700;padding:2px 0;">${hotspot.lat.toFixed(5)}, ${hotspot.lng.toFixed(5)}</td></tr>
        </table>
    </div>`;
}

// ── Render zona cluster (lingkaran merah + centroid) ────────────────
ZONA_DATA.forEach((zona) => {
    const warna = '#dc2626';
    const layer = L.layerGroup();
    const circle = L.circle([zona.lat, zona.lng], {
        radius: zona.radius,
        color: warna,
        weight: 2,
        fillColor: warna,
        fillOpacity: 0.15
    }).bindPopup(clusterPopup(zona));

    const centroidIcon = L.divIcon({
        html: `<div style="color:${warna};font-size:25px;font-weight:800;line-height:24px;text-shadow:0 0 2px white,0 0 4px white;">⌖</div>`,
        className: '',
        iconSize: [24, 24],
        iconAnchor: [12, 12]
    });
    const centroid = L.marker([zona.lat, zona.lng], { icon: centroidIcon })
        .bindPopup(clusterPopup(zona));

    layer.addLayer(circle);
    layer.addLayer(centroid);
    layer.addTo(map);
    layerMap.set(zona.id, { layer, centroid, zona });
});

// ── Render semua hotspot sebagai marker api 🔥 ─────────────────────
ALL_HOTSPOTS.forEach((hotspot) => {
    L.marker([hotspot.lat, hotspot.lng], { icon: fireIcon })
        .bindPopup(hotspotPopup(hotspot))
        .addTo(map);
});

function focusZona(id) {
    const item = layerMap.get(Number(id));

    if (!item) {
        return;
    }

    map.flyTo([item.zona.lat, item.zona.lng], 14, { duration: 0.8 });
    item.centroid.openPopup();
}

document.querySelectorAll('[data-zone-id]').forEach((button) => {
    button.addEventListener('click', () => focusZona(button.dataset.zoneId));
});
</script>
@endsection
