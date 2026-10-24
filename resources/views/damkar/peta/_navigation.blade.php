<nav aria-label="Navigasi Peta" class="flex flex-wrap items-center gap-2 rounded-2xl border border-slate-200 bg-white p-2 shadow-sm">
    <a href="{{ route('damkar.peta') }}" @if (request()->routeIs('damkar.peta') ) aria-current="page" @endif
        class="rounded-xl px-4 py-2.5 text-sm font-bold transition {{ request()->routeIs('damkar.peta') ? 'bg-[#E52329] text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50' }}">Jangkauan</a>
    <a href="{{ route('damkar.peta.sumber-air') }}" @if (request()->routeIs('damkar.peta.sumber-air')) aria-current="page" @endif
        class="rounded-xl px-4 py-2.5 text-sm font-bold transition {{ request()->routeIs('damkar.peta.sumber-air') ? 'bg-[#E52329] text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50' }}">Sumber Air</a>
    <a href="{{ route('damkar.peta.rawan-bencana') }}" @if (request()->routeIs('damkar.peta.rawan-bencana')) aria-current="page" @endif
        class="rounded-xl px-4 py-2.5 text-sm font-bold transition {{ request()->routeIs('damkar.peta.rawan-bencana') ? 'bg-[#E52329] text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50' }}">Peta Rawan Bencana</a>
</nav>
