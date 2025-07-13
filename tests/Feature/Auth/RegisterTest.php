<?php

namespace Tests\Feature\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use PasswordValidationRules, RefreshDatabase;

    public function test_new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '1234567890',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('guest.index')); // or where your dashboard is located.
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'phone' => '1234567890',
        ]);
    }

    public function test_registration_requires_name()
    {
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '1234567890',
        ]);

        $response->assertSessionHasErrors('name');
    }
}
