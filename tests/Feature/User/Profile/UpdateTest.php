<?php

namespace Tests\Feature\User\profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->put(route('user.profile.update'), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'address' => 'Updated Address',
            'phone' => '1234567890',
        ]);

        $response->assertRedirect(route('user.profile.index'));

        $user->refresh();

        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('updated@example.com', $user->email);
        $this->assertEquals('Updated Address', $user->address);
        $this->assertEquals('1234567890', $user->phone);
    }

    public function test_user_cannot_update_profile_with_invalid_data()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->put(route('user.profile.update'), [
            'name' => '', // Invalid: required
            'email' => 'invalid-email', // Invalid: email format
            'address' => '', // Invalid: required
            'phone' => 'abc', // Invalid: numeric
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'address', 'phone']);

        $user->refresh();

        $this->assertNotEquals('', $user->name); // ensure original data hasnt been changed.
        $this->assertNotEquals('invalid-email', $user->email);
        $this->assertNotEquals('', $user->address);
        $this->assertNotEquals('abc', $user->phone);
    }

    public function test_unauthenticated_user_cannot_update_profile()
    {
        $response = $this->put(route('user.profile.update'), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'address' => 'Updated Address',
            'phone' => '1234567890',
        ]);

        $response->assertRedirect('/login'); // or wherever unauthenticated users are redirected.
    }

    public function test_user_can_update_profile_with_max_length_fields()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $longName = str_repeat('a', 255);
        $longEmail = str_repeat('a', 243).'@example.com'; // 255 total

        $response = $this->put(route('user.profile.update'), [
            'name' => $longName,
            'email' => $longEmail,
            'address' => 'Updated Address',
            'phone' => '1234567890',
        ]);

        $response->assertRedirect(route('user.profile.index'));

        $user->refresh();

        $this->assertEquals($longName, $user->name);
        $this->assertEquals($longEmail, $user->email);
    }

    public function test_user_cannot_update_profile_name_email_over_max_length()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $longName = str_repeat('a', 256);
        $longEmail = str_repeat('a', 244).'@example.com'; // 256 total

        $response = $this->put(route('user.profile.update'), [
            'name' => $longName,
            'email' => $longEmail,
            'address' => 'Updated Address',
            'phone' => '1234567890',
        ]);

        $response->assertSessionHasErrors(['name', 'email']);
    }
}
