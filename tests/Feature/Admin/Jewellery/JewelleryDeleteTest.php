<?php

namespace Tests\Feature\Admin\Jewellery;

use App\Models\Jewellery;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JewelleryDeleteTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    protected $seeder = TestSeeder::class;

    protected Media $media;

    protected function tearDown(): void
    {
        if (isset($this->media)) {
            $this->media->delete();
        }
        parent::tearDown();
    }

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_destroy_jewellery_success()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $jewellery = Jewellery::factory()->create();

        // Declare the input into variable $input (not applicable for destroy)

        // Response
        $response = $this->actingAs($user)->delete(route('admin.jewellery.destroy', $jewellery));

        // Response assert
        $response->assertRedirect(route('admin.jewellery.index'));
        $this->assertDatabaseMissing('jewelleries', ['id' => $jewellery->id]);
    }

    public function test_destroy_jewellery_not_found()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $jewelleryId = 999; // Assuming this ID doesn't exist

        // Declare the input into variable $input (not applicable for destroy)

        // Response
        $response = $this->actingAs($user)->delete(route('admin.jewellery.destroy', $jewelleryId));

        // Response assert
        $response->assertStatus(404); // or assertNotFound(), depending on your exception handling.
    }

    public function test_destroy_jewellery_unauthorized()
    {
        $user = User::factory()->create();
        $jewellery = Jewellery::factory()->create();

        // Declare the input into variable $input (not applicable for destroy)

        // Response
        $response = $this->actingAs($user)->delete(route('admin.jewellery.destroy', $jewellery));

        // Response assert
        $response->assertStatus(403); // or assertForbidden(), depending on your authorization setup.
    }
}
