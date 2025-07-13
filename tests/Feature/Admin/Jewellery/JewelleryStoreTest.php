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

class JewelleryStoreTest extends TestCase
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

    public function test_store_jewellery_success()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $file = UploadedFile::fake()->image('test.jpg');

        // Declare the input into variable $input
        $input = [
            'name' => 'Test Jewellery',
            'description' => 'Test Description',
            'price' => 100,
            'quantity' => 10,
            'image' => $file,
        ];

        // Response
        $response = $this->actingAs($user)->post(route('admin.jewellery.store'), $input);

        // Response assert
        $response->assertRedirect(route('admin.jewellery.index'));
        $this->assertDatabaseHas('jewelleries', [
            'name' => 'Test Jewellery',
            'description' => 'Test Description',
            'price' => 100,
            'quantity' => 10,
        ]);

        $jewellery = Jewellery::where('name', 'Test Jewellery')->first();

        $this->media = $jewellery->getFirstMedia('image');

        $this->assertEquals(1, $jewellery->getMedia('image')->count());
        $this->assertTrue($this->media->file_name == 'test.jpg');
    }

    public function test_store_jewellery_validation_name_required()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $file = UploadedFile::fake()->image('test.jpg');

        // Declare the input into variable $input
        $input = [
            'description' => 'Test Description',
            'price' => 100,
            'quantity' => 10,
            'image' => $file,
        ];

        // Response
        $response = $this->actingAs($user)->post(route('admin.jewellery.store'), $input);

        // Response assert
        $response->assertSessionHasErrors('name');
    }

    public function test_store_jewellery_validation_name_string()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $file = UploadedFile::fake()->image('test.jpg');

        // Declare the input into variable $input
        $input = [
            'name' => 123,
            'description' => 'Test Description',
            'price' => 100,
            'quantity' => 10,
            'image' => $file,
        ];

        // Response
        $response = $this->actingAs($user)->post(route('admin.jewellery.store'), $input);

        // Response assert
        $response->assertSessionHasErrors('name');
    }

    public function test_store_jewellery_validation_name_max()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $file = UploadedFile::fake()->image('test.jpg');

        // Declare the input into variable $input
        $input = [
            'name' => str_repeat('a', 256),
            'description' => 'Test Description',
            'price' => 100,
            'quantity' => 10,
            'image' => $file,
        ];

        // Response
        $response = $this->actingAs($user)->post(route('admin.jewellery.store'), $input);

        // Response assert
        $response->assertSessionHasErrors('name');
    }

    public function test_store_jewellery_validation_description_required()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $file = UploadedFile::fake()->image('test.jpg');

        // Declare the input into variable $input
        $input = [
            'name' => 'Test Name',
            'price' => 100,
            'quantity' => 10,
            'image' => $file,
        ];

        // Response
        $response = $this->actingAs($user)->post(route('admin.jewellery.store'), $input);

        // Response assert
        $response->assertSessionHasErrors('description');
    }

    public function test_store_jewellery_validation_description_string()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $file = UploadedFile::fake()->image('test.jpg');

        // Declare the input into variable $input
        $input = [
            'name' => 'Test Name',
            'description' => 123,
            'price' => 100,
            'quantity' => 10,
            'image' => $file,
        ];

        // Response
        $response = $this->actingAs($user)->post(route('admin.jewellery.store'), $input);

        // Response assert
        $response->assertSessionHasErrors('description');
    }

    public function test_store_jewellery_validation_price_required()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Declaration of variable that gonna be used
        $file = UploadedFile::fake()->image('test.jpg');

        // Declare the input into variable $input
        $input = [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'quantity' => 10,
            'image' => $file,
        ];

        // Response
        $response = $this->actingAs($user)->post(route('admin.jewellery.store'), $input);

        // Response assert
        $response->assertSessionHasErrors('price');
    }
}
