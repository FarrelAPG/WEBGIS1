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
            <h2 class="mt-2 text-2xl font-extrabold text-slate-900 tracking-tight">Penugasan Kendaraan</h2>
            <p class="mt-1 text-sm font-medium text-slate-500">
                Pilih kendaraan pemadam kebakaran untuk ditugaskan ke
                <strong class="text-slate-800">{{ $laporan->alamat }}</strong>
            </p>
        </div>

        <span class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-600 text-[11px] font-extrabold rounded-full">
            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
            Menunggu Penugasan
        </span>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('damkar.laporan.store-penugasan-kendaraan', $laporan) }}" class="space-y-4">
        @csrf
        @method('PATCH')

        <input type="hidden" name="kendaraan_id" id="selected_vehicle_id">

        <div class="space-y-3" id="vehicle-list">
            @if ($kendaraanTersedia->isEmpty())
                <div class="rounded-xl border border-dashed border-slate-200 bg-white p-10 text-center">
                    <p class="text-sm font-semibold text-slate-400">Tidak ada kendaraan siaga untuk ditugaskan.</p>
                </div>
            @endif

            @foreach ($kendaraanTersedia as $kendaraan)
                <div
                    class="vehicle-card cursor-pointer bg-white rounded-3xl p-5 border-2 transition-all shadow-sm flex items-center justify-between border-slate-100 hover:border-slate-300 hover:shadow-md"
                    data-id="{{ $kendaraan->id }}"
                    data-code="{{ $kendaraan->kode }}"
                    data-pos="{{ $kendaraan->nama }}"
                >
                    <div class="flex items-center gap-4">
                        <div class="vehicle-icon-box w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 transition-colors bg-blue-50 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        </div>
                        <div class="space-y-0.5">
                            <div class="flex items-center gap-2">
                                <h3 class="text-base font-extrabold text-slate-900">{{ $kendaraan->kode }}</h3>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-50 text-emerald-600 text-[11px] font-bold rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Siap
                                </span>
                            </div>
                            <p class="text-xs font-semibold text-slate-500">
                                {{ $kendaraan->nama }} <span class="text-slate-300 mx-1">•</span> <span class="text-slate-500">Jarak {{ rand(1, 9) }}.{{ rand(10, 99) }} km</span>
                            </p>
                        </div>
                    </div>

                    <div class="action-btn-wrapper">
                        <button type="button" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-2.5 px-5 rounded-2xl flex items-center gap-2 transition-colors">
                            <span class="w-4 h-4 rounded-full border-2 border-slate-400 inline-block"></span>
                            <span>Pilih</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 rounded-3xl p-5 shadow-lg border border-slate-100 bg-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-red-50 text-[#E52329] rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h2a2 2 0 012 2h4a2 2 0 002-2h2a2 2 0 012 2v14a2 2 0 01-2 2z"/></svg>
                </div>
                <p class="text-sm font-bold text-slate-800" id="selection-summary">
                    Belum ada kendaraan dipilih
                </p>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('damkar.laporan.show', $laporan) }}"
                   class="text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    id="submit_kirim_tim"
                    disabled
                    class="bg-[#E52320] hover:bg-red-700 text-white font-bold text-sm px-6 py-3 rounded-2xl flex items-center gap-2 shadow-md hover:shadow-lg transition-all active:scale-95 opacity-50 cursor-not-allowed">
                    <svg class="w-4 h-4 transform rotate-45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    <span>Kirim Tim</span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.vehicle-card');
        const inputHidden = document.getElementById('selected_vehicle_id');
        const summaryText = document.getElementById('selection-summary');
        const submitBtn = document.getElementById('submit_kirim_tim');

        function resetCards() {
            cards.forEach(function (c) {
                c.classList.remove('border-[#E52320]', 'bg-red-50/10');
                c.classList.add('border-slate-100');

                const iconBox = c.querySelector('.vehicle-icon-box');
                iconBox.classList.remove('bg-[#E52320]', 'text-white', 'shadow-sm');
                iconBox.classList.add('bg-blue-50', 'text-blue-600');

                c.querySelector('.action-btn-wrapper').innerHTML = `
                    <button type="button" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-2.5 px-5 rounded-2xl flex items-center gap-2 transition-colors">
                        <span class="w-4 h-4 rounded-full border-2 border-slate-400 inline-block"></span>
                        <span>Pilih</span>
                    </button>`;
            });
        }

        cards.forEach(function (card) {
            card.addEventListener('click', function () {
                resetCards();

                this.classList.remove('border-slate-100');
                this.classList.add('border-[#E52320]', 'bg-red-50/10');

                const activeIconBox = this.querySelector('.vehicle-icon-box');
                activeIconBox.classList.remove('bg-blue-50', 'text-blue-600');
                activeIconBox.classList.add('bg-[#E52320]', 'text-white', 'shadow-sm');

                this.querySelector('.action-btn-wrapper').innerHTML = `
                    <button type="button" class="bg-[#E52320] text-white font-bold text-xs py-2.5 px-5 rounded-2xl flex items-center gap-1.5 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span>Terpilih</span>
                    </button>`;

                inputHidden.value = this.getAttribute('data-id');
                summaryText.innerText = this.getAttribute('data-code') + ' ' + this.getAttribute('data-pos');

                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            });
        });
    });
</script>
@endsection
