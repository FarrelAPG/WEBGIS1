@extends('layouts.damkar')

@section('judul', 'Detail Laporan #{{ $laporan->id }} — Panel Damkar')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />

<style>
    #detail-map .leaflet-container { width: 100%; height: 100%; background: #eef2f7; }
</style>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    {{-- Kiri: Peta Lokasi --}}
    <div class="lg:col-span-7">
        <div class="rounded-xl border border-slate-100 bg-white p-1 shadow-sm">
            <div id="detail-map" class="h-[520px] w-full rounded-xl overflow-hidden bg-slate-100"></div>
        </div>
    </div>

    {{-- Kanan: Detail & Tindakan --}}
    <div class="lg:col-span-5 space-y-6">

        {{-- Blok Info --}}
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
            <h2 class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 mb-1">Dokumen Insiden Aktif</h2>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight mb-4">Detail Laporan Kebakaran #{{ $laporan->id }}</h1>

            <div class="space-y-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Lokasi Kejadian</p>
                    <p class="text-sm font-semibold text-slate-900 leading-tight">{{ $laporan->alamat }}</p>
                </div>

                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Waktu Laporan Diterima</p>
                    <p class="flex items-center gap-2 text-sm text-slate-900">
                        <span class="font-bold">{{ $laporan->created_at->format('H:i') }} WIB</span>
                        <span class="text-[11px] text-slate-500">{{ $laporan->created_at->diffForHumans() }}</span>
                    </p>
                </div>

                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Status Operasi</p>
                    <p class="flex items-center gap-2 text-sm font-bold {{ $laporan->status === 'pending' ? 'text-amber-600' : 'text-[#E52320]' }}">
                        @php
                            $label = ['pending' => 'Menunggu Tim', 'diproses' => 'Penanganan', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'][$laporan->status] ?? ucfirst($laporan->status);
                        @endphp
                        {{ $label }}
                    </p>
                </div>

                {{-- Kendaraan --}}
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Kendaraan Ditugaskan</p>
                    @if ($laporan->kendaraan)
                        <div class="space-y-2">
                            <div class="flex items-center gap-3 rounded-lg bg-[#E52320]/5 px-3 py-2 border border-[#E52320]/20">
                                <svg class="w-5 h-5 text-[#E52320]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">{{ $laporan->kendaraan->kode }}</p>
                                    <p class="text-[11px] text-slate-500">{{ $laporan->kendaraan->nama }}</p>
                                </div>
                            </div>
                            @if ($laporan->status === 'diproses')
                                <div class="grid grid-cols-2 gap-2 pt-1">
                                    <a href="{{ route('damkar.laporan.navigasi-rute', $laporan) }}" class="flex items-center justify-center gap-1.5 rounded-xl bg-slate-900 px-3 py-2 text-[11px] font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">
                                        <svg class="w-3.5 h-3.5 transform rotate-45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                        <span>Navigasi Rute</span>
                                    </a>
                                    <a href="{{ route('damkar.laporan.penanganan-tkp', $laporan) }}" class="flex items-center justify-center gap-1.5 rounded-xl bg-[#E52329] px-3 py-2 text-[11px] font-bold text-white shadow-sm hover:bg-red-700 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                                        <span>Penanganan TKP</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <a href="{{ route('damkar.laporan.penugasan-kendaraan', $laporan) }}"
                           class="w-full flex items-center justify-center gap-2 rounded-xl bg-[#E52320] px-4 py-2.5 text-xs font-bold text-white transition-colors hover:bg-red-700 shadow-sm">
                            Tugaskan Kendaraan <span aria-hidden="true">→</span>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Keterangan & Foto --}}
            <div class="mt-6 divide-y divide-slate-100">
                <div class="grid gap-2 sm:grid-cols-2 text-[12px]">
                    <div>
                        <p class="text-xs font-bold uppercase text-slate-400">Pelapor</p>
                        <p class="text-slate-700">{{ $laporan->user?->name ?? 'Tamu (tanpa akun)' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase text-slate-400">Telepon</p>
                        <p class="text-slate-700">{{ $laporan->nomor_telepon }}</p>
                    </div>
                </div>

                <div class="mt-3">
                    <p class="text-xs font-bold uppercase text-slate-400">Keterangan</p>
                    <p class="mt-1 text-slate-600 leading-relaxed whitespace-pre-wrap">{{ $laporan->keterangan ?? '-' }}</p>
                </div>

                @if ($laporan->foto)
                    <div class="mt-3">
                        <p class="text-xs font-bold uppercase text-slate-400">Foto Kejadian</p>
                        <a href="{{ route('damkar.laporan.foto', $laporan) }}" target="_blank" class="inline-block rounded-lg border border-slate-200 overflow-hidden">
                            <img src="{{ route('damkar.laporan.foto', $laporan) }}" alt="Foto kejadian" class="w-48 h-32 object-cover"
                                 onerror="this.onerror=null; this.parentElement.outerHTML='<p class=&quot;text-xs text-slate-400 italic&quot;>Foto tidak dapat dimuat (file tidak ditemukan).</p>';">
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Aksi Status --}}
        @if ($transisi)
            <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
                <h2 class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 mb-4">Tindak Lanjut</h2>
                <div class="grid gap-3 sm:grid-cols-3">
                    @foreach ($transisi as $statusBaru)
                        @continue($statusBaru === 'ditolak')
                        <form method="POST" action="{{ route('damkar.laporan.status', $laporan) }}"
                              @if ($statusBaru === 'ditolak') onsubmit="return confirm('Tandai laporan ini sebagai ditolak?')"
                              @elseif ($statusBaru === 'selesai') onsubmit="return confirm('Tandai laporan ini sebagai selesai?')" @endif>
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="{{ $statusBaru }}">
                            <button type="submit"
                                class="rounded-xl px-4 py-3 text-[12px] font-extrabold transition-all
                                @if ($statusBaru === 'ditolak')
                                    bg-red-50 text-[#a20c15] hover:bg-[#ffe0dc] hover:text-[#a20c15]
                                @else
                                    bg-[#E52320] text-white hover:bg-[#a20c15]
                                @endif">
                                @php
                                    $label = ['diproses' => 'Proses Lapangan', 'selesai' => 'Tandai Selesai', 'ditolak' => 'Tandai Ditolak'][$statusBaru] ?? ucfirst($statusBaru);
                                @endphp
                                {{ $label }}
                            </button>
                        </form>
                    @endforeach
                </div>

                @if (in_array('ditolak', $transisi, true) && ! $laporan->mulai_penanganan_at)
                    <details class="mt-4 rounded-xl border border-red-100 bg-red-50/40 p-4" @if ($errors->has('alasan') || $errors->has('catatan')) open @endif>
                        <summary class="cursor-pointer text-[12px] font-extrabold text-[#a20c15]">Tolak Laporan (palsu / iseng)</summary>
                        <form method="POST" action="{{ route('damkar.laporan.tolak', $laporan) }}"
                              onsubmit="return confirm('Tolak laporan ini? Pelapor akan diberi tahu bahwa laporannya ditolak.')"
                              class="mt-3 space-y-3">
                            @csrf
                            @method('PATCH')
                            <div>
                                <label for="alasan" class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Alasan penolakan</label>
                                <select id="alasan" name="alasan" required class="mt-1 w-full rounded-lg border-slate-200 text-xs font-semibold text-slate-700 focus:border-red-500 focus:ring-red-500">
                                    <option value="">Pilih alasan…</option>
                                    @foreach (\App\Models\Laporan::ALASAN_PENOLAKAN as $opsi)
                                        <option value="{{ $opsi }}" @selected(old('alasan') === $opsi)>{{ $opsi }}</option>
                                    @endforeach
                                </select>
                                @error('alasan')<p class="mt-1 text-[11px] font-semibold text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="catatan" class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Catatan untuk pelapor (opsional)</label>
                                <textarea id="catatan" name="catatan" rows="2" maxlength="200" class="mt-1 w-full rounded-lg border-slate-200 text-xs text-slate-700 focus:border-red-500 focus:ring-red-500">{{ old('catatan') }}</textarea>
                                @error('catatan')<p class="mt-1 text-[11px] font-semibold text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <button type="submit" class="w-full rounded-xl bg-[#a20c15] px-4 py-3 text-[12px] font-extrabold text-white transition-all hover:bg-[#7e0911]">Tolak Laporan</button>
                        </form>
                    </details>
                @endif
            </div>
        @else
            <div class="rounded-xl border border-slate-100 bg-slate-50 p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-sm font-bold text-slate-900">Laporan Selesai</span>
                </div>
                <p class="text-[12px] text-slate-500">
                    Laporan ini sudah berstatus
                    <strong>{{ ['selesai' => 'Selesai', 'ditolak' => 'Ditolak'][$laporan->status] ?? $laporan->status }}</strong>
                    — tidak dapat diubah kembali.
                </p>
                @if ($laporan->status === 'ditolak' && $laporan->alasan_penolakan)
                    <p class="mt-2 text-[12px] text-slate-600"><span class="font-bold">Alasan:</span> {{ $laporan->alasan_penolakan }}</p>
                @endif
                @if ($laporan->status === 'selesai')
                    <div class="mt-4 pt-3 border-t border-slate-200">
                        <a href="{{ route('damkar.laporan.hasil', $laporan) }}"
                           class="w-full flex items-center justify-center gap-2 rounded-xl bg-[#E52329] px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-red-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h2a2 2 0 012 2h4a2 2 0 002-2h2a2 2 0 012 2v14a2 2 0 01-2 2z"/></svg>
                            <span>{{ $laporan->hasil_dibuat_pada ? 'Lihat / Edit Berita Hasil' : 'Lengkapi Berita Hasil Pemadaman' }}</span>
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <a href="{{ route('damkar.laporan.index') }}"
           class="inline-flex items-center gap-1.5 rounded-lg border border-[#E52320]/10 px-4 py-2.5 text-[12px] font-bold text-[#E52320] transition-all hover:bg-[#E52320]/5 hover:text-[#a20c15]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Laporan
        </a>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lat = {{ $laporan->latitude }};
        const lng = {{ $laporan->longitude }};
        const map = L.map('detail-map', { zoomControl: true, scrollWheelZoom: false }).setView([lat, lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const icon = L.divIcon({
            className: 'custom-detail-marker',
            html: `<div style="width:30px;height:30px;border-radius:50%;border:3px solid #fff;box-shadow:0 3px 8px rgba(0,0,0,.3);background:#E52320;display:flex;align-items:center;justify-content:center;"><div style="width:10px;height:10px;border-radius:50%;background:#fff;"></div></div>`,
            iconSize: [30, 30], iconAnchor: [15, 15], popupAnchor: [0, -15]
        });

        const marker = L.marker([lat, lng], { icon }).addTo(map);
        marker.bindPopup(`<strong>{{ addslashes($laporan->alamat) }}</strong><br>{{ addslashes($laporan->user?->name ?? 'Tamu') }}`).openPopup();

        setTimeout(() => map.invalidateSize(), 100);
    });
</script>
@endsection
