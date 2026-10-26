<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use RuntimeException;

#[Signature('hotspots:filter-palembang {source : Path to the source CSV} {--output= : Destination CSV path}')]
#[Description('Filter VIIRS hotspot CSV records to the Palembang bounding box')]
class FilterPalembangHotspots extends Command
{
    private const MIN_LATITUDE = -3.10;

    private const MAX_LATITUDE = -2.85;

    private const MIN_LONGITUDE = 104.60;

    private const MAX_LONGITUDE = 104.90;

    public function handle(): int
    {
        $sourcePath = (string) $this->argument('source');

        if (! file_exists($sourcePath)) {
            $this->error("File sumber tidak ditemukan: {$sourcePath}");

            return Command::FAILURE;
        }

        $source = @fopen($sourcePath, 'r');

        if ($source === false) {
            $this->error("File sumber gagal dibuka: {$sourcePath}");

            return Command::FAILURE;
        }

        try {
            $headers = fgetcsv($source, null, ',', '"', '\\');

            if (! is_array($headers)) {
                $this->error('File sumber tidak memiliki header CSV.');

                return Command::FAILURE;
            }

            $headers[0] = preg_replace('/^\xEF\xBB\xBF/', '', (string) $headers[0]);
            $headerIndexes = array_flip(array_map(
                static fn (string $header): string => trim($header),
                $headers,
            ));
            $missingHeaders = array_diff([
                'latitude',
                'longitude',
                'acq_date',
                'acq_time',
                'satellite',
                'confidence',
                'frp',
            ], array_keys($headerIndexes));

            if ($missingHeaders !== []) {
                $this->error('Kolom koordinat wajib tidak ditemukan: '.implode(', ', $missingHeaders));

                return Command::FAILURE;
            }

            $filteredRows = [];
            $invalidRows = 0;

            while (($row = fgetcsv($source, null, ',', '"', '\\')) !== false) {
                if ($row === [] || $row === [null]) {
                    continue;
                }

                $latitude = trim((string) ($row[$headerIndexes['latitude']] ?? ''));
                $longitude = trim((string) ($row[$headerIndexes['longitude']] ?? ''));

                if (! is_numeric($latitude) || ! is_numeric($longitude)) {
                    $invalidRows++;

                    continue;
                }

                $latitude = (float) $latitude;
                $longitude = (float) $longitude;

                if (
                    $latitude >= self::MIN_LATITUDE
                    && $latitude <= self::MAX_LATITUDE
                    && $longitude >= self::MIN_LONGITUDE
                    && $longitude <= self::MAX_LONGITUDE
                ) {
                    $filteredRows[] = $row;
                }
            }
        } finally {
            fclose($source);
        }

        $outputPath = (string) ($this->option('output') ?: base_path('database/data/hotspots_palembang.csv'));
        $outputDirectory = dirname($outputPath);

        if (! is_dir($outputDirectory)) {
            $this->error("Direktori output tidak valid: {$outputDirectory}");

            return Command::FAILURE;
        }

        $output = @fopen($outputPath, 'w');

        if ($output === false) {
            $this->error("File output gagal dibuat: {$outputPath}");

            return Command::FAILURE;
        }

        try {
            if (fputcsv($output, $headers, ',', '"', '\\') === false) {
                throw new RuntimeException("Header gagal ditulis ke file: {$outputPath}");
            }

            foreach ($filteredRows as $row) {
                if (fputcsv($output, $row, ',', '"', '\\') === false) {
                    throw new RuntimeException("Data hotspot gagal ditulis ke file: {$outputPath}");
                }
            }
        } finally {
            fclose($output);
        }

        $this->info(count($filteredRows).' hotspot Palembang berhasil disimpan ke '.$outputPath);

        if ($invalidRows > 0) {
            $this->warn("{$invalidRows} baris dilewati karena koordinat tidak valid.");
        }

        return Command::SUCCESS;
    }
}
