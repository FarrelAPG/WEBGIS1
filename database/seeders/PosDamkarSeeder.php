<?php

namespace Database\Seeders;

use App\Models\PosDamkar;
use Illuminate\Database\Seeder;

class PosDamkarSeeder extends Seeder
{
    /**
     * Data titik pos pemadam kebakaran Kota Palembang
     * (sumber: tikoor_pos_pemadamKebakaran_Google_Earth.csv).
     *
     * Aman dijalankan berulang: data dicocokkan per kode unit, dan pos yang
     * tidak ada di daftar ini dihapus supaya titik lama tidak tersisa.
     * Jalankan: php artisan db:seed --class=PosDamkarSeeder
     */
    public function run(): void
    {
        $pos = [
            [
                'nama' => 'Pos Pemadam Kertapati',
                'unit' => 'N001',
                'alamat' => 'Jl. Lintas Sumatera, Karya Jaya, Kec. Kertapati, Kota Palembang, Sumatera Selatan 30862',
                'latitude' => -3.0863753,
                'longitude' => 104.7260711,
            ],
            [
                'nama' => 'Pos Damkar Gandus',
                'unit' => 'N002',
                'alamat' => 'Jl. Syakyakirti, Karang Anyar, Kec. Gandus, Kota Palembang, Sumatera Selatan 30148',
                'latitude' => -3.0202858,
                'longitude' => 104.7275797,
            ],
            [
                'nama' => 'Pos Damkar Seberang Ulu II',
                'unit' => 'N003',
                'alamat' => 'Jl. KH. Azhari, 13 Ulu, Kec. Seberang Ulu II, Kota Palembang, Sumatera Selatan 30263',
                'latitude' => -2.9884191,
                'longitude' => 104.7733975,
            ],
            [
                'nama' => 'Pos Damkar Kemuning',
                'unit' => 'N004',
                'alamat' => 'Jl. R. Sukamto Jl. Rawasari, 20 Ilir D II, Kec. Ilir Tim. II, Kota Palembang, Sumatera Selatan 30114',
                'latitude' => -2.9525614,
                'longitude' => 104.7591222,
            ],
            [
                'nama' => 'Pos Damkar Seberang Ulu I',
                'unit' => 'N005',
                'alamat' => 'Jl. KH. Moh. Asyik, 3-4 Ulu, Kecamatan Seberang Ulu I, Kota Palembang, Sumatera Selatan 30122',
                'latitude' => -3.0072185,
                'longitude' => 104.7606275,
            ],
            [
                'nama' => 'DINAS PEMADAM KEBAKARAN "POS SAKO" SEMATANG BORANG',
                'unit' => 'N006',
                'alamat' => 'Jl. Sematang Borang, Sako, Kec. Sako, Kota Palembang, Sumatera Selatan 30961',
                'latitude' => -2.9205821,
                'longitude' => 104.7979827,
            ],
            [
                'nama' => 'Pos Pemadam Alang-alang Lebar',
                'unit' => 'N007',
                'alamat' => 'Jl. Soekarno Hatta, Karya Baru, Kec. Alang-Alang Lebar, Kota Palembang, Sumatera Selatan 30961',
                'latitude' => -2.9254775,
                'longitude' => 104.7095849,
            ],
            [
                'nama' => 'Pos Pemadam Merdeka',
                'unit' => 'N008',
                'alamat' => 'Jl. Merdeka No.8, 19 Ilir, Kec. Bukit Kecil, Kota Palembang, Sumatera Selatan 30113',
                'latitude' => -2.9894783,
                'longitude' => 104.7582889,
            ],
        ];

        foreach ($pos as $item) {
            PosDamkar::updateOrCreate(['unit' => $item['unit']], $item);
        }

        PosDamkar::whereNotIn('unit', array_column($pos, 'unit'))->delete();
    }
}
