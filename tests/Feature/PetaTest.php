<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ZonaRawan;
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

    public function test_rawan_bencana_page_shows_top_2_ranked_zones(): void
    {
        ZonaRawan::factory()->create([
            'nama' => 'Seberang Ulu I',
            'jumlah_kejadian' => 68,
            'latitude' => -2.9920,
            'longitude' => 104.7575,
        ]);
        ZonaRawan::factory()->create([
            'nama' => 'Ilir Timur II',
            'jumlah_kejadian' => 52,
            'latitude' => -2.9745,
            'longitude' => 104.7815,
        ]);

        $damkar = User::factory()->create(['role' => 'damkar']);

        $this->actingAs($damkar)->get(route('damkar.peta.rawan-bencana'))
            ->assertOk()
            ->assertSeeInOrder(['Seberang Ulu I', 'Ilir Timur II'])
            ->assertSee('Risiko Tinggi');
    }

    public function test_rawan_bencana_page_shows_label_for_low_incidence_zone(): void
    {
        ZonaRawan::factory()->create([
            'nama' => 'Sukarami',
            'jumlah_kejadian' => 31,
        ]);

        $damkar = User::factory()->create(['role' => 'damkar']);

        $this->actingAs($damkar)->get(route('damkar.peta.rawan-bencana'))
            ->assertOk()
            ->assertSee('Sukarami')
            ->assertSee('Risiko Sedang');
    }
}
