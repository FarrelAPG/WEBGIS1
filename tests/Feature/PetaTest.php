<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            ->assertSee('Peta Rawan Bencana');
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

    public function test_rawan_bencana_page_shows_clustered_dataset_and_summary(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);

        $response = $this->actingAs($damkar)->get(route('damkar.peta.rawan-bencana'))
            ->assertOk()
            ->assertViewHas('jumlahZonaKritis', 4)
            ->assertViewHas('jumlahZonaSedang', 2)
            ->assertViewHas('totalHotspot', 22)
            ->assertViewHas('zonaRawan', fn ($zones): bool => $zones->count() === 6);

        $response->assertSee('Sektor 06')
            ->assertSee('FRP 19.0 MW');
    }

    public function test_rawan_bencana_page_includes_hotspot_details_for_map_popups(): void
    {
        $damkar = User::factory()->create(['role' => 'damkar']);

        $this->actingAs($damkar)->get(route('damkar.peta.rawan-bencana'))
            ->assertOk()
            ->assertSee('2026-10-12')
            ->assertSee('01:47 UTC')
            ->assertSee('Terra')
            ->assertSee('confidence')
            ->assertSee('-3.32964');
    }
}
