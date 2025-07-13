<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginAdminTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    protected $seeder = TestSeeder::class;

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password', // Assuming default password from factory
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard')); // Or your intended redirect
    }
}
