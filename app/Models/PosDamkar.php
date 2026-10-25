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

    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class);
    }

    /**
     * Fallback data pos damkar jika database kosong atau belum ter-migrate di hosting serverless
     */
    public static function daftarDefault(): \Illuminate\Database\Eloquent\Collection
    {
        $data = [
            [
                'id' => 1,
                'nama' => 'Pos Pemadam Kertapati',
                'unit' => 'N001',
                'alamat' => 'Jl. Lintas Sumatera, Karya Jaya, Kec. Kertapati, Kota Palembang, Sumatera Selatan 30862',
                'latitude' => -3.0863753,
                'longitude' => 104.7260711,
            ],
            [
                'id' => 2,
                'nama' => 'Pos Damkar Gandus',
                'unit' => 'N002',
                'alamat' => 'Jl. Syakyakirti, Karang Anyar, Kec. Gandus, Kota Palembang, Sumatera Selatan 30148',
                'latitude' => -3.0202858,
                'longitude' => 104.7275797,
            ],
            [
                'id' => 3,
                'nama' => 'Pos Damkar Seberang Ulu II',
                'unit' => 'N003',
                'alamat' => 'Jl. KH. Azhari, 13 Ulu, Kec. Seberang Ulu II, Kota Palembang, Sumatera Selatan 30263',
                'latitude' => -2.9884191,
                'longitude' => 104.7733975,
            ],
            [
                'id' => 4,
                'nama' => 'Pos Damkar Kemuning',
                'unit' => 'N004',
                'alamat' => 'Jl. R. Sukamto Jl. Rawasari, 20 Ilir D II, Kec. Ilir Tim. II, Kota Palembang, Sumatera Selatan 30114',
                'latitude' => -2.9525614,
                'longitude' => 104.7591222,
            ],
            [
                'id' => 5,
                'nama' => 'Pos Damkar Seberang Ulu I',
                'unit' => 'N005',
                'alamat' => 'Jl. KH. Moh. Asyik, 3-4 Ulu, Kecamatan Seberang Ulu I, Kota Palembang, Sumatera Selatan 30122',
                'latitude' => -3.0072185,
                'longitude' => 104.7606275,
            ],
            [
                'id' => 6,
                'nama' => 'DINAS PEMADAM KEBAKARAN "POS SAKO" SEMATANG BORANG',
                'unit' => 'N006',
                'alamat' => 'Jl. Sematang Borang, Sako, Kec. Sako, Kota Palembang, Sumatera Selatan 30961',
                'latitude' => -2.9205821,
                'longitude' => 104.7979827,
            ],
            [
                'id' => 7,
                'nama' => 'Pos Pemadam Alang-alang Lebar',
                'unit' => 'N007',
                'alamat' => 'Jl. Soekarno Hatta, Karya Baru, Kec. Alang-Alang Lebar, Kota Palembang, Sumatera Selatan 30961',
                'latitude' => -2.9254775,
                'longitude' => 104.7095849,
            ],
            [
                'id' => 8,
                'nama' => 'Pos Pemadam Merdeka',
                'unit' => 'N008',
                'alamat' => 'Jl. Merdeka No.8, 19 Ilir, Kec. Bukit Kecil, Kota Palembang, Sumatera Selatan 30113',
                'latitude' => -2.9894783,
                'longitude' => 104.7582889,
            ],
        ];

        return new \Illuminate\Database\Eloquent\Collection(
            array_map(function ($item) {
                $pos = new self($item);
                $pos->id = $item['id'];
                $pos->exists = true;
                $pos->setRelation('kendaraan', collect());
                return $pos;
            }, $data)
        );
    }
}
