@extends('layouts.damkar')

@section('judul', 'Kendaraan — Inventaris Armada')
@section('main-class', 'flex-1 space-y-6 overflow-y-auto bg-[#F8FAFC] p-8')

@section('content')
<header class="space-y-1">
    <p class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500"><span class="h-2 w-2 rounded-full bg-[#E52329]"></span>Inventaris Kendaraan Taktis — Damkar</p>
    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Informasi Kendaraan</h1>
    <p class="max-w-xl text-sm text-slate-500">Ketersediaan unit kendaraan operasional Dinas Pemadam Kebakaran dan Penyelamatan.</p>
</header>

<section class="grid gap-4 sm:grid-cols-3" aria-label="Ringkasan kendaraan">
    <div class="rounded-2xl border border-slate-100 border-b-4 border-b-blue-200 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between gap-3"><p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Total Aktif</p><span class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600"><svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 17h14M7 17V8h10l2 4h1v5M9 17a2 2 0 11-4 0m14 0a2 2 0 11-4 0M7 8l1.5-3h7L17 8"/></svg></span></div>
        <p class="mt-5 text-3xl font-black text-slate-800">{{ $totalAktif }} <span class="text-xs font-bold text-slate-500">Unit Terdaftar</span></p>
    </div>
    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm"><p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Siaga Operasional</p><p class="mt-5 text-3xl font-black text-emerald-600">{{ $totalSiaga }} <span class="text-xs font-bold text-slate-500">Unit Siap</span></p></div>
    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm"><p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Sedang Bergerak</p><p class="mt-5 text-3xl font-black text-amber-600">{{ $totalBergerak }} <span class="text-xs font-bold text-slate-500">Unit Bertugas</span></p></div>
</section>

<div class="flex flex-wrap items-center gap-2 rounded-2xl border border-slate-100 bg-white p-3 shadow-sm" aria-label="Filter jenis kendaraan">
    <button type="button" data-filter="all" class="vehicle-filter rounded-lg bg-[#E52329] px-4 py-2 text-xs font-bold text-white">Semua Tipe <span class="ml-1 rounded-full bg-white/20 px-1.5 py-0.5">{{ $kendaraanList->count() }}</span></button>
    <button type="button" data-filter="Fire Truck" class="vehicle-filter rounded-lg px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-50">Fire Truck <span class="ml-1 rounded-full bg-slate-100 px-1.5 py-0.5">{{ $kendaraanList->where('jenis', 'Fire Truck')->count() }}</span></button>
    <button type="button" data-filter="Fire Tanker" class="vehicle-filter rounded-lg px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-50">Fire Tanker <span class="ml-1 rounded-full bg-slate-100 px-1.5 py-0.5">{{ $kendaraanList->where('jenis', 'Fire Tanker')->count() }}</span></button>
</div>

<section id="vehicle-grid" class="grid gap-4 md:grid-cols-2 xl:grid-cols-3" aria-label="Daftar kendaraan damkar">
    @forelse ($kendaraanList as $item)
        @php($kendaraan = $item['kendaraan'])
        <article class="vehicle-card overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm" data-type="{{ $item['jenis'] }}">
            <div class="flex items-center gap-3 bg-[#EEF2FF] p-4"><span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#E52329] text-white"><svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 17h14M7 17V8h10l2 4h1v5M9 17a2 2 0 11-4 0m14 0a2 2 0 11-4 0M7 8l1.5-3h7L17 8"/></svg></span><div><h2 class="text-sm font-extrabold text-slate-900">{{ $kendaraan->kode }}</h2><p class="text-xs font-medium text-slate-500">{{ $item['jenis'] }}</p></div></div>
            <div class="p-3"><div class="flex items-center justify-between gap-3 rounded-xl bg-slate-50 p-3"><div><p class="text-[10px] text-slate-400">Jenis Kendaraan</p><p class="mt-0.5 text-xs font-bold text-slate-700">{{ $kendaraan->nama }}</p></div><span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>{{ $item['statusLabel'] }}</span></div></div>
        </article>
    @empty
        <div class="col-span-full rounded-2xl border border-dashed border-slate-200 bg-white p-12 text-center text-sm font-semibold text-slate-400">Belum ada kendaraan yang terdaftar.</div>
    @endforelse
</section>

<script>
    document.querySelectorAll('.vehicle-filter').forEach((button) => button.addEventListener('click', () => {
        const filter = button.dataset.filter;
        document.querySelectorAll('.vehicle-filter').forEach((item) => item.classList.remove('bg-[#E52329]', 'text-white'));
        document.querySelectorAll('.vehicle-filter').forEach((item) => item.classList.add('text-slate-500'));
        button.classList.add('bg-[#E52329]', 'text-white');
        button.classList.remove('text-slate-500');
        document.querySelectorAll('.vehicle-card').forEach((card) => { card.classList.toggle('hidden', filter !== 'all' && card.dataset.type !== filter); });
    }));
</script>
@endsection
