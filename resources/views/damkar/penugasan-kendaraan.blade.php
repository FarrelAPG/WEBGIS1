@extends('layouts.damkar')

@section('judul', 'Penugasan Kendaraan — Panel Damkar')

@section('main-class', 'flex-1 p-6 space-y-6 overflow-y-auto bg-[#F8FAFC]')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pt-2">

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <a href="{{ route('damkar.laporan.show', $laporan) }}"
               class="inline-flex items-center gap-1.5 rounded-lg border border-[#E52320]/10 px-3 py-1.5 text-[12px] font-bold text-[#E52320] transition-all hover:bg-[#E52320]/5 hover:text-[#a20c15]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                <span>Kembali ke Detail Laporan</span>
            </a>
            <h2 class="mt-2 text-2xl font-extrabold text-slate-900 tracking-tight">Penugasan Armada Damkar</h2>
            <p class="mt-1 text-sm font-medium text-slate-500">
                Pilih armada dari pos terdekat untuk meluncur ke TKP:
                <strong class="text-slate-800">{{ $laporan->alamat }}</strong>
            </p>
        </div>

        <span class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 text-[11px] font-extrabold rounded-full border border-amber-200">
            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
            Menunggu Penugasan Armada
        </span>
    </div>

    <!-- Ringkasan Rekomendasi Jarak -->
    <div class="rounded-2xl border border-blue-100 bg-gradient-to-r from-blue-50/80 via-white to-white p-4 text-xs text-slate-700 flex items-start gap-3 shadow-sm">
        <span class="text-xl">📍</span>
        <div class="space-y-1">
            <p class="font-extrabold text-slate-900">
                Menampilkan {{ $kendaraanTersedia->count() }} Armada Terdekat Berdasarkan Radius Lokasi Kejadian
            </p>
            <p class="text-slate-500">
                Unit diurutkan otomatis dari Pos Damkar dengan jarak tempuh tercepat menuju lokasi kebakaran. Silakan pilih unit yang paling siap bergerak.
            </p>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('damkar.laporan.store-penugasan-kendaraan', $laporan) }}" class="space-y-4">
        @csrf
        @method('PATCH')

        <input type="hidden" name="kendaraan_id" id="selected_vehicle_id">

        <div class="space-y-3" id="vehicle-list">
            @if ($kendaraanTersedia->isEmpty())
                <div class="rounded-2xl border border-dashed border-slate-200 bg-white p-10 text-center">
                    <p class="text-sm font-semibold text-slate-400">Tidak ada kendaraan siaga untuk ditugaskan.</p>
                </div>
            @endif

            @foreach ($kendaraanTersedia as $idx => $kendaraan)
                @php
                    $posNama = $kendaraan->posDamkar?->nama ?? 'Pos Siaga Palembang';
                    $posAlamat = $kendaraan->posDamkar?->alamat ?? 'Kota Palembang';
                @endphp
                <div
                    class="vehicle-card cursor-pointer bg-white rounded-3xl p-5 border-2 transition-all shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 border-slate-100 hover:border-slate-300 hover:shadow-md"
                    data-id="{{ $kendaraan->id }}"
                    data-code="{{ $kendaraan->kode }}"
                    data-nama="{{ $kendaraan->nama }}"
                    data-pos="{{ $posNama }}"
                    data-jarak="{{ $kendaraan->jarak_km }}"
                >
                    <div class="flex items-start gap-4">
                        <div class="vehicle-icon-box w-13 h-13 rounded-2xl flex items-center justify-center shrink-0 transition-colors bg-red-50 text-[#bd101b] font-bold text-lg p-3">
                            🚒
                        </div>
                        <div class="space-y-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-base font-black text-slate-900">{{ $kendaraan->kode }}</h3>
                                <span class="text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded-lg">{{ $kendaraan->nama }}</span>
                                @if ($idx === 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-red-100 text-[#bd101b] text-[10px] font-extrabold rounded-full animate-pulse">
                                        ⭐ Rekomendasi Terdekat
                                    </span>
                                @endif
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Siap Siaga
                                </span>
                            </div>

                            <!-- Keterangan Pos Damkar Asal -->
                            <div class="flex items-center gap-1.5 text-xs font-extrabold text-[#bd101b] pt-0.5">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <span>{{ $posNama }}</span>
                            </div>

                            <p class="text-[11px] text-slate-500 line-clamp-1">
                                {{ $posAlamat }}
                            </p>

                            <!-- Indikator Jarak Nyata -->
                            <div class="flex items-center gap-2 text-xs font-bold text-slate-600 pt-1">
                                <span class="text-[#bd101b] font-black">📍 {{ $kendaraan->jarak_km }} km ke TKP</span>
                                <span class="text-slate-300">•</span>
                                <span class="text-slate-600">⏱️ Est. waktu tempuh: ~{{ $kendaraan->estimasi_menit }} menit</span>
                                <span class="text-slate-300">•</span>
                                <span class="text-slate-500 text-[11px]">Ukuran: {{ $kendaraan->ukuran }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="action-btn-wrapper shrink-0 self-end md:self-center">
                        <button type="button" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-2.5 px-5 rounded-2xl flex items-center gap-2 transition-colors">
                            <span class="w-4 h-4 rounded-full border-2 border-slate-400 inline-block"></span>
                            <span>Pilih Unit Ini</span>
                        </button>
                    </div>
                </div>
            @endforeach

            {{-- Accordion Kendaraan di Pos Lebih Jauh (Jika Ada) --}}
            @if ($kendaraanLainnya->isNotEmpty())
                <div class="pt-2">
                    <button type="button" onclick="document.getElementById('other-vehicles').classList.toggle('hidden')" class="w-full text-center py-2.5 px-4 rounded-2xl border border-slate-200 bg-white text-xs font-bold text-slate-600 hover:bg-slate-50 transition shadow-sm flex items-center justify-center gap-2">
                        <span>Lihat {{ $kendaraanLainnya->count() }} Armada Cadangan Lainnya (Pos Berjarak Lebih Jauh)</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div id="other-vehicles" class="hidden space-y-3 mt-3">
                        @foreach ($kendaraanLainnya as $kendaraan)
                            @php
                                $posNama = $kendaraan->posDamkar?->nama ?? 'Pos Siaga Palembang';
                                $posAlamat = $kendaraan->posDamkar?->alamat ?? 'Kota Palembang';
                            @endphp
                            <div
                                class="vehicle-card cursor-pointer bg-white rounded-3xl p-5 border-2 transition-all shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 border-slate-100 hover:border-slate-300 hover:shadow-md opacity-90"
                                data-id="{{ $kendaraan->id }}"
                                data-code="{{ $kendaraan->kode }}"
                                data-nama="{{ $kendaraan->nama }}"
                                data-pos="{{ $posNama }}"
                                data-jarak="{{ $kendaraan->jarak_km }}"
                            >
                                <div class="flex items-start gap-4">
                                    <div class="vehicle-icon-box w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 transition-colors bg-slate-100 text-slate-600 font-bold text-base">
                                        🚒
                                    </div>
                                    <div class="space-y-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h3 class="text-base font-extrabold text-slate-900">{{ $kendaraan->kode }}</h3>
                                            <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-lg">{{ $kendaraan->nama }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-xs font-bold text-slate-700 pt-0.5">
                                            <span>🏢 {{ $posNama }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                                            <span>📍 {{ $kendaraan->jarak_km }} km ke TKP</span>
                                            <span class="text-slate-300">•</span>
                                            <span>⏱️ ~{{ $kendaraan->estimasi_menit }} menit</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="action-btn-wrapper shrink-0 self-end md:self-center">
                                    <button type="button" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-2.5 px-5 rounded-2xl flex items-center gap-2 transition-colors">
                                        <span class="w-4 h-4 rounded-full border-2 border-slate-400 inline-block"></span>
                                        <span>Pilih Unit Ini</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sticky Bottom Action Bar -->
        <div class="mt-8 rounded-3xl p-5 shadow-lg border border-slate-100 bg-white flex flex-col sm:flex-row items-center justify-between gap-4 sticky bottom-4 z-20">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <div class="w-10 h-10 bg-red-50 text-[#bd101b] rounded-2xl flex items-center justify-center shrink-0 font-bold text-lg">
                    🚨
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Armada Yang Dipilih</span>
                    <p class="text-sm font-extrabold text-slate-900" id="selection-summary">
                        Belum ada armada dipilih
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4 w-full sm:w-auto justify-end">
                <a href="{{ route('damkar.laporan.show', $laporan) }}"
                   class="text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    id="submit_kirim_tim"
                    disabled
                    class="bg-[#bd101b] hover:bg-[#a00e17] text-white font-extrabold text-sm px-7 py-3 rounded-2xl flex items-center gap-2 shadow-md hover:shadow-lg transition-all active:scale-95 opacity-50 cursor-not-allowed">
                    <svg class="w-4 h-4 transform rotate-45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    <span>Tugaskan &amp; Kirim Tim</span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputHidden = document.getElementById('selected_vehicle_id');
        const summaryText = document.getElementById('selection-summary');
        const submitBtn = document.getElementById('submit_kirim_tim');

        function setupCards() {
            const cards = document.querySelectorAll('.vehicle-card');

            function resetCards() {
                cards.forEach(function (c) {
                    c.classList.remove('border-[#bd101b]', 'bg-red-50/20', 'ring-2', 'ring-[#bd101b]/20');
                    c.classList.add('border-slate-100');

                    const btnWrapper = c.querySelector('.action-btn-wrapper');
                    if (btnWrapper) {
                        btnWrapper.innerHTML = `
                            <button type="button" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-2.5 px-5 rounded-2xl flex items-center gap-2 transition-colors">
                                <span class="w-4 h-4 rounded-full border-2 border-slate-400 inline-block"></span>
                                <span>Pilih Unit Ini</span>
                            </button>`;
                    }
                });
            }

            cards.forEach(function (card) {
                card.addEventListener('click', function () {
                    resetCards();

                    this.classList.remove('border-slate-100');
                    this.classList.add('border-[#bd101b]', 'bg-red-50/20', 'ring-2', 'ring-[#bd101b]/20');

                    const btnWrapper = this.querySelector('.action-btn-wrapper');
                    if (btnWrapper) {
                        btnWrapper.innerHTML = `
                            <button type="button" class="bg-[#bd101b] text-white font-extrabold text-xs py-2.5 px-5 rounded-2xl flex items-center gap-1.5 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                <span>Terpilih</span>
                            </button>`;
                    }

                    const id = this.getAttribute('data-id');
                    const code = this.getAttribute('data-code');
                    const nama = this.getAttribute('data-nama');
                    const pos = this.getAttribute('data-pos');
                    const jarak = this.getAttribute('data-jarak');

                    inputHidden.value = id;
                    summaryText.innerHTML = `<span class="text-[#bd101b]">${code} (${nama})</span> — Siaga di <strong class="text-slate-900">${pos}</strong> (${jarak} km dari TKP)`;

                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                });
            });
        }

        setupCards();
    });
</script>
@endsection
