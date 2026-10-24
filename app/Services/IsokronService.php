<?php

namespace App\Services;

use App\Models\PosDamkar;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Isokron (area jangkauan berdasarkan waktu tempuh JALAN RAYA) dari sebuah pos pemadam.
 *
 * Bentuk area mengikuti jaringan jalan, bukan lingkaran. Data dihitung oleh mesin rute:
 *  - OpenRouteService bila ISOKRON_ORS_KEY diisi (disarankan untuk produksi), atau
 *  - Valhalla (server publik OSM/FOSSGIS) bila tidak ada kunci.
 * Hasil di-cache karena posisi pos jarang berubah.
 */
class IsokronService
{
    /** Batas waktu tempuh (menit) yang digambar. */
    public const MENIT = [5, 10, 15];

    /**
     * @return array{type: string, features: list<array<string, mixed>>}
     *
     * @throws RuntimeException bila mesin rute tidak bisa dihubungi / jawabannya tidak valid
     */
    public function untuk(PosDamkar $pos): array
    {
        $kunci = sprintf('isokron:v1:%d:%.5f:%.5f', $pos->id, $pos->latitude, $pos->longitude);

        // Cache::remember tidak menyimpan apa pun bila closure melempar exception (gagal tidak ikut ter-cache)
        return Cache::remember($kunci, now()->addDays(30), function () use ($pos) {
            $fitur = config('services.isokron.ors_key')
                ? $this->dariOpenRouteService((float) $pos->latitude, (float) $pos->longitude)
                : $this->dariValhalla((float) $pos->latitude, (float) $pos->longitude);

            return $this->rapikan($fitur);
        });
    }

    /** @return list<array<string, mixed>> */
    private function dariValhalla(float $lat, float $lng): array
    {
        $permintaan = [
            'locations' => [['lat' => $lat, 'lon' => $lng]],
            'costing' => 'auto',
            'contours' => array_map(fn (int $m) => ['time' => $m], self::MENIT),
            'polygons' => true,
            'denoise' => 0.5,
            'generalize' => 30,
        ];

        $respons = Http::timeout(25)
            ->acceptJson()
            ->withHeaders(['User-Agent' => config('app.name', 'SIGAP').' isokron'])
            ->get(config('services.isokron.valhalla_url'), ['json' => json_encode($permintaan)]);

        if (! $respons->successful()) {
            throw new RuntimeException('Valhalla menjawab HTTP '.$respons->status());
        }

        return collect($respons->json('features', []))
            ->map(fn ($f) => [
                'menit' => (int) round((float) data_get($f, 'properties.contour', 0)),
                'geometry' => $f['geometry'] ?? null,
            ])
            ->all();
    }

    /** @return list<array<string, mixed>> */
    private function dariOpenRouteService(float $lat, float $lng): array
    {
        $respons = Http::timeout(25)
            ->acceptJson()
            ->withHeaders(['Authorization' => config('services.isokron.ors_key')])
            ->post(config('services.isokron.ors_url'), [
                'locations' => [[$lng, $lat]],
                'range' => array_map(fn (int $m) => $m * 60, self::MENIT),
                'range_type' => 'time',
            ]);

        if (! $respons->successful()) {
            throw new RuntimeException('OpenRouteService menjawab HTTP '.$respons->status());
        }

        return collect($respons->json('features', []))
            ->map(fn ($f) => [
                'menit' => (int) round(((float) data_get($f, 'properties.value', 0)) / 60),
                'geometry' => $f['geometry'] ?? null,
            ])
            ->all();
    }

    /**
     * Saring bentuk yang tidak valid, urutkan dari area terbesar (15 mnt) ke terkecil (5 mnt)
     * supaya area kecil tergambar di atas area besar.
     *
     * @param  list<array<string, mixed>>  $fitur
     * @return array{type: string, features: list<array<string, mixed>>}
     */
    private function rapikan(array $fitur): array
    {
        $fitur = collect($fitur)
            ->filter(fn ($f) => in_array($f['menit'], self::MENIT, true)
                && in_array(data_get($f, 'geometry.type'), ['Polygon', 'MultiPolygon'], true)
                && ! empty(data_get($f, 'geometry.coordinates')))
            ->sortByDesc('menit')
            ->values();

        if ($fitur->isEmpty()) {
            throw new RuntimeException('Mesin rute tidak mengembalikan area isokron.');
        }

        return [
            'type' => 'FeatureCollection',
            'features' => $fitur->map(fn ($f) => [
                'type' => 'Feature',
                'properties' => ['menit' => $f['menit']],
                'geometry' => $f['geometry'],
            ])->all(),
        ];
    }
}
