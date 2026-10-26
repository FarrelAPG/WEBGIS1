@extends('layouts.damkar')

@section('judul', 'Peta — Operasional Lapangan')
@section('main-class', 'flex-1 space-y-6 overflow-y-auto p-8')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<style>
    #jangkauan-map { min-height: 520px; }
    #jangkauan-map .leaflet-tile-container img { max-width: none !important; max-height: none !important; }
</style>

<header class="space-y-1">
    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#E52329]">Modul Peta</p>
    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Peta Area Jangkauan Pos Pemadam</h1>
    <p class="text-sm text-slate-500">Wilayah yang dapat dicapai dari pos terpilih berdasarkan waktu tempuh lewat jalan raya.</p>
</header>

@include('damkar.peta._navigation')

<section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_310px]">
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 p-4">
            <div class="flex flex-wrap items-center gap-2">
                <label for="pos-select" class="sr-only">Pilih pos pemadam</label>
                <select id="pos-select" class="rounded-lg border-slate-200 py-2 pl-3 pr-9 text-xs font-semibold text-slate-700 focus:border-red-500 focus:ring-red-500">
                    <option value="">Pilih pos untuk melihat jangkauan…</option>
                    @foreach ($posDamkarList as $pos)
                        <option value="{{ $pos->id }}">{{ $pos->nama }}</option>
                    @endforeach
                </select>
                <span class="rounded-full bg-emerald-50 px-3 py-2 text-[11px] font-bold text-emerald-700">5 menit</span>
                <span class="rounded-full bg-yellow-50 px-3 py-2 text-[11px] font-bold text-yellow-700">10 menit</span>
                <span class="rounded-full bg-red-50 px-3 py-2 text-[11px] font-bold text-red-600">15 menit</span>
            </div>
            <span class="rounded-lg bg-slate-50 px-3 py-2 text-[11px] font-semibold text-slate-500">Mode: Mobil Pemadam</span>
        </div>
        <div class="relative">
            <div id="jangkauan-map" aria-label="Peta jangkauan pos pemadam"></div>
            <div id="isokron-status" role="status" aria-live="polite"
                 class="absolute rounded-full bg-slate-900/85 px-4 py-2 text-xs font-semibold text-white shadow-lg"
                 style="left:50%;top:12px;transform:translateX(-50%);z-index:500;max-width:90%;text-align:center">
                Pilih satu pos pemadam untuk menampilkan area jangkauannya
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-4 border-t border-slate-100 px-4 py-3 text-[11px] font-semibold text-slate-500">
            <span class="flex items-center gap-2"><i class="h-2.5 w-2.5 rounded-full bg-emerald-500"></i>0–5 menit (Hijau)</span>
            <span class="flex items-center gap-2"><i class="h-2.5 w-2.5 rounded-full bg-yellow-400"></i>5–10 menit (Kuning)</span>
            <span class="flex items-center gap-2"><i class="h-2.5 w-2.5 rounded-full bg-[#E52329]"></i>10–15 menit (Merah)</span>
        </div>
    </div>

    <aside class="space-y-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="flex items-center gap-2 text-sm font-extrabold text-slate-800"><span class="text-[#E52329]">⚠</span> Wilayah di Luar Jangkauan</h2>
            <div class="mt-4 space-y-3">
                <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3"><span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#E52329] text-sm font-black text-white">1</span><div class="min-w-0"><p class="text-xs font-bold text-slate-800">Gandus Ujung</p><p class="text-[11px] text-slate-500">24.1 km² • estimasi &gt;18 menit</p></div></div>
                <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3"><span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#E52329] text-sm font-black text-white">2</span><div class="min-w-0"><p class="text-xs font-bold text-slate-800">Karyajaya Selatan</p><p class="text-[11px] text-slate-500">15.5 km² • estimasi &gt;16 menit</p></div></div>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-extrabold text-slate-800">Ringkasan Peta</h2>
            <dl class="mt-4 grid grid-cols-2 gap-3">
                <div class="rounded-xl bg-red-50 p-3"><dt class="text-[11px] font-semibold text-red-700">Pos aktif</dt><dd class="mt-1 text-xl font-black text-red-700">{{ $posDamkarList->count() }}</dd></div>
                <div class="rounded-xl bg-slate-50 p-3"><dt class="text-[11px] font-semibold text-slate-500">Zona rawan</dt><dd class="mt-1 text-xl font-black text-slate-800">{{ $zonaRawan->count() }}</dd></div>
            </dl>
        </div>
    </aside>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
@include('damkar.partials.pos-icon')
@php
    $dataPosDamkar = $posDamkarList->map(fn ($pos) => [
        'id' => $pos->id,
        'nama' => $pos->nama,
        'lat' => (float) $pos->latitude,
        'lng' => (float) $pos->longitude,
    ])->values();
    $urlIsokron = route('damkar.peta.isokron', ['posDamkar' => '__ID__']);
@endphp
<script>
    const posDamkar = @json($dataPosDamkar);
    const urlIsokron = @json($urlIsokron);
    const isokronPreloaded = @json($isokronData ?? []);

    const map = L.map('jangkauan-map', { zoomControl: false }).setView([-2.975, 104.76], 12);
    L.control.zoom({ position: 'bottomright' }).addTo(map);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap' }).addTo(map);

    const pilihan = document.getElementById('pos-select');
    const status = document.getElementById('isokron-status');
    const warna = { 5: '#10b981', 10: '#facc15', 15: '#E52329' };

    let layerIsokron = null;
    let permintaanKe = 0;
    let pengendali = null;
    const simpanan = new Map(); // id pos -> GeoJSON

    // Isi cache instan dari data preloaded server
    if (typeof isokronPreloaded === 'object' && isokronPreloaded !== null) {
        Object.keys(isokronPreloaded).forEach(function (k) {
            simpanan.set(String(k), isokronPreloaded[k]);
            simpanan.set(Number(k), isokronPreloaded[k]);
        });
    }

    function setStatus(html, tampil = true) {
        status.innerHTML = html;
        status.classList.toggle('hidden', !tampil);
    }

    // Semua pos tetap tampil sebagai penanda; area jangkauan hanya untuk pos yang dipilih
    const penanda = {};
    posDamkar.forEach((pos) => {
        penanda[pos.id] = L.marker([pos.lat, pos.lng], { icon: buatIkonPosDamkar() })
            .addTo(map)
            .bindPopup(`<strong>${pos.nama}</strong><br>Pos pemadam aktif`);
        penanda[pos.id].on('click', () => { pilihan.value = String(pos.id); pilihPos(pos.id); });
    });
    if (posDamkar.length) { map.fitBounds(L.featureGroup(Object.values(penanda)).getBounds().pad(0.3)); }

    function hapusIsokron() {
        if (layerIsokron) { map.removeLayer(layerIsokron); layerIsokron = null; }
    }

    function gambarIsokron(geojson, pos) {
        hapusIsokron();
        layerIsokron = L.geoJSON(geojson, {
            style: (f) => ({
                color: warna[f.properties.menit] || '#E52329',
                weight: 2,
                fillColor: warna[f.properties.menit] || '#E52329',
                fillOpacity: 0.2,
                lineJoin: 'round',
            }),
            onEachFeature: (f, layer) => layer.bindTooltip(`Dalam ${f.properties.menit} menit dari ${pos.nama}`, { sticky: true }),
        }).addTo(map);
        map.fitBounds(layerIsokron.getBounds().pad(0.1));
        penanda[pos.id].openPopup();
        setStatus('', false);
    }

    async function pilihPos(id) {
        const pos = posDamkar.find((p) => String(p.id) === String(id));
        hapusIsokron();
        if (pengendali) { pengendali.abort(); pengendali = null; }

        if (!pos) {
            setStatus('Pilih satu pos pemadam untuk menampilkan area jangkauannya');
            if (posDamkar.length) { map.fitBounds(L.featureGroup(Object.values(penanda)).getBounds().pad(0.3)); }
            return;
        }

        map.setView([pos.lat, pos.lng], 14);

        const dataAda = simpanan.get(pos.id) || simpanan.get(String(pos.id)) || simpanan.get(Number(pos.id));
        if (dataAda) {
            gambarIsokron(dataAda, pos);
            return;
        }

        const giliran = ++permintaanKe;
        pengendali = new AbortController();
        setStatus(`Menghitung jangkauan ${pos.nama}…`);

        try {
            const res = await fetch(urlIsokron.replace('__ID__', pos.id), {
                headers: { 'Accept': 'application/json' },
                signal: pengendali.signal,
            });
            const data = await res.json().catch(() => ({}));
            if (giliran !== permintaanKe) return; // pengguna sudah pindah ke pos lain
            if (!res.ok) throw new Error(data.pesan || 'Gagal memuat jangkauan.');

            simpanan.set(pos.id, data);
            gambarIsokron(data, pos);
        } catch (err) {
            if (err.name === 'AbortError' || giliran !== permintaanKe) return;
            setStatus(`${err.message} <button type="button" id="isokron-ulang" class="ml-2 rounded-full bg-white px-3 py-1 text-[11px] font-bold text-slate-900">Coba lagi</button>`);
            document.getElementById('isokron-ulang')?.addEventListener('click', () => pilihPos(pos.id));
        }
    }

    pilihan.addEventListener('change', (event) => pilihPos(event.target.value));
</script>
@endsection
