<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffaf8">
    <title>SIGAP — Laporan Darurat Terkirim</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen justify-center bg-[#fffaf8] antialiased sm:items-center sm:px-4 sm:py-8">
    <div class="flex min-h-screen w-full max-w-lg flex-col bg-white px-5 pb-6 sm:min-h-0 sm:rounded-3xl sm:px-7 sm:pb-8 sm:shadow-xl sm:border sm:border-[#f0e8e5]">

        <!-- Badge Sukses -->
        <div class="flex flex-col items-center pb-6 pt-10 text-center sm:pb-8 sm:pt-12">
            <div class="relative flex h-32 w-32 items-center justify-center">
                <span class="absolute h-32 w-32 rounded-full bg-red-50"></span>
                <span class="absolute h-22 w-22 rounded-full bg-red-100"></span>
                <span class="relative z-10 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#bd101b] shadow-lg shadow-red-900/25">
                    <svg class="h-8 w-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 6 9 17l-5-5"/>
                    </svg>
                </span>
            </div>

            <h1 class="mt-5 text-2xl sm:text-3xl font-extrabold leading-tight tracking-tight text-slate-900">Laporan Darurat Terkirim!</h1>
            <p class="mt-2 text-xs sm:text-sm leading-relaxed text-[#766965]">
                Sinyal GPS &amp; data kebakaran telah diterima oleh Command Center Damkar 112 Kota Palembang. Petugas sedang memproses pengerahan unit.
            </p>
        </div>

        <!-- Info Panggilan Balik -->
        <div class="rounded-2xl bg-amber-50/70 p-4 border border-amber-200/80">
            <div class="flex items-start gap-3">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-800 text-base" aria-hidden="true">📞</span>
                <p class="text-xs sm:text-sm leading-snug text-amber-900">
                    Petugas Command Center akan menghubungi nomor HP Anda (<span class="font-bold font-mono">{{ $laporan->nomor_telepon }}</span>) dalam waktu singkat untuk konfirmasi situasi lapangan.
                </p>
            </div>
        </div>

        <!-- Tindakan Keselamatan -->
        <div class="mt-5 space-y-2.5 rounded-2xl bg-[#fef7f7] p-4 border border-red-100">
            <div class="flex items-center gap-2 mb-2">
                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#bd101b] text-[11px] font-black leading-none text-white">!</span>
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900">Tindakan Keselamatan Segera</h2>
            </div>

            <div class="flex items-start gap-2.5 rounded-xl bg-white p-3 border border-[#f0e8e5] text-xs">
                <span class="text-base shrink-0">💨</span>
                <p class="text-[#5c4f4c] leading-relaxed"><span class="font-bold text-slate-900">Menjauh dari asap pekat</span> dan posisikan diri berlawanan dengan hembusan arah angin.</p>
            </div>

            <div class="flex items-start gap-2.5 rounded-xl bg-white p-3 border border-[#f0e8e5] text-xs">
                <span class="text-base shrink-0">🚫</span>
                <p class="text-[#5c4f4c] leading-relaxed"><span class="font-bold text-slate-900">Jangan masuk kembali</span> ke dalam bangunan untuk mengambil barang berharga apapun risikonya.</p>
            </div>

            <div class="flex items-start gap-2.5 rounded-xl bg-white p-3 border border-[#f0e8e5] text-xs">
                <span class="text-base shrink-0">📍</span>
                <p class="text-[#5c4f4c] leading-relaxed"><span class="font-bold text-slate-900">Tunggu di titik kumpul aman</span> atau tepi jalan utama untuk memandu armada pemadam saat tiba.</p>
            </div>
        </div>

        <!-- Tombol Pantau -->
        <div class="mt-6 pt-2">
            <a href="{{ route('laporan.saya') }}" class="flex w-full min-h-12 items-center justify-center gap-2 rounded-full bg-[#bd101b] hover:bg-[#a00e17] px-5 text-center text-sm font-bold text-white shadow-lg shadow-red-900/20 transition">
                <span>Pantau Pelacakan Armada (Laporan Saya)</span>
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
        </div>
    </div>
</body>
</html>
