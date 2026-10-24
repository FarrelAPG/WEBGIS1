@php
    $label = ['pending' => 'Menunggu Tim', 'diproses' => 'Penanganan', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'][$status] ?? ucfirst($status);
    $style = [
        'pending' => 'bg-amber-50 text-amber-600',
        'diproses' => 'bg-red-50 text-red-600',
        'selesai' => 'bg-emerald-50 text-emerald-600',
        'ditolak' => 'bg-slate-100 text-slate-500',
    ][$status] ?? 'bg-slate-100 text-slate-500';
@endphp
<span class="inline-flex shrink-0 items-center rounded-md px-2.5 py-1 text-[10px] font-extrabold {{ $style }}">{{ $label }}</span>
