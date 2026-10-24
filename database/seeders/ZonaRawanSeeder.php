<?php

namespace Database\Seeders;

use App\Models\ZonaRawan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonaRawanSeeder extends Seeder
{
    /**
     * Data Titik Zona Rawan Bencana Kebakaran (MODIS Satellite Hotspot Dataset).
     * Dihitung berdasarkan clustering jarak terdekat (radius <= 5 km) dengan buffer radius sebaran.
     */
    public function run(): void
    {
        $zonaData = [
            [
                'nama' => 'Muara Kuang / Kuang Dalam (Sektor 4)',
                'ciri' => 'Hotspot MODIS Terra · Rata-rata FRP 19.0 MW · Confidence 51%',
                'latitude' => -3.129060,
                'longitude' => 104.430480,
                'radius_m' => 3075,
                'jumlah_kejadian' => 7,
            ],
            [
                'nama' => 'Makarti Jaya / Air Salek (Sektor 5)',
                'ciri' => 'Hotspot MODIS Terra · Rata-rata FRP 10.7 MW · Confidence 56%',
                'latitude' => -2.978880,
                'longitude' => 105.152830,
                'radius_m' => 2556,
                'jumlah_kejadian' => 3,
            ],
            [
                'nama' => 'Pangkalan Lampam (Sektor 1)',
                'ciri' => 'Hotspot MODIS Terra · Rata-rata FRP 26.5 MW · Confidence 66%',
                'latitude' => -3.347210,
                'longitude' => 105.196180,
                'radius_m' => 2850,
                'jumlah_kejadian' => 2,
            ],
            [
                'nama' => 'Pangkalan Lampam (Sektor 2)',
                'ciri' => 'Hotspot MODIS Terra · Rata-rata FRP 17.8 MW · Confidence 62%',
                'latitude' => -3.378610,
                'longitude' => 105.126560,
                'radius_m' => 1051,
                'jumlah_kejadian' => 2,
            ],
            [
                'nama' => 'Pangkalan Lampam (Sektor 3)',
                'ciri' => 'Hotspot MODIS Terra · Rata-rata FRP 7.9 MW · Confidence 50%',
                'latitude' => -3.380650,
                'longitude' => 105.177300,
                'radius_m' => 1126,
                'jumlah_kejadian' => 2,
            ],
            [
                'nama' => 'Delta Musi / Banyuasin (Sektor 6)',
                'ciri' => 'Hotspot MODIS Terra · Rata-rata FRP 8.2 MW · Confidence 54%',
                'latitude' => -3.032700,
                'longitude' => 105.074960,
                'radius_m' => 2997,
                'jumlah_kejadian' => 2,
            ],
            [
                'nama' => 'Tulung Selapan (Sektor 9)',
                'ciri' => 'Hotspot MODIS Terra · Rata-rata FRP 19.1 MW · Confidence 74%',
                'latitude' => -3.403060,
                'longitude' => 105.265920,
                'radius_m' => 1135,
                'jumlah_kejadian' => 2,
            ],
            [
                'nama' => 'Delta Musi / Banyuasin (Sektor 7)',
                'ciri' => 'Hotspot MODIS Terra · Rata-rata FRP 10.3 MW · Confidence 68%',
                'latitude' => -3.032950,
                'longitude' => 105.041690,
                'radius_m' => 600,
                'jumlah_kejadian' => 1,
            ],
            [
                'nama' => 'Pangkalan Lampam (Sektor 8)',
                'ciri' => 'Hotspot MODIS Terra · Rata-rata FRP 10.4 MW · Confidence 60%',
                'latitude' => -3.466240,
                'longitude' => 105.130840,
                'radius_m' => 600,
                'jumlah_kejadian' => 1,
            ],
        ];

        DB::table('zona_rawans')->truncate();

        foreach ($zonaData as $item) {
            ZonaRawan::create($item);
        }
    }
}
