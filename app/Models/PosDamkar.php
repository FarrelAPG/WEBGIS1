<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosDamkar extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'nama',
        'unit',
        'alamat',
        'latitude',
        'longitude',
    ];
}
