<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP Damkar — Zona Rawan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
</head>
<body class="min-h-screen font-sans text-[#292626] antialiased sm:flex sm:justify-center sm:bg-gray-100 sm:px-4 sm:py-6">
    <div class="min-h-screen w-full max-w-2xl bg-[#fffaf8] shadow-[0_0_32px_rgba(75,35,35,0.06)] sm:min-h-0 sm:rounded-2xl sm:overflow-clip">

        <header class="sticky top-0 z-20 border-b border-[#f2e9e6] bg-[#fffaf8]/95 px-5 py-3 backdrop-blur">
            <div class="flex items-center gap-3">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#c41621] p-2 shadow-sm">
                    <img src="{{ asset('images/sigap-logo.svg') }}" alt="" class="h-full w-full object-contain">
                </span>
                <span class="leading-tight">
                    <span class="block text-sm font-extrabold tracking-[0.08em] text-[#bd101b]">SIGAP</span>
                    <span class="block text-[11px] font-bold uppercase tracking-wide text-[#5c4f4c]">Zona Rawan</span>
                </span>
            </div>
        </header>

        <main class="space-y-4 px-5 pb-4 pt-4 sm:px-7">

            <!-- Judul Halaman -->
            <section aria-labelledby="zona-title" class="space-y-1">
                <h1 id="zona-title" class="text-xl font-extrabold tracking-tight text-[#1d2b46]">Peta Daerah Rawan Kebakaran</h1>
                <p class="text-[13px] text-[#766965]">Pemetaan zonasi risiko kebakaran berdasarkan riwayat insiden</p>
            </section>

            <!-- Peta Zona -->
            <section aria-label="Peta zona rawan" class="overflow-hidden rounded-xl shadow-[0_3px_12px_rgba(65,45,40,0.05)]">
                <div class="relative">
                    <div id="map" class="h-80 w-full sm:h-96"></div>

                    <!-- Badge Zona Kritis -->
                    <div class="absolute left-3 top-3 z-10 flex items-center gap-2 rounded-xl bg-white/95 px-3 py-2 shadow-md backdrop-blur">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#ffe0dc] text-[#c41621]">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l9 4.5L12 21 3 7.5 12 3Z"/></svg>
                        </span>
                        <div class="min-w-0 leading-tight">
                            <p class="text-[12px] font-extrabold text-[#1d2b46]">{{ $zonaRawan->filter(fn ($zona) => $zona->risikoTinggi())->count() }} Zona Kritis</p>
                            <p class="text-[10px] text-[#766965]">Siaga Patroli 24 Jam</p>
                        </div>
                    </div>

                    <!-- Legenda -->
                    <div class="absolute bottom-3 left-3 z-10 flex items-center gap-1.5 rounded-full bg-white/95 px-3 py-1.5 text-[10px] font-bold text-[#292626] shadow-md backdrop-blur">
                        <span class="h-2.5 w-2.5 rounded-full bg-[#c41621]"></span> Risiko Tinggi
                    </div>
                </div>
            </section>

            <!-- Top Wilayah Paling Rawan -->
            <section aria-labelledby="rawan-title" class="rounded-xl bg-white p-4 shadow-[0_3px_12px_rgba(65,45,40,0.05)]">
                <div class="flex items-center justify-between gap-2">
                    <h2 id="rawan-title" class="flex items-center gap-2 text-sm font-extrabold text-[#1d2b46]">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#ffe0dc] text-[#c41621]">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h10"/></svg>
                        </span>
                        Top 2 Wilayah Paling Rawan
                    </h2>
                    <span class="text-[10px] font-bold text-[#766965]">2026</span>
                </div>

                <ol class="mt-3 space-y-2.5" aria-label="Daftar wilayah paling rawan">
                    @foreach ($zonaRawan->take(2) as $peringkat => $zona)
                        <li class="flex items-center gap-3 rounded-lg border border-[#f3eeeb] bg-[#fffaf8] p-2.5">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#c41621] text-sm font-black text-white">{{ $peringkat + 1 }}</span>
                            <div class="min-w-0 flex-1">
                                <p class="text-[13px] font-extrabold text-[#1d2b46]">{{ $zona->nama }}</p>
                                <p class="mt-0.5 truncate text-[11px] text-[#766965]">{{ $zona->jumlah_kejadian }} Kejadian{{ $zona->ciri ? ' • '.ucfirst($zona->ciri) : '' }}</p>
                            </div>
                            <span class="shrink-0 rounded-md px-2 py-1 text-[10px] font-bold {{ $zona->risikoTinggi() ? 'bg-[#ffe0dc] text-[#a20c15]' : 'bg-[#ffe1cc] text-[#a44d0b]' }}">{{ $zona->risikoTinggi() ? 'Risiko Tinggi' : 'Risiko Sedang' }}</span>
                        </li>
                    @endforeach
                </ol>
            </section>

            <!-- Faktor Penyebab Dominan -->
            <section aria-labelledby="penyebab-title" class="rounded-xl bg-white p-4 shadow-[0_3px_12px_rgba(65,45,40,0.05)]">
                <div class="flex items-center justify-between gap-2">
                    <h2 id="penyebab-title" class="flex items-center gap-2 text-sm font-extrabold text-[#1d2b46]">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#ffe0dc] text-[#c41621]">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6m4 6V7m4 10v-4M4 21V5m16 16H4"/></svg>
                        </span>
                        Faktor Penyebab Dominan
                    </h2>
                    <span class="text-[10px] font-bold text-[#766965]">100% Total</span>
                </div>

                @foreach ([['Korsleting instalasi listrik lama', 54, 'bg-[#c41621] text-[#a20c15]'], ['Kompor gas & kelalaian api', 28, 'bg-[#b76400] text-[#704018]'], ['Lahan terbuka & pembakaran sampah', 18, 'bg-[#3a465f] text-[#3a465f]']] as [$penyebab, $persen, $warna])
                    <div class="mt-3 first:mt-3">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-[12px] font-semibold text-[#292626]">{{ $penyebab }}</p>
                            <span class="text-[11px] font-extrabold {{ $warna }}">{{ $persen }}%</span>
                        </div>
                        <div class="mt-1.5 h-2 w-full overflow-hidden rounded-full bg-[#f2f0ef]">
                            <div class="h-full rounded-full {{ $warna }}" style="width: {{ $persen }}%"></div>
                        </div>
                    </div>
                @endforeach
            </section>
        </main>

        <nav aria-label="Navigasi utama" class="sticky bottom-0 z-30 grid grid-cols-4 border-t border-[#f0e8e5] bg-[#fffaf8]/95 px-2 pb-[max(0.55rem,env(safe-area-inset-bottom))] pt-2 shadow-[0_-4px_18px_rgba(60,35,30,0.05)] backdrop-blur">
            <a href="{{ route('beranda') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V10Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6c.8 1.5-.7 2.2.4 3 1-.5 1.3-1.4 1.3-1.4 1.2 1.7 1.3 2.6.3 3.7"/></svg><span class="text-[10px] font-bold">Beranda</span></a>
            <a href="{{ route('peta') }}" aria-current="page" class="flex flex-col items-center gap-0.5 text-[#bd101b]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Zm6-3v15m6-12v15"/></svg><span class="text-[10px] font-bold">Peta</span></a>
            <a href="{{ route('laporan.saya') }}" class="flex flex-col items-center gap-0.5 text-[#705d58]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6l1 2h4v15H4V6h4l1-2Zm1 6h4m-4 4h6m-6 4h6"/></svg><span class="text-[10px] font-bold">Laporan</span></a>
            <a href="@auth{{ route('profile.edit') }}@else{{ route('login') }}@endauth" class="flex flex-col items-center gap-0.5 text-[#705d58]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2H4Z"/></svg><span class="text-[10px] font-bold">Profil</span></a>
        </nav>
    </div>

    <script>
        // Gambar lingkaran zona rawan dari data database
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
        const zonaRawan = {!! $zonaData !!};

        const map = L.map('map', { zoomControl: false });

        L.control.zoom({ position: 'topright' }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        const batasZona = [];
        zonaRawan.forEach((zona) => {
            const warna = zona.tinggi ? '#c41621' : '#b76400';

            const lingkaran = L.circle([zona.lat, zona.lng], {
                radius: zona.radius,
                color: warna,
                weight: 2,
                dashArray: '6 5',
                fillColor: warna,
                fillOpacity: 0.25,
            }).addTo(map).bindPopup(`${zona.nama} • ${zona.jumlah} Kejadian`);

            L.marker([zona.lat, zona.lng]).setIcon(
                L.divIcon({
                    className: '',
                    html: `<div style="position:relative;"><div style="display:flex;align-items:center;justify-content:center;width:38px;height:38px;border-radius:9999px;background:${warna};box-shadow:0 4px 10px rgba(0,0,0,.25);border:3px solid #fff;">🔥</div></div>`,
                    iconSize: [38, 38],
                    iconAnchor: [19, 19],
                })
            ).addTo(map);

            batasZona.push(lingkaran.getLatLng());
        });

        if (batasZona.length) {
            map.fitBounds(L.latLngBounds(batasZona).pad(0.4), { padding: [20, 20] });
        } else {
            map.setView([-2.97, 104.76], 13); // Palembang
        }
    </script>
</body>
</html>
