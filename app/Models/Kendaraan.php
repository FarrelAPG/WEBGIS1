<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'kode',
        'nama',
        'pos_damkar_id',
        'jenis',
        'spesifikasi',
        'ukuran',
        'status',
        'latitude',
        'longitude',
    ];

    /** Kendaraan yang masih kosong/siaga dipanggil. @return \Illuminate\Database\Eloquent\Builder */
    public function scopeSiaga($query)
    {
        return $query->where('status', 'siaga');
    }

    public function posDamkar()
    {
        return $this->belongsTo(PosDamkar::class);
    }

    public function laporan()
    {
        return $this->hasOne(Laporan::class);
    }
}
