<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders_with_slice_style_and_dusk_contracts(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login ke akun');
        $response->assertSee('EISD Meowdopt');
        $response->assertSee('Inisiatif Kampus');
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('id="btn-login"', false);
        $response->assertSee('Register');
        $response->assertSee('Setiap kucing');
    }

    public function test_login_failure_displays_dusk_error_message(): void
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'wrong@email.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');

        $followUp = $this->get('/login');
        $followUp->assertSee('Email atau password salah.');
    }

    public function test_successful_login_redirects_to_cats_catalog(): void
    {
        $user = User::factory()->create([
            'email' => 'staff@meowdopt.test',
            'password' => bcrypt('password'),
            'role' => User::STAFF,
        ]);

        $response = $this->post('/login', [
            'email' => 'staff@meowdopt.test',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('cats.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_logout_redirects_to_login_with_dusk_status(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status', 'Logout berhasil.');

        $followUp = $this->get('/login');
        $followUp->assertSee('Logout berhasil.');
    }
}
