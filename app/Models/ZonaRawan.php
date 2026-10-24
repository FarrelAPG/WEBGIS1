<?php

namespace App\Models;

use Database\Factories\ZonaRawanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZonaRawan extends Model
{
    /** @use HasFactory<ZonaRawanFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'nama',
        'ciri',
        'latitude',
        'longitude',
        'radius_m',
        'jumlah_kejadian',
    ];

    /**
     * Zona dikategorikan risiko tinggi bila kejadiannya tinggi.
     */
    /**
     * Zona dikategorikan risiko tinggi bila memiliki >= 3 hotspot dalam satu cluster.
     * Threshold disesuaikan dengan data karhutla aktual (per cluster 5 km).
     */
    public function risikoTinggi(): bool
    {
        return $this->jumlah_kejadian >= 3;
    }
}
