<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected $seeder = TestSeeder::class;

    protected $seed = true;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password', // Assuming default password from factory
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('guest.index')); // Or your intended redirect
    }

    public function test_users_can_not_authenticate_with_invalid_input(): void
    {
        $this->post('/login', [
            'email' => 'notAValidEmail@test.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_login_screen_validation(): void
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_redirect_to_intended_url_after_login(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('guest.index'));
    }
}
