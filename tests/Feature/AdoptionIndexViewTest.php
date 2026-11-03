<?php

namespace Tests\Feature;

use App\Models\Adoption;
use App\Models\Cat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdoptionIndexViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_adoptions_index(): void
    {
        $response = $this->get('/adoptions');
        $response->assertRedirect('/login');
    }

    public function test_adopter_sees_adoption_index_with_dusk_contracts(): void
    {
        $adopter = User::factory()->create([
            'role' => User::ADOPTER,
            'name' => 'Rina Nose',
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

        $adoption = Adoption::create([
            'user_id' => $adopter->id,
            'cat_id' => $cat->id,
            'address' => 'Kos Sukabirus No. 10',
            'housing_type' => 'Kos Ramah Hewan',
            'experience' => 'Pemula',
            'indoor' => true,
            'cost_commitment' => true,
            'status' => Adoption::PENDING,
        ]);

        $response = $this->actingAs($adopter)->get('/adoptions');

        $response->assertStatus(200);
        $response->assertSee('Pengajuan Adopsi Saya');
        $response->assertSee('Dashboard Adopter');
        $response->assertSee('Mochi');
        $response->assertSee('Kos Sukabirus No. 10');
        $response->assertSee('aria-label="Aksi pengajuan"', false);
        $response->assertSee('aksi-menu', false);
        $response->assertSee('Edit Pengajuan');
        $response->assertSee('aria-label="Konfirmasi adopsi"', false);
        $response->assertSee('id="modal-confirm"', false);
        $response->assertSee('Ya, Saya Siap');
        $response->assertSee('user-icon-btn', false);
    }

    public function test_staff_sees_all_adoptions_with_adopter_details(): void
    {
        $staff = User::factory()->create([
            'role' => User::STAFF,
            'name' => 'Pak Doni Shelter',
        ]);

        $adopter = User::factory()->create([
            'role' => User::ADOPTER,
            'name' => 'Mahasiswa Peduli',
            'email' => 'mhs@kampus.id',
        ]);

        $cat = Cat::create([
            'name' => 'Ciko',
            'found_at' => 'Fakultas Ilmu Komputer',
            'breed' => 'Anggora',
            'temper' => 'Manja',
            'age' => 7,
            'vaccinated' => true,
        ]);

        Adoption::create([
            'user_id' => $adopter->id,
            'cat_id' => $cat->id,
            'address' => 'Asrama Mahasiswa Blok A',
            'housing_type' => 'Kos Ramah Hewan',
            'experience' => 'Pernah Pelihara',
            'indoor' => true,
            'cost_commitment' => true,
            'status' => Adoption::PENDING,
        ]);

        $response = $this->actingAs($staff)->get('/adoptions');

        $response->assertStatus(200);
        $response->assertSee('Pengajuan Adopsi Masuk');
        $response->assertSee('Panel Staff Shelter');
        $response->assertSee('Ciko');
        $response->assertSee('Mahasiswa Peduli');
        $response->assertSee('mhs@kampus.id');
        $response->assertSee('user-icon-btn', false);
    }
}
