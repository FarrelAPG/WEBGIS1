<?php

namespace App\Services;

use DateTimeImmutable;
use RuntimeException;
use UnexpectedValueException;

class HotspotZoneService
{
    private const CLUSTER_RADIUS_METERS = 5000;

    private const EARTH_RADIUS_METERS = 6371000;

    private const ZONE_BUFFER_METERS = 500;

    /**
     * @return list<array{
     *     id: int,
     *     nama: string,
     *     lat: float,
     *     lng: float,
     *     radius: int,
     *     jumlah: int,
     *     rataFrp: float,
     *     rataConfidence: float,
     *     tinggi: bool,
     *     hotspots: list<array{
     *         lat: float,
     *         lng: float,
     *         tanggal: string,
     *         waktu: string,
     *         satelit: string,
     *         frp: float,
     *         confidence: float
     *     }>
     * }>
     */
    public function clusters(): array
    {
        $path = base_path('database/data/hotspots_palembang.csv');

        if (! is_readable($path)) {
            throw new RuntimeException("Dataset hotspot tidak dapat dibaca: {$path}");
        }

        $file = fopen($path, 'r');

        if ($file === false) {
            throw new RuntimeException("Dataset hotspot gagal dibuka: {$path}");
        }

        try {
            $headers = fgetcsv($file, null, ',', '"', '\\');

            if (! is_array($headers)) {
                throw new UnexpectedValueException('Dataset hotspot tidak memiliki header CSV.');
            }

            $headers[0] = preg_replace('/^\xEF\xBB\xBF/', '', (string) $headers[0]);
            $headerIndexes = array_flip(array_map(
                static fn (string $header): string => trim($header),
                $headers,
            ));
            $requiredHeaders = [
                'latitude',
                'longitude',
                'acq_date',
                'acq_time',
                'satellite',
                'confidence',
                'frp',
            ];
            $missingHeaders = array_diff($requiredHeaders, array_keys($headerIndexes));

            if ($missingHeaders !== []) {
                throw new UnexpectedValueException(
                    'Dataset hotspot tidak memiliki kolom wajib: '.implode(', ', $missingHeaders),
                );
            }

            $hotspots = [];

            while (($row = fgetcsv($file, null, ',', '"', '\\')) !== false) {
                if ($row === [] || $row === [null]) {
                    continue;
                }

                $value = static function (string $header) use ($row, $headerIndexes): string {
                    return trim((string) ($row[$headerIndexes[$header]] ?? ''));
                };

                $latitude = $this->requiredFloat($value('latitude'), 'latitude');
                $longitude = $this->requiredFloat($value('longitude'), 'longitude');
                $confidence = $this->requiredFloat($value('confidence'), 'confidence');
                $frp = $this->requiredFloat($value('frp'), 'frp');
                $date = $value('acq_date');
                $time = $value('acq_time');
                $satellite = $value('satellite');
                $dateValue = DateTimeImmutable::createFromFormat('!Y-m-d', $date);

                if ($latitude < -90 || $latitude > 90 || $longitude < -180 || $longitude > 180) {
                    throw new UnexpectedValueException('Dataset hotspot memiliki koordinat di luar rentang.');
                }

                if ($confidence < 0 || $confidence > 100 || $frp < 0) {
                    throw new UnexpectedValueException('Dataset hotspot memiliki nilai FRP atau confidence tidak valid.');
                }

                if ($dateValue === false || $dateValue->format('Y-m-d') !== $date) {
                    throw new UnexpectedValueException("Tanggal akuisisi hotspot tidak valid: {$date}");
                }

                if (! preg_match('/^\d{1,4}$/', $time)) {
                    throw new UnexpectedValueException("Waktu akuisisi hotspot tidak valid: {$time}");
                }

                $time = str_pad($time, 4, '0', STR_PAD_LEFT);
                $hours = (int) substr($time, 0, 2);
                $minutes = (int) substr($time, 2, 2);

                if ($hours > 23 || $minutes > 59 || $satellite === '') {
                    throw new UnexpectedValueException('Dataset hotspot memiliki waktu atau satelit tidak valid.');
                }

                $hotspots[] = [
                    'lat' => $latitude,
                    'lng' => $longitude,
                    'tanggal' => $date,
                    'waktu' => "{$time[0]}{$time[1]}:{$time[2]}{$time[3]} UTC",
                    'satelit' => $satellite,
                    'frp' => $frp,
                    'confidence' => $confidence,
                ];
            }
        } finally {
            fclose($file);
        }

        return $this->groupHotspots($hotspots);
    }

