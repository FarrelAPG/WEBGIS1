<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP Damkar — Lacak Armada</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
</head>
<body class="min-h-screen bg-[#eef1f6] font-sans text-[#292626] antialiased sm:flex sm:justify-center sm:bg-gray-100">
    <div class="min-h-screen w-full max-w-2xl bg-[#eef1f6] shadow-[0_0_32px_rgba(75,35,35,0.06)] sm:shadow-xl flex flex-col justify-between">

        <header class="sticky top-0 z-20 border-b border-[#e2e6ee] bg-[#eef1f6]/95 px-5 py-3 backdrop-blur">
            <div class="flex items-center gap-3">
                <button type="button" onclick="history.back()" aria-label="Kembali" class="rounded-full p-1 text-[#473a38] transition hover:bg-white/60">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <a href="{{ route('laporan.saya') }}" class="flex min-w-0 items-center gap-2.5">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#a11522] p-2 shadow-sm">
                        <img src="{{ asset('images/sigap-logo.svg') }}" alt="" class="h-full w-full object-contain">
                    </span>
                    <span class="min-w-0 leading-tight">
                        <span class="block text-sm font-extrabold tracking-[0.08em] text-[#bd101b]">SIGAP</span>
                        <span class="block text-[11px] font-bold uppercase tracking-wide text-[#292626]">Laporan Saya</span>
                    </span>
                </a>
            </div>
        </header>

        <main class="flex-1 space-y-4 px-5 pb-4 pt-4 sm:px-7">

            <!-- Kartu Ringkasan Laporan -->
            <section aria-labelledby="ringkasan-title" class="rounded-xl bg-white p-4 shadow-[0_3px_12px_rgba(65,45,40,0.05)]">
                <h1 id="ringkasan-title" class="text-base font-extrabold text-[#1d2b46]">Kebakaran {{ \Illuminate\Support\Str::limit($laporan->alamat, 48) }}</h1>
                <p class="mt-1 flex items-start gap-1 text-[12px] text-[#5c6a84]">
                    <svg class="mt-0.5 h-3.5 w-3.5 shrink-0 text-[#c41621]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.5a7.5 7.5 0 0 0-7.5 7.5c0 5.6 7.5 11.5 7.5 11.5S19.5 15.6 19.5 10A7.5 7.5 0 0 0 12 2.5Zm0 10.2a2.7 2.7 0 1 1 0-5.4 2.7 2.7 0 0 1 0 5.4Z"/></svg>
                    <span>{{ $laporan->alamat }}</span>
                </p>
                <p class="mt-2 inline-block rounded-md bg-[#eef1f6] px-2.5 py-1 text-[11px] font-bold text-[#3a465f]">Dilaporkan: {{ $laporan->created_at->translatedFormat('H:i') }} WIB</p>
            </section>

            <!-- Peta Lacak Armada -->
            <section aria-label="Peta pelacakan armada" class="overflow-hidden rounded-xl shadow-[0_3px_12px_rgba(65,45,40,0.05)]">
                <div id="map" class="h-72 w-full sm:h-80"></div>
            </section>

            <!-- Kartu Unit -->
            <section aria-labelledby="unit-title" class="rounded-xl bg-white p-4 shadow-[0_3px_12px_rgba(65,45,40,0.05)]">
                <div class="flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-white text-2xl ring-1 ring-[#f3eeeb]" aria-hidden="true">🚒</span>
                    <div class="min-w-0">
                        <h2 id="unit-title" class="text-base font-extrabold text-[#1d2b46]">Unit 03</h2>
                        <p class="text-[11px] font-medium text-[#5c6a84]">Posko Sektor {{ \Illuminate\Support\Str::limit($laporan->alamat, 28) }}</p>
                    </div>
                </div>

                <div class="mt-3 grid grid-cols-2 gap-2.5">
                    <div class="rounded-lg bg-[#eef1f6] p-3">
                        <p class="text-[9px] font-bold uppercase tracking-wide text-[#5c6a84]">Estimasi Tiba (ETA)</p>
                        <p class="mt-1 leading-none"><span class="text-2xl font-black text-[#c41621]">4</span> <span class="text-[12px] font-bold text-[#c41621]">Menit</span></p>
                        <p class="mt-1.5 flex items-center gap-1 text-[10px] text-[#5c6a84]">
                            <svg class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 2"/></svg>
                            Perkiraan: {{ $laporan->created_at->copy()->addMinutes(8)->translatedFormat('H:i') }} WIB
                        </p>
                    </div>
                    <div class="rounded-lg bg-[#eef1f6] p-3">
                        <p class="text-[9px] font-bold uppercase tracking-wide text-[#5c6a84]">Jarak Tempuh</p>
                        <p class="mt-1 leading-none"><span class="text-2xl font-black text-[#1d2b46]">1,2</span> <span class="text-[12px] font-bold text-[#1d2b46]">KM</span></p>
                        <p class="mt-1.5 flex items-center gap-1 text-[10px] text-[#5c6a84]">
                            <svg class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m12 3 9 5-9 5-9-5 9-5Zm9 10-9 5-9-5m18 5-4.5 2.5"/></svg>
                            Sisa 3 Persimpangan
                        </p>
                    </div>
                </div>
            </section>

            <!-- Progres Penanganan -->
            <section aria-labelledby="progres-title" class="rounded-xl bg-white p-4 shadow-[0_3px_12px_rgba(65,45,40,0.05)]">
                <h2 id="progres-title" class="text-base font-extrabold text-[#1d2b46]">Progres Penanganan</h2>

                @php
                    $tahap = $laporan->tahapMasyarakat();
                    $langkah = [
                        ['judul' => 'Laporan Diterima', 'ket' => 'Dispatcher Posko Komando', 'waktu' => $laporan->created_at->translatedFormat('H.i').' WIB', 'state' => 'selesai'],
                        ['judul' => 'Menuju Lokasi Kebakaran', 'ket' => 'Menempuh arah ke lokasi laporan', 'waktu' => null, 'state' => $tahap >= 3 ? 'selesai' : 'berjalan'],
                        ['judul' => 'Sedang Ditangani', 'ket' => 'Petugas tiba di lokasi, gelar selang & hidran', 'waktu' => $laporan->mulai_penanganan_at ? $laporan->mulai_penanganan_at->translatedFormat('H.i').' WIB' : null, 'state' => $tahap >= 4 ? 'selesai' : ($tahap === 3 ? 'berjalan' : 'menunggu')],
                        ['judul' => 'Penanganan Selesai', 'ket' => 'Laporan akhir telah dibuat petugas', 'waktu' => $laporan->hasil_dibuat_pada ? $laporan->hasil_dibuat_pada->translatedFormat('H.i').' WIB' : null, 'state' => $tahap >= 4 ? 'selesai' : 'menunggu'],
                    ];
                @endphp

                <ol class="mt-4 space-y-0" aria-label="Tahapan penanganan laporan">
                    @foreach ($langkah as $l)
                        @php $akhir = $loop->last; @endphp
                        @if ($l['state'] === 'selesai')
                            <li class="relative flex gap-3 {{ $akhir ? '' : 'pb-5' }}">
                                <span class="relative z-10 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#c41621] text-white">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4 10-10"/></svg>
                                    @unless ($akhir)<span class="absolute -bottom-5 h-5 w-0.5 bg-[#c41621]"></span>@endunless
                                </span>
                                <div class="flex min-w-0 flex-1 items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="text-[13px] font-bold text-[#1d2b46]">{{ $l['judul'] }}</p>
                                        <p class="mt-0.5 text-[11px] text-[#5c6a84]">{{ $l['ket'] }}</p>
                                        <div class="mt-1 h-1 w-8 rounded-full bg-[#c41621]/30" aria-hidden="true"></div>
                                    </div>
                                    <span class="shrink-0 text-[11px] font-bold text-[#1d2b46]">{{ $l['waktu'] ?? '' }}</span>
                                </div>
                            </li>
                        @elseif ($l['state'] === 'berjalan')
                            <li class="relative flex gap-3 {{ $akhir ? '' : 'pb-5' }}">
                                <span class="relative z-10 flex h-7 w-7 shrink-0 items-center justify-center">
                                    <span class="h-4 w-4 rounded-full bg-[#c41621] ring-4 ring-[#c41621]/25"></span>
                                    @unless ($akhir)<span class="absolute -bottom-4 h-4 w-0.5 bg-[#e8d5d3]"></span>@endunless
                                </span>
                                <div class="min-w-0 flex-1 rounded-lg bg-[#fdecec] p-3">
                                    <div class="flex items-start justify-between gap-2">
                                        <p class="text-[13px] font-extrabold leading-snug text-[#c41621]">{{ $l['judul'] }}</p>
                                        @if ($l['waktu'])<span class="shrink-0 text-[11px] font-bold text-[#c41621]">{{ $l['waktu'] }}</span>@endif
                                    </div>
                                    <p class="mt-0.5 text-[11px] text-[#8a4a48]">{{ $l['ket'] }}</p>
                                </div>
                            </li>
                        @else
                            <li class="relative flex gap-3 {{ $akhir ? '' : 'pb-5' }}">
                                <span class="relative z-10 flex h-7 w-7 shrink-0 items-center justify-center">
                                    <span class="h-3 w-3 rounded-full bg-[#c3cbd9] ring-4 ring-[#c3cbd9]/30"></span>
                                    @unless ($akhir)<span class="absolute -bottom-5 h-5 w-0.5 bg-[#e8d5d3]"></span>@endunless
                                </span>
                                <div class="flex min-w-0 flex-1 items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="text-[13px] font-bold text-[#9aa5b8]">{{ $l['judul'] }}</p>
                                        <p class="mt-0.5 text-[11px] text-[#9aa5b8]">{{ $l['ket'] }}</p>
                                    </div>
                                    <span class="shrink-0 text-[11px] font-bold text-[#9aa5b8]">--.--</span>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </section>

            <!-- Aksi -->
            <section class="space-y-3 pb-2">
                <a href="tel:113" class="flex min-h-12 w-full items-center justify-center gap-2 rounded-lg bg-[#a11522] text-sm font-bold text-white shadow-md shadow-red-900/20 transition hover:bg-[#8f101d]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.5 19.5 0 0 1-3-8.7A2 2 0 0 1 4.1 4h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 2.8a2 2 0 0 1-.4 2.1L8.1 12a16 16 0 0 0 6 6l1.4-1.3a2 2 0 0 1 2.1-.4c.9.3 1.9.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg>
                    Hubungi Komandan Unit 03
                </a>
                <p class="pt-1 text-center">
                    <a href="{{ route('laporan.saya') }}" class="inline-flex items-center gap-1.5 text-[12px] font-bold text-[#5c6a84] transition hover:text-[#292626]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m6-6-6 6 6 6"/></svg>
                        Kembali ke Daftar Laporan Saya
                    </a>
                </p>
            </section>
        </main>

        <nav aria-label="Navigasi utama" class="sticky bottom-0 z-30 grid grid-cols-4 border-t border-[#e2e6ee] bg-[#eef1f6]/95 px-2 pb-[max(0.55rem,env(safe-area-inset-bottom))] pt-2 shadow-[0_-4px_18px_rgba(60,35,30,0.05)] backdrop-blur">
            <a href="{{ route('beranda') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V10Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6c.8 1.5-.7 2.2.4 3 1-.5 1.3-1.4 1.3-1.4 1.2 1.7 1.3 2.6.3 3.7"/></svg><span class="text-[10px] font-bold">Beranda</span></a>
            <a href="{{ route('peta') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Zm6-3v15m6-12v15"/></svg><span class="text-[10px] font-bold">Peta</span></a>
            <a href="{{ route('laporan.saya') }}" aria-current="page" class="flex flex-col items-center gap-0.5 text-[#bd101b]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6l1 2h4v15H4V6h4l1-2Zm1 6h4m-4 4h6m-6 4h6"/></svg><span class="text-[10px] font-bold">Laporan</span></a>
            <a href="@auth{{ route('profile.edit') }}@else{{ route('login') }}@endauth" class="flex flex-col items-center gap-0.5 text-[#705d58]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2H4Z"/></svg><span class="text-[10px] font-bold">Profil</span></a>
        </nav>
    </div>

    <script>
        // Titik TKP dari data laporan
        const tkp = [{{ (float) $laporan->latitude }}, {{ (float) $laporan->longitude }}];

        const map = L.map('map', { zoomControl: false }).setView(tkp, 15);
        L.control.zoom({ position: 'topright' }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Marker TKP (titik kebakaran)
        const ikonTkp = L.divIcon({
            className: '',
            html: '<div style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:9999px;background:#c41621;box-shadow:0 4px 10px rgba(120,10,20,.35);border:3px solid #fff;">🔥</div>',
            iconSize: [40, 40],
            iconAnchor: [20, 20],
        });
        L.marker(tkp, { icon: ikonTkp }).addTo(map).bindPopup('Titik Kebakaran (TKP)').openPopup();

        // Marker armada sedikit bergeser dari TKP (simulasi posisi unit saat ini)
        const armada = [tkp[0] + 0.003, tkp[1] - 0.002];
        const ikonArmada = L.divIcon({
            className: '',
            html: '<div style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:9999px;background:#1d2b46;box-shadow:0 4px 10px rgba(20,30,60,.35);border:3px solid #fff;font-size:1.1rem;">🚒</div>',
            iconSize: [40, 40],
            iconAnchor: [20, 20],
        });
        L.marker(armada, { icon: ikonArmada }).addTo(map).bindPopup('Armada 03');

        // Garis rute armada ke TKP
        // Rute armada ke TKP mengikuti jalan (OSRM, urutan lng,lat); cadangan: garis lurus
        const gayaRute = { color: '#c41621', weight: 4, dashArray: '8 6', opacity: 0.9 };
        fetch(`https://router.project-osrm.org/route/v1/driving/${armada[1]},${armada[0]};${tkp[1]},${tkp[0]}?overview=full&geometries=geojson`)
            .then(res => { if (!res.ok) throw new Error('HTTP ' + res.status); return res.json(); })
            .then(data => {
                if (data.code !== 'Ok' || !data.routes.length) throw new Error('Rute tidak ditemukan');
                const garis = L.geoJSON(data.routes[0].geometry, { style: gayaRute }).addTo(map);
                map.fitBounds(garis.getBounds().pad(0.2));
            })
            .catch(err => {
                console.warn('Routing gagal, memakai garis lurus:', err);
                L.polyline([armada, tkp], gayaRute).addTo(map);
            });

        map.fitBounds(L.latLngBounds([tkp, armada]).pad(0.6));
    </script>
</body>
</html>
