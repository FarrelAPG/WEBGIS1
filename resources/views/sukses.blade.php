<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGAP - Laporan Darurat Terkirim</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen justify-center bg-gray-100 antialiased sm:items-center sm:px-4 sm:py-6">
    <div class="flex min-h-screen w-full max-w-md flex-col bg-white px-4 pb-6 sm:min-h-0 sm:rounded-2xl sm:px-5 sm:pb-8 sm:shadow-xl sm:overflow-hidden">

        <!-- Badge Sukses -->
        <div class="flex flex-col items-center pb-8 pt-14 text-center sm:pb-10 sm:pt-20">
            <div class="relative flex h-36 w-36 items-center justify-center">
                <span class="absolute h-36 w-36 rounded-full bg-red-100"></span>
                <span class="absolute h-24 w-24 rounded-full bg-red-200"></span>
                <span class="relative z-10 flex h-16 w-16 items-center justify-center rounded-full bg-red-600 shadow-lg">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 2.6 14.6 5h3.4a1 1 0 0 1 1 1v3.4L21.4 12 19 14.6V18a1 1 0 0 1-1 1h-3.4L12 21.4 9.4 19H6a1 1 0 0 1-1-1v-3.4L2.6 12 5 9.4V6a1 1 0 0 1 1-1h3.4L12 2.6Z" fill="white"/>
                        <path d="m8.6 12.2 2.3 2.3 4.5-4.6" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>

            <h1 class="mt-6 text-[28px] font-extrabold leading-tight tracking-tight text-gray-900 sm:text-3xl">Laporan Darurat Terkirim!</h1>
            <p class="mt-3 max-w-xs text-[15px] leading-relaxed text-gray-600">
                Sinyal GPS &amp; data kebakaran telah diterima oleh Command Center Damkar 112. Petugas sedang memproses pengerahan unit.
            </p>
        </div>

        <!-- Info Panggilan Balik -->
        <div class="rounded-2xl bg-gray-50 p-3 ring-1 ring-gray-200">
            <div class="h-2 w-[94%] rounded-full bg-red-600"></div>
            <div class="flex items-start gap-3 px-1.5 pb-1 pt-4">
                <svg class="h-6 w-6 shrink-0 text-gray-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10v4h3l5 4V6l-5 4H3Zm13.5-3.5a5 5 0 0 1 0 7M19 4a8.5 8.5 0 0 1 0 14"/>
                </svg>
                <p class="text-[14px] leading-snug text-gray-700">
                    Petugas operator Command Center akan menghubungi nomor HP Anda (<span class="font-bold text-gray-900">{{ $laporan->nomor_telepon }}</span>) dalam waktu kurang dari 60 detik untuk konfirmasi situasi lapangan.
                </p>
            </div>
        </div>

        <!-- Tindakan Keselamatan -->
        <div class="mt-5 space-y-2.5 rounded-2xl bg-red-50 p-4 ring-1 ring-red-100">
            <div class="flex items-center gap-2.5 px-1">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-600 text-[13px] font-black leading-none text-white">!</span>
                <h2 class="text-sm font-extrabold uppercase tracking-wide text-gray-900 sm:text-[15px]">Tindakan Keselamatan Segera</h2>
            </div>

            <div class="flex items-start gap-3 rounded-xl bg-white p-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg ring-1 ring-red-100">
                    <svg class="h-5 w-5 text-amber-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M8 22h8M9 2h6l1 5a7 7 0 0 1-8 0l1-5Zm2 12-2 8m4-8 2 8"/>
                    </svg>
                </span>
                <p class="text-[13.5px] leading-snug text-gray-700">
                    <span class="font-bold text-gray-900">Menjauh dari asap pekat</span> dan selalu posisikan diri berlawanan dengan hembusan arah angin.
                </p>
            </div>

            <div class="flex items-start gap-3 rounded-xl bg-white p-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg ring-1 ring-red-100">
                    <svg class="h-5 w-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="m5.8 5.8 12.4 12.4"/>
                    </svg>
                </span>
                <p class="text-[13.5px] leading-snug text-gray-700">
                    <span class="font-bold text-gray-900">Jangan masuk kembali</span> ke dalam bangunan untuk mengambil barang berharga apapun risikonya.
                </p>
            </div>

            <div class="flex items-start gap-3 rounded-xl bg-white p-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg ring-1 ring-red-100">
                    <svg class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-5.4 7-11a7 7 0 1 0-14 0c0 5.6 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/>
                    </svg>
                </span>
                <p class="text-[13.5px] leading-snug text-gray-700">
                    <span class="font-bold text-gray-900">Tunggu di titik kumpul aman</span> atau tepi jalan besar yang lapang untuk memandu armada pemadam saat tiba.
                </p>
            </div>
        </div>

        <!-- Tombol Pantau -->
        <div class="mt-auto pt-8">
            <a href="{{ route('laporan.saya') }}" class="flex w-full min-h-12 items-center justify-center gap-2 rounded-full bg-red-600 px-4 text-center text-sm font-bold text-white shadow-lg transition hover:bg-red-700 sm:min-h-14 sm:text-[15px]">
                Pantau Pelacakan Armada (Laporan Saya)
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
        </div>
    </div>
</body>
</html>
