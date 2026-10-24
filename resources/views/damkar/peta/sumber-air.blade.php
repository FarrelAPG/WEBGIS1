@extends('layouts.damkar')

@section('judul', 'Peta Sumber Air — Operasional Lapangan')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<style>
    #sumber-air-map { min-height: 620px; }
    #sumber-air-map .leaflet-tile-container img { max-width: none !important; max-height: none !important; }
    .custom-scroll::-webkit-scrollbar { width: 6px; }
    .custom-scroll::-webkit-scrollbar-track { background: #f8fafc; border-radius: 9999px; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
    .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

<header class="space-y-2">
    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#E52329]">Modul Peta</p>
    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Sumber Air</h1>
    <p class="text-sm text-slate-500">Titik sumber air sementara di sekitar wilayah Palembang untuk kebutuhan pemetaan awal.</p>
    <div class="inline-flex items-center gap-2 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-[11px] font-semibold text-amber-800">
        <span>!</span> Data simulasi — seluruh titik perlu diverifikasi sebelum digunakan operasional.
    </div>
</header>

@include('damkar.peta._navigation')

<section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div id="sumber-air-map" aria-label="Peta sumber air"></div>
    </div>
    <aside class="flex max-h-[620px] flex-col rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-3 shrink-0">
            <h2 class="text-sm font-extrabold text-slate-800">Daftar Sumber Air</h2>
            <span class="rounded-full bg-red-50 px-2.5 py-1 text-[10px] font-bold text-red-600">{{ count($sumberAir) }} lokasi</span>
        </div>
        <div class="custom-scroll mt-3 flex-1 space-y-3 overflow-y-auto pr-1.5">
            @foreach ($sumberAir as $sumber)
                <button type="button" class="source-item flex w-full items-start gap-3 rounded-xl bg-slate-50 p-3 text-left transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500/20" data-lat="{{ $sumber['latitude'] }}" data-lng="{{ $sumber['longitude'] }}">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-700 text-white text-xs font-bold">⌖</span>
                    <span class="min-w-0 flex-1">
                        <strong class="block text-xs font-bold text-slate-800 leading-snug">{{ $sumber['nama'] }}</strong>
                        <span class="mt-1 block text-[11px] text-slate-500 leading-tight">{{ $sumber['alamat'] }}</span>
                        <span class="mt-2 flex flex-wrap items-center gap-1.5">
                            <span class="rounded bg-slate-200/80 px-1.5 py-0.5 text-[10px] font-semibold text-slate-700">{{ $sumber['jenis'] }}</span>
                            <span class="rounded bg-emerald-100 px-1.5 py-0.5 text-[10px] font-bold text-emerald-700">{{ $sumber['status'] }}</span>
                        </span>
                    </span>
                </button>
            @endforeach
        </div>
    </aside>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
<script>
    const sumberAir = @json($sumberAir);
    const map = L.map('sumber-air-map', { zoomControl: false }).setView([-2.991, 104.765], 12);
    L.control.zoom({ position: 'bottomright' }).addTo(map);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap' }).addTo(map);
    const markerBounds = [];
    sumberAir.forEach((sumber) => {
        const marker = L.marker([sumber.latitude, sumber.longitude])
            .addTo(map)
            .bindPopup(`<strong>${sumber.nama}</strong><br>${sumber.jenis}<br>${sumber.alamat}<br><em>${sumber.status}</em>`);
        markerBounds.push(marker.getLatLng());
    });
    if (markerBounds.length) {
        map.fitBounds(L.latLngBounds(markerBounds).pad(0.25));
    }
    document.querySelectorAll('.source-item').forEach((item) => {
        item.addEventListener('click', () => {
            map.setView([item.dataset.lat, item.dataset.lng], 16);
        });
    });
</script>
@endsection
