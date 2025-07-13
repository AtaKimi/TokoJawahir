<?php

namespace Tests\Feature\Admin\Jewellery;

use App\Models\Jewellery;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class JewelleryUpdateTest extends TestCase
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

    public function test_update_jewellery_success_with_new_image()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $jewellery = Jewellery::factory()->create();
        $file = UploadedFile::fake()->image('updated.jpg');

        // Declare the input into variable $input
        $input = [
            'name' => 'Updated Jewellery Name',
            'description' => 'Updated Description',
            'price' => 200,
            'quantity' => 20,
            'image' => $file,
        ];

        // Response
        $response = $this->actingAs($user)->put(route('admin.jewellery.update', $jewellery), $input);

        // Response assert
        $response->assertRedirect(route('admin.jewellery.index'));
        $this->assertDatabaseHas('jewelleries', [
            'id' => $jewellery->id,
            'name' => 'Updated Jewellery Name',
            'description' => 'Updated Description',
            'price' => 200,
            'quantity' => 20,
        ]);

        $this->media = $jewellery->getFirstMedia('image');

        $this->assertEquals(1, $jewellery->getMedia('image')->count());
        $this->assertTrue($this->media->file_name == 'updated.jpg');
    }

    public function test_update_jewellery_success_without_new_image()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $jewellery = Jewellery::factory()->create();

        // Declare the input into variable $input
        $input = [
            'name' => 'Updated Jewellery Name',
            'description' => 'Updated Description',
            'price' => 200,
            'quantity' => 20,
        ];

        // Response
        $response = $this->actingAs($user)->put(route('admin.jewellery.update', $jewellery), $input);

        // Response assert
        $response->assertRedirect(route('admin.jewellery.index'));
        $this->assertDatabaseHas('jewelleries', [
            'id' => $jewellery->id,
            'name' => 'Updated Jewellery Name',
            'description' => 'Updated Description',
            'price' => 200,
            'quantity' => 20,
        ]);
    }

    public function test_update_jewellery_validation_name_required()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $jewellery = Jewellery::factory()->create();

        // Declare the input into variable $input
        $input = [
            'description' => 'Test Description',
            'price' => 100,
            'quantity' => 10,
        ];

        // Response
        $response = $this->actingAs($user)->put(route('admin.jewellery.update', $jewellery), $input);

        // Response assert
        $response->assertSessionHasErrors('name');
    }

    public function test_update_jewellery_validation_name_string()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $jewellery = Jewellery::factory()->create();

        // Declare the input into variable $input
        $input = [
            'name' => 123,
            'description' => 'Test Description',
            'price' => 100,
            'quantity' => 10,
        ];

        // Response
        $response = $this->actingAs($user)->put(route('admin.jewellery.update', $jewellery), $input);

        // Response assert
        $response->assertSessionHasErrors('name');
    }

    public function test_update_jewellery_validation_name_max()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $jewellery = Jewellery::factory()->create();

        // Declare the input into variable $input
        $input = [
            'name' => str_repeat('a', 256),
            'description' => 'Test Description',
            'price' => 100,
            'quantity' => 10,
        ];

        // Response
        $response = $this->actingAs($user)->put(route('admin.jewellery.update', $jewellery), $input);

        // Response assert
        $response->assertSessionHasErrors('name');
    }

    public function test_update_jewellery_validation_description_required()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $jewellery = Jewellery::factory()->create();

        // Declare the input into variable $input
        $input = [
            'name' => 'Test Name',
            'price' => 100,
            'quantity' => 10,
        ];

        // Response
        $response = $this->actingAs($user)->put(route('admin.jewellery.update', $jewellery), $input);

        // Response assert
        $response->assertSessionHasErrors('description');
    }

    public function test_update_jewellery_validation_description_string()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $jewellery = Jewellery::factory()->create();

        // Declare the input into variable $input
        $input = [
            'name' => 'Test Name',
            'description' => 123,
            'price' => 100,
            'quantity' => 10,
        ];

        // Response
        $response = $this->actingAs($user)->put(route('admin.jewellery.update', $jewellery), $input);

        // Response assert
        $response->assertSessionHasErrors('description');
    }

    public function test_update_jewellery_validation_price_required()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $jewellery = Jewellery::factory()->create();

        // Declare the input into variable $input
        $input = [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'quantity' => 10,
        ];

        // Response
        $response = $this->actingAs($user)->put(route('admin.jewellery.update', $jewellery), $input);

        // Response assert
        $response->assertSessionHasErrors('price');
    }
}
