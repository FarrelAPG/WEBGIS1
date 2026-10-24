<?php

namespace App\Http\Controllers;

use App\Models\PosDamkar;
use App\Models\ZonaRawan;
use App\Services\IsokronService;
use Throwable;

class PetaController extends Controller
{
    public function index()
    {
        $posDamkarList = PosDamkar::orderBy('nama')->get();
        $zonaRawan = ZonaRawan::orderByDesc('jumlah_kejadian')->get();

        return view('damkar.peta', compact('posDamkarList', 'zonaRawan'));
    }

    /** Area jangkauan (isokron) satu pos, mengikuti jalan. Dipanggil peta saat sebuah pos dipilih. */
    public function isokron(PosDamkar $posDamkar, IsokronService $isokron)
    {
        try {
            return response()->json($isokron->untuk($posDamkar));
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'pesan' => 'Layanan rute tidak merespons. Coba lagi beberapa saat lagi.',
            ], 502);
        }
    }

    public function sumberAir()
    {
        $sumberAir = [
            [
                'nama' => 'Waterpark Fantasy Island',
                'jenis' => 'Kolam',
                'alamat' => 'Jl. Lintas Sumatera, Kel. Karya Jaya, Kec. Kertapati, Kota Palembang',
                'latitude' => -3.0769230,
                'longitude' => 104.7262407,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Kolam Retensi Jakabaring',
                'jenis' => 'Kolam Retensi',
                'alamat' => 'Jl. Jakabaring, Kel 9/10 Ulu, Kec. Jakabaring, Kota Palembang',
                'latitude' => -2.9999441,
                'longitude' => 104.7723835,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Danau Opi Jakabaring',
                'jenis' => 'Danau',
                'alamat' => 'Jl. Maluku, Kel. Sungai Kedukan, Kec. Rambutan, Kab. Banyuasin',
                'latitude' => -3.0483981,
                'longitude' => 104.7884650,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Dermaga Kapal Kertapati',
                'jenis' => 'Sungai',
                'alamat' => 'Jl. Ki Marogan (Halte Integrasi), Kel. Kertapati, Kec. Kertapati, Kota Palembang',
                'latitude' => -3.0161605,
                'longitude' => 104.7521804,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Waduk Talang Aman 1',
                'jenis' => 'Waduk',
                'alamat' => 'Jl. Perikanan 4, Kel. Talang Aman, Kec. Kemuning, Kota Palembang',
                'latitude' => -2.9513063,
                'longitude' => 104.7442156,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Kolam Retensi PTC',
                'jenis' => 'Kolam Retensi',
                'alamat' => 'Jl. Seduduk Putih 1, Kel. Pipa Jaya, Kec. Ilir Timur III, Kota Palembang',
                'latitude' => -2.9476000,
                'longitude' => 104.7572562,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Kolam Retensi Citra Damai',
                'jenis' => 'Kolam Retensi',
                'alamat' => 'Jl. Bakung, Citra Gardenia, Kel. Bukit Sangkal, Kec. Kalidoni, Kota Palembang',
                'latitude' => -2.9442095,
                'longitude' => 104.7782827,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Kolam Retensi IBA',
                'jenis' => 'Kolam Retensi',
                'alamat' => 'Jl. Mayor Ruslan, Kel. 20 Ilir D II, Kec. Ilir Timur I, Kota Palembang',
                'latitude' => -2.9658854,
                'longitude' => 104.7644219,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Waduk Albarokah Sei Buah',
                'jenis' => 'Waduk',
                'alamat' => 'Jl. Mayor (Laut) Wiratno Lr. Al. Barokah, Kel. Sungai Buah, Kec. Ilir Timur II, Kota Palembang',
                'latitude' => -2.9704651,
                'longitude' => 104.7930268,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Dermaga Sungai Lais',
                'jenis' => 'Sungai',
                'alamat' => 'Jl. May Zen, Kel. Sei Lais, Kec. Kalidoni, Kota Palembang',
                'latitude' => -2.9827604,
                'longitude' => 104.8360986,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Dermaga Jukung Herman 9/10 Ulu',
                'jenis' => 'Sungai',
                'alamat' => 'Jl. Benteng (Terminal Jukung), Kel. 9/10 Ulu, Kec. Jakabaring, Kota Palembang',
                'latitude' => -2.9921670,
                'longitude' => 104.7650185,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Kolam Retensi KM.12 Penginapan Terminal',
                'jenis' => 'Kolam Retensi',
                'alamat' => 'Jl. Bypass Alang-Alang Lebar, Kel. Talang Kelapa, Kec. Alang-Alang Lebar, Kota Palembang',
                'latitude' => -2.9159753,
                'longitude' => 104.6825100,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Pondok Pindang Danau',
                'jenis' => 'Danau',
                'alamat' => 'Jl. Soekarno Hatta, Kel. Karya Baru, Kec. Alang-Alang Lebar, Kota Palembang',
                'latitude' => -2.9246352,
                'longitude' => 104.7106823,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Pelabuhan Sungai Gasing',
                'jenis' => 'Sungai',
                'alamat' => 'Pelabuhan Sungai Gasing, Kenten Laut, Kec. Talang Klp., Kab. Banyuasin, Sumatera Selatan 30961',
                'latitude' => -2.7956703,
                'longitude' => 104.7468532,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Kolam Retensi Kenten Seberang',
                'jenis' => 'Kolam Retensi',
                'alamat' => 'Kolam Retensi Kenten Seberang, Unnamed Road, Tanah MAS, Kec. Talang Klp., Kab. Banyuasin, Sumatera Selatan 30961',
                'latitude' => -2.8864947,
                'longitude' => 104.7739512,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Kolam Retensi Kancil Putih Pulau',
                'jenis' => 'Kolam Retensi',
                'alamat' => 'Kolam Retensi Kancil Putih Pulau, Jl. Kancil Putih IV, Demang Lebar Daun, Kec. Ilir Bar. I, Kota Palembang, Sumatera Selatan 30153',
                'latitude' => -2.9795181,
                'longitude' => 104.7187950,
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Taman Kambang Iwak Besak',
                'jenis' => 'Kolam',
                'alamat' => 'Taman Kambang Iwak Besak, Jl. Tasik, Talang Semut, Bukit Kecil, Kota Palembang, Sumatera Selatan 30121',
                'latitude' => -2.9898005,
                'longitude' => 104.7464618,
                'status' => 'Tersedia',
            ],
        ];

        return view('damkar.peta.sumber-air', compact('sumberAir'));
    }

    public function rawanBencana()
    {
        $zonaRawan = ZonaRawan::orderByDesc('jumlah_kejadian')->get();

        return view('damkar.peta.rawan-bencana', compact('zonaRawan'));
    }

    public function publik()
    {
        $posDamkarList = PosDamkar::orderBy('nama')->get();

        return view('peta', compact('posDamkarList'));
    }
}
