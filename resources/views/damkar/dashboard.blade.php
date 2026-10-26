@extends('layouts.damkar')

@section('judul', 'Dashboard — Operasional Lapangan')

@section('content')
<!-- CSS Leaflet OpenStreetMap -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />

<style>
    #osm-map .leaflet-tile-container img {
        max-width: none !important;
        max-height: none !important;
    }
    .leaflet-control-zoom-in, .leaflet-control-zoom-out {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-decoration: none !important;
    }
</style>

<!-- Top Bar Header -->
<div class="flex items-center justify-between">
    <div>
        <div class="mb-1 flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-500">
            <svg class="h-4 w-4 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
            </svg>
            <span>Semua Pos — Palembang</span>
        </div>
        <span class="block text-[10px] font-extrabold uppercase tracking-widest text-slate-400">PEMANTAUAN TERKINI</span>
        <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">Operasional Lapangan</h2>
    </div>
</div>

<!-- Cards Statistik Row -->
<div class="grid grid-cols-3 gap-5">
    <!-- Stat 1: Laporan Baru -->
    <div class="flex items-center justify-between rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
        <div>
            <p class="text-xs font-bold text-slate-500">Laporan Baru</p>
            <h3 class="mt-1 text-3xl font-extrabold text-slate-900">{{ $statistik['laporan_baru'] }}</h3>
        </div>
        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-100/70 text-[#E52329]">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </div>
    </div>

    <!-- Stat 2: Kebakaran Aktif -->
    <div class="flex items-center justify-between rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
        <div>
            <p class="text-xs font-bold text-slate-500">Kebakaran Aktif</p>
            <h3 class="mt-1 text-3xl font-extrabold text-slate-900">{{ $statistik['kebakaran_aktif'] }}</h3>
        </div>
        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#E52329] text-white shadow-sm">
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 23c6.075 0 11-4.925 11-11 0-4.04-2.18-7.572-5.434-9.524a.75.75 0 0 0-1.096.862C17.065 5.508 17.5 7.95 17.5 10c0 .605-.06 1.196-.176 1.767a8.96 8.96 0 0 0-3.324-2.767.75.75 0 0 0-1.077.72c.078 1.488-.363 2.981-1.282 4.108C10.59 15.12 9.297 15.75 8 15.75c-.88 0-1.725-.262-2.45-.733A6.974 6.974 0 0 1 4.5 12c0-2.316.892-4.423 2.352-6.002a.75.75 0 0 0-.58-1.222C3.132 5.378 1 8.442 1 12c0 6.075 4.925 11 11 11z"/>
            </svg>
        </div>
    </div>

    <!-- Stat 3: Kendaraan Siap -->
    <div class="flex items-center justify-between rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
        <div>
            <p class="text-xs font-bold text-slate-500">Kendaraan Siap</p>
            <h3 class="mt-1 text-3xl font-extrabold text-slate-900">{{ $statistik['kendaraan_siap'] }}</h3>
        </div>
        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100/70 text-blue-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 17h14M7 17V8h10l2 4h1v5M9 17a2 2 0 11-4 0m14 0a2 2 0 11-4 0M7 8l1.5-3h7L17 8"/>
            </svg>
        </div>
    </div>
</div>

<!-- Grid Layout: Peta Monitoring (2/3) & Laporan Terbaru (1/3) -->
<div class="grid grid-cols-3 gap-6">

    <!-- Kolom Peta OpenStreetMap -->
    <div class="col-span-2 relative h-[520px] overflow-hidden rounded-3xl border border-slate-100 bg-white p-3 shadow-sm">
        <div id="osm-map" class="z-0 h-full w-full rounded-2xl"></div>

        <!-- Legend Pos Damkar -->
        <div class="absolute bottom-6 left-6 z-10">
            <span class="inline-flex items-center gap-2 rounded-xl border border-slate-200/80 bg-white/95 px-3.5 py-2 text-xs font-bold text-slate-800 shadow-md backdrop-blur-md">
                <span class="h-3 w-3 rounded-full bg-[#E52329] ring-2 ring-red-200"></span>
                Pos Pemadam Kebakaran
            </span>
        </div>
    </div>

    <!-- Kolom Laporan Terbaru -->
    <div class="col-span-1 space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-extrabold text-slate-900">Laporan Terbaru</h3>
            <span id="label-jumlah-antrean" class="text-xs font-bold text-slate-400">{{ $laporanTerbaru->count() }} Antrean</span>
        </div>

        <div id="wadah-antrean-kosong" class="{{ $laporanTerbaru->isEmpty() ? '' : 'hidden' }} rounded-2xl border border-dashed border-slate-200 bg-white p-6 text-center space-y-3">
            <p class="text-sm font-semibold text-slate-400">Belum ada antrean laporan.</p>
            <form method="POST" action="{{ route('damkar.reset-demo') }}" onsubmit="return confirm('Kembalikan semua laporan ke status menunggu dan semua kendaraan ke siaga?')">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition-colors shadow-sm">
                    <svg class="w-3.5 h-3.5 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>Munculkan Ulang Laporan Demo</span>
                </button>
            </form>
        </div>

        <div id="wadah-daftar-laporan" class="space-y-3">
            @foreach ($laporanTerbaru as $laporan)
                <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm space-y-3">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <span class="text-[10px] font-bold uppercase text-slate-400">Lokasi Kejadian</span>
                            <h4 class="mt-0.5 text-sm font-bold leading-snug text-slate-900">{{ $laporan->alamat }}</h4>
                        </div>
                        @include('damkar.partials.status-badge', ['status' => $laporan->status])
                    </div>

                    <div class="flex items-center gap-1.5 text-[11px] font-medium text-slate-400">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ $laporan->created_at->format('H:i') }} WIB <span class="text-slate-400">({{ $laporan->created_at->diffForHumans() }})</span></span>
                    </div>

                    <a href="{{ route('damkar.laporan.show', $laporan) }}" class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#E52329] px-3 py-2.5 text-xs font-bold text-white shadow-sm transition-colors hover:bg-red-700">
                        <span>Lihat Detail &amp; Kirim Tim</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

