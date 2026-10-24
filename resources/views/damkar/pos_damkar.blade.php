@extends('layouts.damkar')

@section('judul', 'Pos Damkar — Daftar Pos Pemadam')
@section('main-class', 'flex-1 space-y-6 overflow-y-auto bg-[#F8FAFC] p-8')

@section('content')
<header class="space-y-1">
    <p class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500"><span class="h-2 w-2 rounded-full bg-[#E52329]"></span>Unit Pelaksana Teknis</p>
    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Daftar Pos Pemadam Kebakaran</h1>
    <p class="text-sm text-slate-500">Informasi pos Damkar dan ketersediaan armada operasional. Total armada siaga: <strong class="text-slate-700">{{ $armadaSiaga }} dari {{ $armadaTotal }} unit</strong>.</p>
</header>

<section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3" aria-label="Daftar pos Damkar">
    @forelse ($posDamkarList as $pos)
        <article class="flex  flex-col overflow-hidden rounded-2xl border-l-4 border-[#E52329] bg-white shadow-sm">
            <div class="flex-1 p-5"><span class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-[#E52329]"><svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 21V5a2 2 0 012-2h12a2 2 0 012 2v16M4 21h16M8 7h2m4 0h2M8 11h2m4 0h2M8 15h2m4 0h2"/></svg></span><h2 class="mt-5 text-lg font-extrabold text-slate-900">{{ $pos->nama }}</h2><p class="mt-2 flex items-start gap-2 text-xs leading-relaxed text-slate-500"><svg class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-4.35 7-10a7 7 0 10-14 0c0 5.65 7 10 7 10Z"/><circle cx="12" cy="11" r="2"/></svg>{{ $pos->alamat }}</p></div>
            @if ($pos->kendaraan->isNotEmpty())
                <ul class="space-y-1.5 border-t border-slate-100 px-5 py-3" aria-label="Armada {{ $pos->nama }}">
                    @foreach ($pos->kendaraan as $unit)
                        <li class="flex items-center justify-between gap-2 text-xs">
                            <span class="min-w-0 truncate"><strong class="text-slate-800">{{ str_replace('-', ' ', $unit->kode) }}</strong> <span class="text-slate-500">· {{ $unit->jenis ?? $unit->nama }}@if ($unit->spesifikasi) · {{ $unit->spesifikasi }}@endif @if ($unit->ukuran) ({{ $unit->ukuran }})@endif</span></span>
                            <span class="shrink-0 rounded-full px-2 py-0.5 text-[10px] font-bold {{ match ($unit->status) { 'siaga' => 'bg-emerald-50 text-emerald-700', 'bergerak' => 'bg-amber-50 text-amber-700', default => 'bg-red-50 text-red-700' } }}">{{ match ($unit->status) { 'siaga' => 'Siaga', 'bergerak' => 'Bergerak', default => 'Dipanggil' } }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="border-t border-slate-100 px-5 py-3 text-xs text-slate-400">Belum ada armada terdaftar di pos ini.</p>
            @endif
            <div class="flex items-center justify-between gap-3 bg-[#F8FAFF] px-5 py-4"><div><p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">Kode Pos</p><p class="mt-1 text-sm font-extrabold text-slate-800">{{ $pos->unit }}</p></div><div class="text-right"><p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">Armada Siaga</p><p class="mt-1 flex items-center justify-end gap-1.5 text-sm font-extrabold text-[#B21E2A]"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 17h14M7 17V8h10l2 4h1v5M9 17a2 2 0 11-4 0m14 0a2 2 0 11-4 0M7 8l1.5-3h7L17 8"/></svg>{{ $pos->armada_siaga }} / {{ $pos->armada_total }} Unit</p></div></div>
        </article>
    @empty
        <div class="col-span-full rounded-2xl border border-dashed border-slate-200 bg-white p-12 text-center text-sm font-semibold text-slate-400">Belum ada pos Damkar yang terdaftar.</div>
    @endforelse
</section>
@endsection
