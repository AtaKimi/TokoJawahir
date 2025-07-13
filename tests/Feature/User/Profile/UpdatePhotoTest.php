<?php

namespace Tests\Feature\User\profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdatePhotoTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_photo_profile()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->put(route('user.profile.update-photo'), [
            'image' => $file,
        ]);

        $response->assertRedirect(route('user.profile.index'));

        $user->refresh();

        $this->assertTrue($user->hasMedia('image'));
    }

    public function test_user_can_replace_existing_photo_profile()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $initialFile = UploadedFile::fake()->image('initial.jpg');
        $user->addMedia($initialFile)->toMediaCollection('image');

        $user->refresh();

        $this->assertCount(1, $user->getMedia('image'));
        $this->assertStringContainsString('initial.jpg', $user->getFirstMedia('image')->file_name);

        $newFile = UploadedFile::fake()->image('new_profile.jpg');

        $response = $this->put(route('user.profile.update-photo'), [
            'image' => $newFile,
        ]);

        $user->refresh();

        $this->assertCount(1, $user->getMedia('image'));
        $this->assertStringContainsString('new_profile.jpg', $user->getFirstMedia('image')->file_name);

        $response->assertRedirect(route('user.profile.index'));

        $this->assertCount(1, $user->getMedia('image'));
        $media = $user->getFirstMedia('image');
        Storage::disk('public')->assertExists($media->getPathRelativeToRoot());
        $this->assertStringContainsString('new_profile.jpg', $media->file_name);
    }

    public function test_user_cannot_update_photo_profile_with_invalid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->put(route('user.profile.update-photo'), [
            'image' => 'not-an-image',
        ]);

        $response->assertSessionHasErrors(['image']);
        $this->assertCount(0, $user->getMedia('image'));
    }

    public function test_unauthenticated_user_cannot_update_photo_profile()
    {
        $response = $this->put(route('user.profile.update-photo'), [
            'image' => UploadedFile::fake()->image('profile.jpg'),
        ]);

        $response->assertRedirect('/login');
    }

    public function test_user_cannot_upload_image_over_max_size()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->image('profile.jpg')->size(2049);

        $response = $this->put(route('user.profile.update-photo'), [
            'image' => $file,
        ]);

        $response->assertSessionHasErrors(['image']);

        $user->refresh();

        $this->assertCount(0, $user->getMedia('image'));
    }

    public function test_user_cannot_upload_non_image_file()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('document.pdf', 1024, 'application/pdf');

        $response = $this->put(route('user.profile.update-photo'), [
            'image' => $file,
        ]);

        $response->assertSessionHasErrors(['image']);

        $user->refresh();

        $this->assertCount(0, $user->getMedia('image'));
    }

    public function test_user_can_update_photo_profile_with_valid_image_types()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);

        $validImageTypes = ['jpeg', 'png', 'jpg', 'gif', 'svg'];

        foreach ($validImageTypes as $type) {
            $file = UploadedFile::fake()->image("profile.{$type}");
            $response = $this->put(route('user.profile.update-photo'), [
                'image' => $file,
            ]);
            $response->assertRedirect(route('user.profile.index'));

            $user->refresh();

            $this->assertCount(1, $user->getMedia('image'));
            $user->clearMediaCollection('image'); // Clean up for the next iteration.
        }
    }
}