</div>

<!-- JS Leaflet OpenStreetMap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const posDamkarList = @json($posDamkarList);

        const map = L.map('osm-map', {
            zoomControl: true,
            scrollWheelZoom: true
        }).setView([-2.985, 104.755], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const redIcon = L.divIcon({
            className: 'custom-div-icon',
            html: `<div style="
                background-color: #E52329;
                width: 26px;
                height: 26px;
                border-radius: 50%;
                border: 3px solid #ffffff;
                box-shadow: 0 3px 8px rgba(0,0,0,0.3);
                display: flex;
                align-items: center;
                justify-content: center;
            ">
                <div style="background-color: #ffffff; width: 8px; height: 8px; border-radius: 50%;"></div>
            </div>`,
            iconSize: [26, 26],
            iconAnchor: [13, 13],
            popupAnchor: [0, -13]
        });

        posDamkarList.forEach(pos => {
            if (pos.latitude && pos.longitude) {
                const marker = L.marker([pos.latitude, pos.longitude], { icon: redIcon }).addTo(map);
                marker.bindPopup(`
                    <div style="font-family: sans-serif; padding: 2px;">
                        <span style="font-size: 10px; font-weight: 700; color: #E52329; text-transform: uppercase;">${pos.unit}</span>
                        <h4 style="margin: 2px 0; font-size: 13px; font-weight: 800; color: #0f172a;">${pos.nama}</h4>
                        <p style="margin: 0; font-size: 11px; color: #64748b; line-height: 1.3;">${pos.alamat}</p>
                    </div>
                `);
            }
        });

        setTimeout(() => {
            map.invalidateSize();
        }, 300);
    });
</script>
@endsection
