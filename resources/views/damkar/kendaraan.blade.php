@extends('layouts.damkar')

@section('judul', 'Kendaraan — Inventaris Armada')
@section('main-class', 'flex-1 space-y-6 overflow-y-auto bg-[#F8FAFC] p-8')

@section('content')
<header class="space-y-1">
    <p class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500"><span class="h-2 w-2 rounded-full bg-[#E52329]"></span>Inventaris Kendaraan Taktis — Damkar Kota Palembang</p>
    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Informasi Kendaraan</h1>
    <p class="max-w-xl text-sm text-slate-500">Ketersediaan dan penempatan unit armada operasional Dinas Pemadam Kebakaran dan Penyelamatan.</p>
</header>

{{-- Ringkasan Statistik --}}
<section class="grid gap-4 sm:grid-cols-3" aria-label="Ringkasan kendaraan">
    <div class="rounded-2xl border border-slate-100 border-b-4 border-b-blue-500 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between gap-3">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Total Armada</p>
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 17h14M7 17V8h10l2 4h1v5M9 17a2 2 0 11-4 0m14 0a2 2 0 11-4 0M7 8l1.5-3h7L17 8"/></svg>
            </span>
        </div>
        <p class="mt-4 text-3xl font-black text-slate-800">{{ $totalAktif }} <span class="text-xs font-bold text-slate-500">Unit Terdaftar</span></p>
    </div>
    <div class="rounded-2xl border border-slate-100 border-b-4 border-b-emerald-500 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between gap-3">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Siaga Operasional</p>
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
        </div>
        <p class="mt-4 text-3xl font-black text-emerald-600">{{ $totalSiaga }} <span class="text-xs font-bold text-slate-500">Unit Siap</span></p>
    </div>
    <div class="rounded-2xl border border-slate-100 border-b-4 border-b-amber-500 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between gap-3">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Sedang Bertugas</p>
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </span>
        </div>
        <p class="mt-4 text-3xl font-black text-amber-600">{{ $totalBergerak }} <span class="text-xs font-bold text-slate-500">Unit di TKP</span></p>
    </div>
</section>

{{-- Filter Tipe Kendaraan --}}
<div class="flex flex-wrap items-center gap-2 rounded-2xl border border-slate-100 bg-white p-3 shadow-sm" aria-label="Filter jenis kendaraan">
    <button type="button" data-filter="all" class="vehicle-filter rounded-xl bg-[#E52329] px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:opacity-90">
        Semua Tipe <span class="ml-1.5 rounded-full bg-white/20 px-2 py-0.5 text-[11px]">{{ $kendaraanList->count() }}</span>
    </button>
    <button type="button" data-filter="Fire Truck" class="vehicle-filter rounded-xl bg-slate-50 px-4 py-2.5 text-xs font-bold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
        Fire Truck <span class="ml-1.5 rounded-full bg-slate-200/70 px-2 py-0.5 text-[11px] text-slate-700">{{ $kendaraanList->where('jenis', 'Fire Truck')->count() }}</span>
    </button>
    <button type="button" data-filter="Fire Tanker" class="vehicle-filter rounded-xl bg-slate-50 px-4 py-2.5 text-xs font-bold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
        Fire Tanker <span class="ml-1.5 rounded-full bg-slate-200/70 px-2 py-0.5 text-[11px] text-slate-700">{{ $kendaraanList->where('jenis', 'Fire Tanker')->count() }}</span>
    </button>
    @if ($kendaraanList->where('jenis', 'Quick Response')->count() > 0)
    <button type="button" data-filter="Quick Response" class="vehicle-filter rounded-xl bg-slate-50 px-4 py-2.5 text-xs font-bold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
        Quick Response <span class="ml-1.5 rounded-full bg-slate-200/70 px-2 py-0.5 text-[11px] text-slate-700">{{ $kendaraanList->where('jenis', 'Quick Response')->count() }}</span>
    </button>
    @endif
</div>

{{-- Grid Kartu Kendaraan --}}
<section id="vehicle-grid" class="grid gap-4 md:grid-cols-2 xl:grid-cols-3" aria-label="Daftar kendaraan damkar">
    @forelse ($kendaraanList as $item)
        @php
            $kendaraan = $item['kendaraan'];
            $pos = $kendaraan->posDamkar;
            $jenisBadge = match ($item['jenis']) {
                'Fire Tanker' => 'bg-blue-50 text-blue-700 border-blue-200',
                'Fire Truck'  => 'bg-red-50 text-red-700 border-red-200',
                default       => 'bg-amber-50 text-amber-700 border-amber-200',
            };
        @endphp
        <article class="vehicle-card group relative cursor-pointer overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:border-red-300 hover:shadow-md"
                 data-type="{{ $item['jenis'] }}"
                 onclick="bukaDetailKendaraan({{ json_encode([
                     'kode' => $kendaraan->kode,
                     'nama' => $kendaraan->nama,
                     'jenis' => $item['jenis'],
                     'spesifikasi' => $kendaraan->spesifikasi ?? 'Hino',
                     'ukuran' => $kendaraan->ukuran ?? '-',
                     'status' => $kendaraan->status,
                     'statusLabel' => $item['statusLabel'],
                     'posNama' => $pos?->nama ?? 'Belum ditentukan',
                     'posUnit' => $pos?->unit ?? '-',
                     'posAlamat' => $pos?->alamat ?? 'Palembang',
                     'posLat' => $pos?->latitude,
                     'posLng' => $pos?->longitude,
                 ]) }})">
            
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#E52329] text-white shadow-sm transition group-hover:scale-105">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 17h14M7 17V8h10l2 4h1v5M9 17a2 2 0 11-4 0m14 0a2 2 0 11-4 0M7 8l1.5-3h7L17 8"/></svg>
                    </span>
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900 group-hover:text-[#E52329] transition-colors">{{ $kendaraan->kode }}</h2>
                        <span class="inline-block rounded-md border px-2 py-0.5 text-[10px] font-bold uppercase {{ $jenisBadge }} mt-0.5">
                            {{ $item['jenis'] }}
                        </span>
                    </div>
                </div>

                <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-bold text-emerald-700">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>{{ $item['statusLabel'] }}
                </span>
            </div>

            <div class="mt-4 space-y-2 border-t border-slate-100 pt-3 text-xs text-slate-600">
                <div class="flex items-center justify-between">
                    <span class="text-slate-400">Sasis / Mesin:</span>
                    <span class="font-bold text-slate-700">{{ $kendaraan->spesifikasi ?? $kendaraan->nama }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-400">Ukuran Armada:</span>
                    <span class="font-bold text-slate-700">{{ $kendaraan->ukuran ? 'Tipe '.$kendaraan->ukuran : '-' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-400">Pos Penempatan:</span>
                    <span class="font-bold text-[#E52329] truncate max-w-[180px]" title="{{ $pos?->nama ?? '-' }}">
                        {{ $pos?->nama ?? '-' }} ({{ $pos?->unit ?? '-' }})
                    </span>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-between border-t border-slate-50 pt-3 text-[11px] font-bold text-[#E52329] group-hover:translate-x-0.5 transition-transform">
                <span>Klik untuk informasi lengkap</span>
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </div>
        </article>
    @empty
        <div class="col-span-full rounded-2xl border border-dashed border-slate-200 bg-white p-12 text-center text-sm font-semibold text-slate-400">
            Belum ada kendaraan yang terdaftar.
        </div>
    @endforelse
</section>

{{-- Modal Detail Kendaraan --}}
<div id="modal-detail-kendaraan" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 p-4 backdrop-blur-sm transition-opacity" role="dialog" aria-modal="true" aria-labelledby="modal-kode">
    <div class="relative w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
        {{-- Modal Header --}}
        <div class="flex items-center justify-between bg-gradient-to-r from-[#c4111b] to-[#E52329] p-5 text-white">
            <div class="flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/20 text-white backdrop-blur-sm">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 17h14M7 17V8h10l2 4h1v5M9 17a2 2 0 11-4 0m14 0a2 2 0 11-4 0M7 8l1.5-3h7L17 8"/></svg>
                </span>
                <div>
                    <h3 id="modal-kode" class="text-xl font-black leading-tight">Unit-00</h3>
                    <p id="modal-jenis" class="text-xs font-semibold text-white/80 uppercase tracking-wide">Fire Truck</p>
                </div>
            </div>
            <button type="button" onclick="tutupDetailKendaraan()" class="rounded-xl p-1.5 text-white/80 transition hover:bg-white/20 hover:text-white" aria-label="Tutup modal">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="space-y-4 p-6">
            <div class="flex items-center justify-between rounded-xl bg-slate-50 p-3.5 border border-slate-100">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Status Operasional</p>
                    <p id="modal-status-label" class="mt-0.5 text-sm font-extrabold text-emerald-700">Siap Operasional</p>
                </div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>Siaga
                </span>
            </div>

            <div class="grid grid-cols-2 gap-3 text-xs">
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-3">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Sasis / Mesin</p>
                    <p id="modal-spesifikasi" class="mt-1 font-extrabold text-slate-800">Hino 500</p>
                </div>
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-3">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Kategori Ukuran</p>
                    <p id="modal-ukuran" class="mt-1 font-extrabold text-slate-800">Besar</p>
                </div>
            </div>

            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 space-y-1.5">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pos Penempatan Armada</p>
                <p id="modal-pos-nama" class="text-sm font-extrabold text-slate-900">Pos Pemadam Kertapati (N001)</p>
                <p id="modal-pos-alamat" class="text-xs text-slate-500 leading-relaxed">Jl. Lintas Sumatera, Palembang</p>
            </div>

            <div class="rounded-xl bg-amber-50/80 border border-amber-200/70 p-3.5 text-xs text-amber-900">
                <p class="font-bold">Peruntukan Taktis:</p>
                <p id="modal-deskripsi-taktis" class="mt-1 leading-relaxed text-[11px] text-amber-800">
                    Unit ini disiagakan untuk respon cepat darurat kebakaran dan penyelamatan di bawah koordinasi Pos Damkar terkait.
                </p>
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="flex items-center justify-end gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4">
            <a href="{{ route('damkar.peta') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 transition hover:bg-slate-100">
                Buka Peta Pos
            </a>
            <button type="button" onclick="tutupDetailKendaraan()" class="rounded-xl bg-[#E52329] px-5 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-[#c4111b]">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    // ── Filter Tipe Kendaraan (Semua Tipe, Fire Truck, Fire Tanker, Quick Response) ──
    document.querySelectorAll('.vehicle-filter').forEach((button) => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;

            // Reset semua tombol filter
            document.querySelectorAll('.vehicle-filter').forEach((btn) => {
                btn.className = 'vehicle-filter rounded-xl bg-slate-50 px-4 py-2.5 text-xs font-bold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900';
            });

            // Aktifkan tombol yang dipilih
            button.className = 'vehicle-filter rounded-xl bg-[#E52329] px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:opacity-90';

            // Filter kartu armada secara langsung lewat style.display (andal & instan)
            document.querySelectorAll('.vehicle-card').forEach((card) => {
                const match = (filter === 'all' || card.dataset.type === filter);
                card.style.display = match ? '' : 'none';
            });
        });
    });

    // ── Modal Detail Kendaraan ──
    const modal = document.getElementById('modal-detail-kendaraan');

    function bukaDetailKendaraan(data) {
        document.getElementById('modal-kode').textContent = data.kode;
        document.getElementById('modal-jenis').textContent = data.jenis;
        document.getElementById('modal-status-label').textContent = data.statusLabel + ' (' + data.status.toUpperCase() + ')';
        document.getElementById('modal-spesifikasi').textContent = data.spesifikasi || data.nama;
        document.getElementById('modal-ukuran').textContent = data.ukuran ? 'Tipe ' + data.ukuran : '-';
        document.getElementById('modal-pos-nama').textContent = data.posNama + (data.posUnit !== '-' ? ' (' + data.posUnit + ')' : '');
        document.getElementById('modal-pos-alamat').textContent = data.posAlamat;

        // Deskripsi taktis per jenis armada
        let deskripsi = 'Armada taktis siaga untuk penanganan kebakaran dan kedaruratan.';
        if (data.jenis === 'Fire Truck') {
            deskripsi = 'Armada utama pemadam kebakaran bertekanan tinggi dilengkapi tangga, selang pemancar, dan peralatan evakuasi korban.';
        } else if (data.jenis === 'Fire Tanker') {
            deskripsi = 'Armada tangki suplai air kapasitas besar untuk memasok air secara berkelanjutan ke armada pemadam di garis depan TKP.';
        } else if (data.jenis === 'Quick Response') {
            deskripsi = 'Armada reaksi cepat dengan bodi lincah untuk menjangkau pemukiman padat dan gang sempit sebelum api membesar.';
        }
        document.getElementById('modal-deskripsi-taktis').textContent = deskripsi;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function tutupDetailKendaraan() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Tutup saat klik di luar kotak modal atau tekan ESC
    modal.addEventListener('click', (e) => {
        if (e.target === modal) tutupDetailKendaraan();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            tutupDetailKendaraan();
        }
    });
</script>
@endsection
