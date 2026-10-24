@extends('layouts.damkar')

@section('judul', 'Peta Rawan Bencana — Operasional Lapangan')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<style>#rawan-map { min-height: 520px; } #rawan-map .leaflet-tile-container img { max-width: none !important; max-height: none !important; }</style>

<header class="space-y-1"><p class="text-xs font-bold uppercase tracking-[0.18em] text-[#E52329]">Modul Peta</p><h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Peta Daerah Rawan Kebakaran</h1><p class="text-sm text-slate-500">Pemetaan zonasi risiko kebakaran berdasarkan riwayat insiden.</p></header>
@include('damkar.peta._navigation')

<section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_330px]"><div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"><div id="rawan-map" aria-label="Peta zona rawan kebakaran"></div><div class="flex items-center gap-4 border-t border-slate-100 px-4 py-3 text-[11px] font-semibold text-slate-500"><span class="flex items-center gap-2"><i class="h-2.5 w-2.5 rounded-full bg-red-600"></i>Risiko tinggi</span><span class="flex items-center gap-2"><i class="h-2.5 w-2.5 rounded-full bg-amber-500"></i>Risiko sedang</span></div></div><aside class="space-y-4"><div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><h2 class="text-sm font-extrabold text-slate-800">Top 2 Wilayah Paling Rawan</h2><ol class="mt-4 space-y-3">@forelse ($zonaRawan->take(2) as $peringkat => $zona)<li class="flex items-center gap-3 rounded-xl bg-slate-50 p-3"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#E52329] text-sm font-black text-white">{{ $peringkat + 1 }}</span><div class="min-w-0"><p class="text-xs font-extrabold text-slate-800">{{ $zona->nama }}</p><p class="text-[11px] text-slate-500">{{ $zona->jumlah_kejadian }} kejadian{{ $zona->ciri ? ' • '.ucfirst($zona->ciri) : '' }}</p></div><span class="ml-auto shrink-0 rounded-md bg-red-50 px-2 py-1 text-[10px] font-bold text-red-700">{{ $zona->risikoTinggi() ? 'Risiko Tinggi' : 'Risiko Sedang' }}</span></li>@empty<li class="rounded-xl bg-slate-50 p-3 text-xs text-slate-500">Belum ada data zona rawan.</li>@endforelse</ol></div><div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><h2 class="text-sm font-extrabold text-slate-800">Ringkasan Risiko</h2><p class="mt-2 text-3xl font-black text-[#E52329]">{{ $zonaRawan->filter(fn ($zona) => $zona->risikoTinggi())->count() }}</p><p class="text-xs text-slate-500">zona dengan status kritis</p></div></aside></section>

@php
    $zonaData = $zonaRawan->map(fn ($zona) => [
        'lat' => (float) $zona->latitude,
        'lng' => (float) $zona->longitude,
        'radius' => (float) $zona->radius_m,
        'nama' => $zona->nama,
        'jumlah' => (int) $zona->jumlah_kejadian,
        'tinggi' => $zona->risikoTinggi(),
    ])->values()->toJson();
@endphp
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script><script>
const zonaRawan = {!! $zonaData !!}; const map = L.map('rawan-map', { zoomControl: false }).setView([-2.975, 104.76], 12); L.control.zoom({ position: 'bottomright' }).addTo(map); L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap' }).addTo(map); const bounds = []; zonaRawan.forEach((zona) => { const warna = zona.tinggi ? '#dc2626' : '#f59e0b'; const lingkaran = L.circle([zona.lat, zona.lng], { radius: zona.radius, color: warna, weight: 2, fillColor: warna, fillOpacity: .22 }).addTo(map).bindPopup(`<strong>${zona.nama}</strong><br>${zona.jumlah} kejadian`); L.marker([zona.lat, zona.lng]).addTo(map).bindPopup(`<strong>${zona.nama}</strong>`); bounds.push(lingkaran.getLatLng()); }); if (bounds.length) map.fitBounds(L.latLngBounds(bounds).pad(.3));
</script>
@endsection
