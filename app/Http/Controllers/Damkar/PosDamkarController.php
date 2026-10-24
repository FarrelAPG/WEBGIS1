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
            ->orderBy('unit')
            ->get();

        return view('damkar.pos_damkar', [
            'posDamkarList' => $posDamkarList,
            'armadaSiaga' => Kendaraan::siaga()->count(),
        ]);
    }
}
