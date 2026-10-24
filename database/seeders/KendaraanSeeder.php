<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use App\Models\PosDamkar;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    /**
     * Armada pemadam per pos, Kota Palembang
     * (sumber: Damkar_kendaraan_palembang.csv, 20 unit di 8 pos; semua berstatus Operasional = siaga).
     *
     * Aman dijalankan berulang: data dicocokkan per kode unit, dan status yang sedang
     * berjalan (bergerak/dipanggil) tidak direset. Jalankan setelah PosDamkarSeeder:
     *   php artisan db:seed --class=KendaraanSeeder
     */
    public function run(): void
    {
        $armada = [
            ['pos' => 'N001', 'kode' => 'Unit-23', 'jenis' => 'Fire Tanker', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Kecil'],
            ['pos' => 'N002', 'kode' => 'Unit-03', 'jenis' => 'Fire Truck', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Besar'],
            ['pos' => 'N002', 'kode' => 'Unit-20', 'jenis' => 'Fire Tanker', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Kecil'],
            ['pos' => 'N003', 'kode' => 'Unit-08', 'jenis' => 'Fire Tanker', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Kecil'],
            ['pos' => 'N003', 'kode' => 'Unit-09', 'jenis' => 'Fire Tanker', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Kecil'],
            ['pos' => 'N004', 'kode' => 'Unit-01', 'jenis' => 'Fire Truck', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Besar'],
            ['pos' => 'N004', 'kode' => 'Unit-19', 'jenis' => 'Fire Truck', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Besar'],
            ['pos' => 'N004', 'kode' => 'Unit-12', 'jenis' => 'Quick Response', 'spesifikasi' => 'Hino Dutro', 'ukuran' => 'Kecil'],
            ['pos' => 'N005', 'kode' => 'Unit-02', 'jenis' => 'Fire Truck', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Besar'],
            ['pos' => 'N005', 'kode' => 'Unit-04', 'jenis' => 'Fire Truck', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Besar'],
            ['pos' => 'N005', 'kode' => 'Unit-25', 'jenis' => 'Fire Tanker', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Kecil'],
            ['pos' => 'N005', 'kode' => 'Unit-27', 'jenis' => 'Fire Tanker', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Kecil'],
            ['pos' => 'N006', 'kode' => 'Unit-07', 'jenis' => 'Fire Tanker', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Kecil'],
            ['pos' => 'N006', 'kode' => 'Unit-21', 'jenis' => 'Fire Truck', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Besar'],
            ['pos' => 'N007', 'kode' => 'Unit-05', 'jenis' => 'Fire Tanker', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Kecil'],
            ['pos' => 'N007', 'kode' => 'Unit-17', 'jenis' => 'Fire Truck', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Besar'],
            ['pos' => 'N008', 'kode' => 'Unit-28', 'jenis' => 'Fire Tanker', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Kecil'],
            ['pos' => 'N008', 'kode' => 'Unit-16', 'jenis' => 'Fire Truck', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Besar'],
            ['pos' => 'N008', 'kode' => 'Unit-18', 'jenis' => 'Fire Truck', 'spesifikasi' => 'Hino 500', 'ukuran' => 'Besar'],
            ['pos' => 'N008', 'kode' => 'Unit-11', 'jenis' => 'Quick Response', 'spesifikasi' => 'Hino Dutro', 'ukuran' => 'Kecil'],
        ];

        $pos = PosDamkar::pluck('id', 'unit'); // 'N001' => id

        foreach ($armada as $item) {
            $posDamkar = PosDamkar::find($pos[$item['pos']] ?? null);

            $kendaraan = Kendaraan::firstOrNew(['kode' => $item['kode']]);
            $kendaraan->fill([
                'nama' => $item['jenis'].' '.$item['spesifikasi'],
                'pos_damkar_id' => $posDamkar?->id,
                'jenis' => $item['jenis'],
                'spesifikasi' => $item['spesifikasi'],
                'ukuran' => $item['ukuran'],
                // unit siaga berada di posnya
                'latitude' => $posDamkar?->latitude,
                'longitude' => $posDamkar?->longitude,
            ]);

            if (! $kendaraan->exists) {
                $kendaraan->status = 'siaga';
            }

            $kendaraan->save();
        }
    }
}
