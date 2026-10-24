<?php

namespace Database\Seeders;

use App\Models\ZonaRawan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonaRawanSeeder extends Seeder
{
    /**
     * Data Daerah Rawan Kebakaran Khusus Wilayah Administratif Kota Palembang.
     * Batas administratif Palembang: Lat (-3.12 s/d -2.88), Lng (104.65 s/d 104.85).
     * Semua titik di luar Kota Palembang (OKI, Ogan Ilir, Banyuasin) tidak dimasukkan.
     */
    public function run(): void
    {
        $zonaPalembang = [
            [
                'nama' => 'Seberang Ulu I (Kertapati & 3-4 Ulu)',
                'ciri' => 'Permukiman padat rumah kayu & 14 gang sempit',
                'latitude' => -2.9985,
                'longitude' => 104.7570,
                'radius_m' => 850,
                'jumlah_kejadian' => 68,
            ],
            [
                'nama' => 'Ilir Timur II (Pasar 16 & Kawasan Niaga)',
                'ciri' => 'Kawasan niaga padat ruko pertokoan & pasar tradisional',
                'latitude' => -2.9745,
                'longitude' => 104.7815,
                'radius_m' => 750,
                'jumlah_kejadian' => 54,
            ],
            [
                'nama' => 'Sukarami (Kebun Bunga & Pergudangan)',
                'ciri' => 'Area pergudangan terbuka & deret pasar',
                'latitude' => -2.9480,
                'longitude' => 104.7350,
                'radius_m' => 650,
                'jumlah_kejadian' => 42,
            ],
            [
                'nama' => 'Gandus (Karang Anyar & Lahan Rawa)',
                'ciri' => 'Lahan semak rawa kering & permukiman tepian sungai',
                'latitude' => -3.0180,
                'longitude' => 104.7260,
                'radius_m' => 900,
                'jumlah_kejadian' => 36,
            ],
            [
                'nama' => 'Seberang Ulu II (13 Ulu & Tangga Takat)',
                'ciri' => 'Permukiman padat pesisir Sungai Musi & instalasi lama',
                'latitude' => -2.9890,
                'longitude' => 104.7740,
                'radius_m' => 600,
                'jumlah_kejadian' => 39,
            ],
            [
                'nama' => 'Alang-Alang Lebar (Talang Kelapa)',
                'ciri' => 'Rawan kebakaran semak ilalang & lahan kering musim kemarau',
                'latitude' => -2.9230,
                'longitude' => 104.7120,
                'radius_m' => 800,
                'jumlah_kejadian' => 31,
            ],
            [
                'nama' => 'Sako / Sematang Borang',
                'ciri' => 'Area lahan tidur semak belukar & perumahan baru',
                'latitude' => -2.9190,
                'longitude' => 104.7960,
                'radius_m' => 700,
                'jumlah_kejadian' => 28,
            ],
            [
                'nama' => 'Kemuning (Pipa Reja & Sekip)',
                'ciri' => 'Kawasan padat penduduk perkotaan & jalur kelistrikan padat',
                'latitude' => -2.9550,
                'longitude' => 104.7590,
                'radius_m' => 550,
                'jumlah_kejadian' => 33,
            ],
        ];

        DB::table('zona_rawans')->truncate();

        foreach ($zonaPalembang as $item) {
            // Filter ketat: Hanya masukkan titik di dalam batas wilayah Kota Palembang
            if ($this->apakahDalamKotaPalembang($item['latitude'], $item['longitude'])) {
                ZonaRawan::create($item);
            }
        }
    }

    /**
     * Validasi apakah koordinat berada di dalam batas administratif Kota Palembang.
     */
    private function apakahDalamKotaPalembang(float $lat, float $lng): bool
    {
        return ($lat >= -3.12 && $lat <= -2.88 && $lng >= 104.65 && $lng <= 104.85);
    }
}
