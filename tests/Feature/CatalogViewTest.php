<?php

namespace Tests\Feature;

use App\Models\Cat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_sees_catalog_editorial_and_dusk_contracts(): void
    {
        $staff = User::factory()->create([
            'role' => User::STAFF,
        ]);

        $cat = Cat::create([
            'name' => 'Belang',
            'found_at' => 'Parkiran Gedung C',
            'breed' => 'Kampung',
            'temper' => 'Mager',
            'age' => 12,
            'vaccinated' => false,
        ]);

        $response = $this->actingAs($staff)->get('/cats');

        $response->assertStatus(200);
        $response->assertSee('Katalog Kucing Adopsi');
        $response->assertSee('user-icon-btn', false);
        $response->assertSee('Tambah Kucing');
        $response->assertSee('Belang');
        $response->assertSee('Detail');
        $response->assertSee('Edit');
        $response->assertSee('aksi-menu', false);
        $response->assertSee('aria-label="Aksi kucing"', false);
        $response->assertSee('aria-label="Hapus kucing"', false);
        $response->assertSee('data-confirm="Hapus Belang dari katalog?"', false);
    }

    public function test_adopter_sees_catalog_with_ajukan_adopsi_link(): void
    {
        $adopter = User::factory()->create([
            'role' => User::ADOPTER,
        ]);

        $cat = Cat::create([
            'name' => 'Mochi',
            'found_at' => 'Selasar Lab PPL',
            'breed' => 'Anggora',
            'temper' => 'Manja',
            'age' => 6,
            'vaccinated' => true,
        ]);

        $response = $this->actingAs($adopter)->get('/cats');

        $response->assertStatus(200);
        $response->assertSee('Katalog Kucing Adopsi');
        $response->assertSee('Ajukan Adopsi');
        $response->assertSee('Detail');
        $response->assertSee('Mochi');
    }
}

