@extends('layouts.damkar')

@section('judul', 'Berita Laporan — Panel Damkar')

@section('main-class', 'flex-1 p-6 space-y-6 overflow-y-auto bg-[#F8FAFC]')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-[#E52329] text-white flex items-center justify-center shadow-md">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 2l-4.444 8.88A1 1 0 0015.556 12l2.222-4.444A1 1 0 0013.778 6H10m0 0L5.556 12A1 1 0 007.778 14l4.444-8.889A1 1 0 0011.112 4z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Berita Laporan</h1>
                    <p class="text-xs font-semibold text-slate-500 mt-0.5">Arsip rekapitulasi data insiden kebakaran dan hasil pemadaman selesai</p>
                </div>
            </div>
        </div>

        <a href="{{ route('damkar.laporan.index') }}"
           class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 shadow-sm transition-all hover:bg-slate-50 hover:border-slate-300">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            <span>Kembali ke Pemantauan</span>
        </a>
    </div>

    <!-- Daftar Berita Laporan -->
    @if ($laporanList->isEmpty())
        <div class="rounded-3xl border border-dashed border-slate-200 bg-white p-12 text-center shadow-sm">
            <div class="w-16 h-16 rounded-3xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h2a2 2 0 012 2h4a2 2 0 002-2h2a2 2 0 012 2v14a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-base font-extrabold text-slate-800">Belum Ada Berita Laporan</h3>
            <p class="text-xs font-semibold text-slate-400 max-w-md mx-auto mt-1">
                Laporan yang telah selesai ditangani dan telah dilengkapi formulir evaluasi akhirnya akan tampil secara otomatis di sini.
            </p>
            <div class="mt-6">
                <a href="{{ route('damkar.laporan.index') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-[#E52329] px-4 py-2.5 text-xs font-bold text-white shadow-md hover:bg-red-700 transition-colors">
                    <span>Lihat Laporan Aktif</span>
                </a>
            </div>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($laporanList as $item)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-all space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-slate-900 text-white text-xs font-black rounded-xl">
                                #{{ $item->id }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 text-xs font-extrabold rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Penanganan Selesai
                            </span>
                            @if ($item->dugaan_penyebab)
                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-bold rounded-xl border border-amber-200">
                                    {{ $item->dugaan_penyebab }}
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $item->tanggal_penanganan ? $item->tanggal_penanganan->format('d M Y') : ($item->created_at ? $item->created_at->format('d M Y') : '-') }}</span>
                            <span>•</span>
                            <span class="text-slate-800">Selesai: {{ $item->selesai_pukul ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                        <div class="md:col-span-8 space-y-2">
                            <h3 class="text-base font-extrabold text-slate-900 leading-snug">
                                {{ $item->alamat }}
                            </h3>
                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9"/></svg>
                                <span>Wilayah: <strong>{{ $item->wilayah ?? 'Pos Damkar' }}</strong></span>
                            </div>

                            @if ($item->kronologi_kejadian)
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed bg-slate-50 p-3 rounded-2xl border border-slate-100">
                                    {{ $item->kronologi_kejadian }}
                                </p>
                            @endif
                        </div>

                        <div class="md:col-span-4 flex flex-col justify-between h-full space-y-4">
                            <div class="grid grid-cols-2 gap-2 text-center">
                                <div class="bg-red-50/60 rounded-2xl p-2.5 border border-red-100">
                                    <span class="text-[10px] font-extrabold text-red-500 uppercase block">KORBAN JIWA</span>
                                    <span class="text-lg font-black text-slate-900">{{ $item->korban_jiwa }}</span>
                                </div>
                                <div class="bg-amber-50/60 rounded-2xl p-2.5 border border-amber-100">
                                    <span class="text-[10px] font-extrabold text-amber-600 uppercase block">KORBAN LUKA</span>
                                    <span class="text-lg font-black text-slate-900">{{ $item->korban_luka }}</span>
                                </div>
                            </div>

                            @if ($item->kendaraan)
                                <div class="flex items-center gap-2 text-xs font-bold text-slate-700 bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
                                    <svg class="w-4 h-4 text-[#E52329]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                    <span>Armada: <strong>{{ $item->kendaraan->kode }}</strong> ({{ $item->kendaraan->nama }})</span>
                                </div>
                            @endif

                            <a href="{{ route('damkar.laporan.show', $item) }}"
                               class="w-full bg-slate-100 hover:bg-[#E52329] hover:text-white text-slate-800 font-extrabold text-xs py-3 px-4 rounded-2xl transition-all flex items-center justify-center gap-2 text-center group">
                                <span>Lihat Detail Laporan</span>
                                <svg class="w-4 h-4 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection

