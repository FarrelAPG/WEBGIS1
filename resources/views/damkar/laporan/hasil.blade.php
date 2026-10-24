@extends('layouts.damkar')

@section('judul', 'Laporan Hasil Pemadaman & Penyelamatan — Panel Damkar')

@section('main-class', 'flex-1 p-6 space-y-6 overflow-y-auto bg-[#F8FAFC]')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('damkar.laporan.penanganan-tkp', $laporan) }}"
           class="w-10 h-10 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-2xl flex items-center justify-center shrink-0 shadow-sm transition-colors"
           title="Kembali ke Penanganan TKP">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Laporan Hasil Pemadaman & Penyelamatan</h1>
            <p class="text-xs font-semibold text-slate-500 mt-0.5">Formulir evaluasi akhir pasca pemadaman insiden #{{ $laporan->id }}</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-xs font-semibold text-red-700 space-y-1">
            <div class="font-bold">Mohon perbaiki kesalahan berikut:</div>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('damkar.laporan.simpan-hasil', $laporan) }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- Kolom Kiri: Seksi 1 & Seksi 2 (8/12) -->
            <div class="lg:col-span-8 space-y-6">

                <!-- 1. Informasi Waktu & Lokasi Kejadian -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 space-y-5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-2xl bg-red-50 text-[#E52329] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h2 class="text-base font-extrabold text-slate-900">1. Informasi Waktu & Lokasi Kejadian</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="tanggal_penanganan" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal Penanganan</label>
                            <input type="date" name="tanggal_penanganan" id="tanggal_penanganan"
                                   value="{{ old('tanggal_penanganan', $laporan->tanggal_penanganan ? $laporan->tanggal_penanganan->format('Y-m-d') : date('Y-m-d')) }}"
                                   required
                                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-800 focus:border-[#E52329] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E52329]/20">
                        </div>
                        <div>
                            <label for="wilayah" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Wilayah / Sektor Posko</label>
                            <input type="text" name="wilayah" id="wilayah"
                                   value="{{ old('wilayah', $laporan->wilayah ?? ($posDamkar->nama ?? 'Pos Damkar Gambir (Sektor Pusat)')) }}"
                                   required
                                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-800 focus:border-[#E52329] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E52329]/20">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="jam_terima" class="flex items-center justify-between text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                                <span>Jam Terima</span>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                            </label>
                            <input type="text" name="jam_terima" id="jam_terima"
                                   value="{{ old('jam_terima', $laporan->jam_terima ?? ($laporan->created_at ? $laporan->created_at->format('H:i').' WIB' : '14:46 WIB')) }}"
                                   required
                                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-800 focus:border-[#E52329] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E52329]/20">
                        </div>
                        <div>
                            <label for="tiba_tkp" class="flex items-center justify-between text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                                <span>Tiba Di TKP</span>
                                <svg class="w-3.5 h-3.5 text-slate-400 transform rotate-45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </label>
                            <input type="text" name="tiba_tkp" id="tiba_tkp"
                                   value="{{ old('tiba_tkp', $laporan->tiba_tkp ?? ($laporan->updated_at ? $laporan->updated_at->format('H:i').' WIB' : '14:52 WIB')) }}"
                                   required
                                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-800 focus:border-[#E52329] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E52329]/20">
                        </div>
                        <div>
                            <label for="selesai_pukul" class="flex items-center justify-between text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                                <span>Selesai</span>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </label>
                            <input type="text" name="selesai_pukul" id="selesai_pukul"
                                   value="{{ old('selesai_pukul', $laporan->selesai_pukul ?? now()->format('H:i').' WIB') }}"
                                   required
                                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-800 focus:border-[#E52329] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E52329]/20">
                        </div>
                    </div>

                    <div>
                        <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Lokasi / Alamat Lengkap TKP</span>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 space-y-1">
                            <p class="text-sm font-bold text-slate-800">{{ $laporan->alamat }}</p>
                            <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-500">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                <span>{{ $laporan->latitude }}, {{ $laporan->longitude }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Karakteristik Bangunan & Dugaan Penyebab -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 space-y-5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-2xl bg-red-50 text-[#E52329] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9"/></svg>
                        </div>
                        <h2 class="text-base font-extrabold text-slate-900">2. Karakteristik Bangunan & Dugaan Penyebab</h2>
                    </div>

                    <div>
                        <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2.5">Dugaan Pemicu Kebakaran</span>
                        @php
                            $selectedPenyebab = old('dugaan_penyebab', $laporan->dugaan_penyebab ?? 'Korsleting Listrik');
                            $opsiPenyebab = [
                                [
                                    'val' => 'Korsleting Listrik',
                                    'title' => 'Korsleting Listrik',
                                    'desc' => 'Hubungan arus pendek (MCB Utama)',
                                ],
                                [
                                    'val' => 'Kebocoran Gas LPG',
                                    'title' => 'Kebocoran Gas LPG',
                                    'desc' => 'Instalasi tabung / kompor dapur',
                                ],
                                [
                                    'val' => 'Kelalaian Manusia',
                                    'title' => 'Kelalaian Manusia',
                                    'desc' => 'Lilin, dupa, atau puntung rokok',
                                ],
                                [
                                    'val' => 'Dalam Penyelidikan Puslabfor',
                                    'title' => 'Dalam Penyelidikan Puslabfor',
                                    'desc' => 'Belum teridentifikasi definitif',
                                ],
                            ];
                        @endphp
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach ($opsiPenyebab as $opsi)
                                <label class="dugaan-option cursor-pointer rounded-2xl border-2 p-4 flex items-start gap-3 transition-all
                                    {{ $selectedPenyebab === $opsi['val'] ? 'border-[#E52329] bg-red-50/20' : 'border-slate-100 bg-slate-50/50 hover:border-slate-200' }}">
                                    <input type="radio" name="dugaan_penyebab" value="{{ $opsi['val'] }}"
                                           {{ $selectedPenyebab === $opsi['val'] ? 'checked' : '' }}
                                           class="mt-1 h-4 w-4 text-[#E52329] focus:ring-[#E52329] border-slate-300">
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900">{{ $opsi['title'] }}</h4>
                                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $opsi['desc'] }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label for="kronologi_kejadian" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Kronologi Singkat Kejadian</label>
                        <textarea name="kronologi_kejadian" id="kronologi_kejadian" rows="4" required
                                  placeholder="Api pertama kali terdeteksi dari mana, upaya pemadaman awal, dan penanganan oleh regu damkar..."
                                  class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-medium text-slate-800 leading-relaxed focus:border-[#E52329] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E52329]/20">{{ old('kronologi_kejadian', $laporan->kronologi_kejadian) }}</textarea>
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Seksi 3 & Tombol Simpan (4/12) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- 3. Korban & Taksiran Kerugian -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 space-y-5">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-2xl bg-red-50 text-[#E52329] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900">3. Korban & Taksiran Kerugian</h2>
                            <p class="text-[11px] font-semibold text-slate-400 mt-0.5">Evaluasi korban dan dampak nilai finansial</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-4 space-y-1">
                            <label for="korban_jiwa" class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-500">Korban Jiwa (MD)</label>
                            <input type="number" name="korban_jiwa" id="korban_jiwa" min="0"
                                   value="{{ old('korban_jiwa', $laporan->korban_jiwa ?? 0) }}"
                                   required
                                   class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-black text-slate-900 focus:border-[#E52329] focus:outline-none">
                            <p class="text-[10px] text-slate-400 font-medium">0 jika tidak ada korban tewas (Nihil)</p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-4 space-y-1">
                            <label for="korban_luka" class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-500">Korban Luka-Luka</label>
                            <input type="number" name="korban_luka" id="korban_luka" min="0"
                                   value="{{ old('korban_luka', $laporan->korban_luka ?? 0) }}"
                                   required
                                   class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-black text-slate-900 focus:border-[#E52329] focus:outline-none">
                            <p class="text-[10px] text-slate-400 font-medium">Luka bakar, patah tulang, atau luka gores</p>
                        </div>
                    </div>

                    <div>
                        <label for="catatan_medis" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Catatan Kondisi Medis Korban</label>
                        <textarea name="catatan_medis" id="catatan_medis" rows="3"
                                  placeholder="Personel regu (luka gores ringan, penanganan PMI di lokasi)..."
                                  class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-medium text-slate-800 leading-relaxed focus:border-[#E52329] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E52329]/20">{{ old('catatan_medis', $laporan->catatan_medis) }}</textarea>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="pt-2">
                    <button type="submit"
                            class="w-full bg-[#E52329] hover:bg-red-700 text-white font-black text-sm py-4 px-6 rounded-2xl shadow-lg hover:shadow-red-900/20 transition-all active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 transform rotate-45" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>Kirim Laporan</span>
                    </button>
                </div>

            </div>

        </div>
    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const radioLabels = document.querySelectorAll('.dugaan-option');
    radioLabels.forEach(function (label) {
        label.addEventListener('click', function () {
            radioLabels.forEach(function (l) {
                l.classList.remove('border-[#E52329]', 'bg-red-50/20');
                l.classList.add('border-slate-100', 'bg-slate-50/50');
            });
            this.classList.remove('border-slate-100', 'bg-slate-50/50');
            this.classList.add('border-[#E52329]', 'bg-red-50/20');
        });
    });
});
</script>
@endsection

