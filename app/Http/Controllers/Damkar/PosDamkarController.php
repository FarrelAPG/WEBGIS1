<?php

namespace App\Http\Controllers\Damkar;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\PosDamkar;
use Illuminate\Contracts\View\View;

class PosDamkarController extends Controller
{
    public function index(): View
    {
        $posDamkarList = PosDamkar::query()
            ->with(['kendaraan' => fn ($query) => $query->orderBy('kode')])
            ->withCount([
                'kendaraan as armada_total',
                'kendaraan as armada_siaga' => fn ($query) => $query->where('status', 'siaga'),
            ])
            ->orderBy('unit')
            ->get();

        return view('damkar.pos_damkar', [
            'posDamkarList' => $posDamkarList,
            'armadaSiaga' => Kendaraan::siaga()->count(),
            'armadaTotal' => Kendaraan::count(),
        ]);
    }
}
