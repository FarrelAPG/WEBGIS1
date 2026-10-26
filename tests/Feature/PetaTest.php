<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class PetaTest extends TestCase
{
    use RefreshDatabase;

    public function test_peta_page_opens_on_jangkauan_tab(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);

        $this->actingAs($damkar)->get(route('damkar.peta'))
            ->assertOk()
            ->assertSee('Peta Area Jangkauan Pos Pemadam')
            ->assertSee('Sumber Air')
            ->assertSee('Peta Rawan Kebakaran');
    }

    public function test_peta_subpages_are_accessible(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);

        $this->actingAs($damkar)->get(route('damkar.peta.sumber-air'))
            ->assertOk()
            ->assertSee('Sumber Air')
            ->assertSee('Waterpark Fantasy Island')
            ->assertSee('Data simulasi');

        $this->actingAs($damkar)->get(route('damkar.peta.rawan-bencana'))
            ->assertOk()
            ->assertSee('Peta Daerah Rawan Kebakaran');
    }

    public function test_rawan_bencana_page_shows_hotspots_inside_palembang_bounds(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);
        $this->travelTo('2026-10-25 12:00:00');

        $response = $this->actingAs($damkar)->get(route('damkar.peta.rawan-bencana'))
            ->assertOk()
            ->assertViewHas('selectedMonth', '2026-10')
            ->assertViewHas('totalHotspot', 39)
            ->assertViewHas('monthOptions', fn ($months): bool => $months->keys()->all() === [
                '2026-07',
                '2026-08',
                '2026-09',
                '2026-10',
            ])
            ->assertViewHas('hotspots', fn ($hotspots): bool => $hotspots->count() === 39
                && $hotspots->every(fn (array $hotspot): bool => $hotspot['lat'] >= -3.10
                    && $hotspot['lat'] <= -2.85
                    && $hotspot['lng'] >= 104.60
                    && $hotspot['lng'] <= 104.90
                    && str_starts_with($hotspot['tanggal'], '2026-10')))
            ->assertViewHas('zonaRawan', fn ($zones): bool => $zones->sum('jumlah') === 39
                && $zones->every(fn (array $zone): bool => $zone['tinggi']));

        $response->assertSee('ALL_HOTSPOTS.forEach')
            ->assertSee('L.circleMarker')
            ->assertSee('Agustus 2026')
            ->assertSee('value="2026-10" selected', false)
            ->assertDontSee('Semua Bulan');
    }

    public function test_selecting_a_month_filters_map_points_and_zone_summary(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);

        $response = $this->actingAs($damkar)->get(route('damkar.peta.rawan-bencana', [
            'month' => '2026-08',
        ]))
            ->assertOk()
            ->assertViewHas('selectedMonth', '2026-08')
            ->assertViewHas('totalHotspot', 58)
            ->assertViewHas('hotspots', fn ($hotspots): bool => $hotspots->count() === 58
                && $hotspots->every(
                    fn (array $hotspot): bool => str_starts_with($hotspot['tanggal'], '2026-08'),
                ))
            ->assertViewHas('zonaRawan', fn ($zones): bool => $zones->sum('jumlah') === 58
                && $zones->every(fn (array $zone): bool => $zone['tinggi']));

        $response->assertSee('value="2026-08" selected', false);
    }

    public function test_month_filter_rejects_months_not_present_in_the_dataset(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);

        $this->actingAs($damkar)
            ->get(route('damkar.peta.rawan-bencana', ['month' => '2026-05']))
            ->assertSessionHasErrors('month');
    }

    public function test_rawan_bencana_page_includes_hotspot_details_for_map_popups(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);

        $this->actingAs($damkar)->get(route('damkar.peta.rawan-bencana', [
            'month' => '2026-07',
        ]))
            ->assertOk()
            ->assertSee('2026-07-29')
            ->assertSee('06:22 UTC')
            ->assertSee('SNPP')
            ->assertSee('confidence')
            ->assertSee('Nominal (n)')
            ->assertSee('-3.08348');
    }

    public function test_hotspot_import_includes_coordinate_boundaries_and_excludes_outside_points(): void
    {
        $sourcePath = tempnam(sys_get_temp_dir(), 'palembang-hotspots-source-');
        $outputPath = tempnam(sys_get_temp_dir(), 'palembang-hotspots-output-');

        if ($sourcePath === false || $outputPath === false) {
            if (is_string($sourcePath)) {
                unlink($sourcePath);
            }

            if (is_string($outputPath)) {
                unlink($outputPath);
            }

            $this->fail('Temporary CSV files could not be created.');
        }

        try {
            file_put_contents($sourcePath, implode("\n", [
                'latitude,longitude,acq_date,acq_time,satellite,confidence,frp',
                '-3.10,104.60,2026-01-01,0000,VIIRS,80,1',
                '-3.10,104.90,2026-01-01,0000,VIIRS,80,1',
                '-2.85,104.60,2026-01-01,0000,VIIRS,80,1',
                '-2.85,104.90,2026-01-01,0000,VIIRS,80,1',
                '-3.1001,104.75,2026-01-01,0000,VIIRS,80,1',
                '-3.00,104.5999,2026-01-01,0000,VIIRS,80,1',
                '-2.80,104.70,2026-01-01,0000,VIIRS,80,1',
                '',
            ]));

            $exitCode = Artisan::call('hotspots:filter-palembang', [
                'source' => $sourcePath,
                '--output' => $outputPath,
            ]);

            $this->assertSame(0, $exitCode);
            $filteredRows = array_slice(array_map(
                static fn (string $line): array => str_getcsv($line),
                file($outputPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES),
            ), 1);
            $this->assertCount(4, $filteredRows);
            $this->assertSame(
                ['-3.10', '-3.10', '-2.85', '-2.85'],
                array_column($filteredRows, 0),
            );
            $this->assertSame(
                ['104.60', '104.90', '104.60', '104.90'],
                array_column($filteredRows, 1),
            );
        } finally {
            unlink($sourcePath);
            unlink($outputPath);
        }
    }
}
