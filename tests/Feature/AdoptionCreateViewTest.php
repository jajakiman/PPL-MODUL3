<?php

namespace Tests\Feature;

use App\Models\Adoption;
use App\Models\Cat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdoptionCreateViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_adoption_create(): void
    {
        $cat = Cat::create([
            'name' => 'Mochi',
            'found_at' => 'Parkiran Gedung C',
            'breed' => 'Anggora',
            'temper' => 'Manja',
            'age' => 6,
            'vaccinated' => true,
        ]);

        $response = $this->get('/adoptions/create?cat='.$cat->id);
        $response->assertRedirect('/login');
    }

    public function test_adopter_sees_adoption_create_page_with_photo_and_dusk_contracts(): void
    {
        $adopter = User::factory()->create([
            'role' => User::ADOPTER,
            'name' => 'Budi Santoso',
        ]);

        $cat = Cat::create([
            'name' => 'Mochi',
            'found_at' => 'Parkiran Gedung C',
            'breed' => 'Anggora',
            'temper' => 'Manja',
            'age' => 6,
            'vaccinated' => true,
            'image' => 'images/Kimi.jpg',
        ]);

        $response = $this->actingAs($adopter)->get('/adoptions/create?cat='.$cat->id);

        $response->assertStatus(200);
        $response->assertSee('Ajukan Adopsi Mochi');
        $response->assertSee('Kembali ke profil Mochi');
        $response->assertSee('images/Kimi.jpg');
        $response->assertSee('name="address"', false);
        $response->assertSee('name="housing_type"', false);
        $response->assertSee('name="experience"', false);
        $response->assertSee('name="indoor"', false);
        $response->assertSee('name="cost_commitment"', false);
        $response->assertSee('Kirim Pengajuan');
        $response->assertSee('user-icon-btn', false);
    }

    public function test_adopter_sees_adoption_edit_page_with_photo_and_dusk_contracts(): void
    {
        $adopter = User::factory()->create([
            'role' => User::ADOPTER,
            'name' => 'Siti Nurhaliza',
        ]);

        $cat = Cat::create([
            'name' => 'Kimi',
            'found_at' => 'Taman Asrama Kampus',
            'breed' => 'Persia',
            'temper' => 'Mager',
            'age' => 10,
            'vaccinated' => true,
            'image' => 'images/Kimi.jpg',
        ]);

        $adoption = Adoption::create([
            'user_id' => $adopter->id,
            'cat_id' => $cat->id,
            'address' => 'Jl. Telekomunikasi No. 1',
            'housing_type' => 'Rumah Sendiri',
            'experience' => 'Pernah Pelihara',
            'indoor' => true,
            'cost_commitment' => true,
            'status' => Adoption::PENDING,
        ]);

        $response = $this->actingAs($adopter)->get(route('adoptions.edit', $adoption));

        $response->assertStatus(200);
        $response->assertSee('Edit Pengajuan Kimi');
        $response->assertSee('Kembali ke pengajuan saya');
        $response->assertSee('images/Kimi.jpg');
        $response->assertSee('value="PUT"', false);
        $response->assertSee('Jl. Telekomunikasi No. 1');
        $response->assertSee('Perbarui Pengajuan');
        $response->assertSee('user-icon-btn', false);
    }
}