    private function requiredFloat(string $value, string $field): float
    {
        if ($value === '' || ! is_numeric($value)) {
            throw new UnexpectedValueException("Nilai {$field} pada dataset hotspot tidak valid.");
        }

        return (float) $value;
    }

    /**
     * @param  list<array{
     *     lat: float,
     *     lng: float,
     *     tanggal: string,
     *     waktu: string,
     *     satelit: string,
     *     frp: float,
     *     confidence: float
     * }>  $hotspots
     * @return list<array{
     *     id: int,
     *     nama: string,
     *     lat: float,
     *     lng: float,
     *     radius: int,
     *     jumlah: int,
     *     rataFrp: float,
     *     rataConfidence: float,
     *     tinggi: bool,
     *     hotspots: list<array{
     *         lat: float,
     *         lng: float,
     *         tanggal: string,
     *         waktu: string,
     *         satelit: string,
     *         frp: float,
     *         confidence: float
     *     }>
     * }>
     */
    private function groupHotspots(array $hotspots): array
    {
        $visited = array_fill(0, count($hotspots), false);
        $zones = [];

        foreach ($hotspots as $index => $hotspot) {
            if ($visited[$index]) {
                continue;
            }

            $visited[$index] = true;
            $members = [$index];

            for ($memberIndex = 0; $memberIndex < count($members); $memberIndex++) {
                $current = $hotspots[$members[$memberIndex]];

                foreach ($hotspots as $candidateIndex => $candidate) {
                    if ($visited[$candidateIndex]) {
                        continue;
                    }

                    if ($this->distanceInMeters($current, $candidate) <= self::CLUSTER_RADIUS_METERS) {
                        $visited[$candidateIndex] = true;
                        $members[] = $candidateIndex;
                    }
                }
            }

            $cluster = array_map(
                static fn (int $memberIndex): array => $hotspots[$memberIndex],
                $members,
            );
            $count = count($cluster);
            $latitude = array_sum(array_column($cluster, 'lat')) / $count;
            $longitude = array_sum(array_column($cluster, 'lng')) / $count;
            $centroid = ['lat' => $latitude, 'lng' => $longitude];
            $radius = max(array_map(
                fn (array $member): float => $this->distanceInMeters($centroid, $member),
                $cluster,
            )) + self::ZONE_BUFFER_METERS;

            $zones[] = [
                'id' => count($zones) + 1,
                'nama' => 'Sektor '.str_pad((string) (count($zones) + 1), 2, '0', STR_PAD_LEFT),
                'lat' => $latitude,
                'lng' => $longitude,
                'radius' => (int) round($radius),
                'jumlah' => $count,
                'rataFrp' => round(array_sum(array_column($cluster, 'frp')) / $count, 1),
                'rataConfidence' => round(array_sum(array_column($cluster, 'confidence')) / $count, 1),
                'tinggi' => $count >= 3,
                'hotspots' => $cluster,
            ];
        }

        return $zones;
    }

    /**
     * @param  array{lat: float, lng: float}  $first
     * @param  array{lat: float, lng: float}  $second
     */
    private function distanceInMeters(array $first, array $second): float
    {
        $latitudeDifference = deg2rad($second['lat'] - $first['lat']);
        $longitudeDifference = deg2rad($second['lng'] - $first['lng']);
        $haversine = sin($latitudeDifference / 2) ** 2
            + cos(deg2rad($first['lat'])) * cos(deg2rad($second['lat']))
            * sin($longitudeDifference / 2) ** 2;

        return self::EARTH_RADIUS_METERS * 2 * atan2(sqrt($haversine), sqrt(1 - $haversine));
    }
}
