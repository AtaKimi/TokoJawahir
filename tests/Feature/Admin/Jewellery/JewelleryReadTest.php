<?php

namespace Tests\Feature\Admin\Jewellery;

use App\Models\Jewellery;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JewelleryReadTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    protected $seeder = TestSeeder::class;

    public function test_user_can_view_jewellery_index()
    {

        $user = User::factory()->create(['is_admin' => true]);

        Jewellery::factory()->count(5)->create();

        $response = $this->actingAs($user)->get(route('admin.jewellery.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.jewellery.index');
        $response->assertViewHas('jewelleries');
    }

    public function test_user_can_view_jewellery_create_form()
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->get(route('admin.jewellery.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.jewellery.create');
    }

    public function test_user_can_view_jewellery_edit_form()
    {
        $user = User::factory()->create(['is_admin' => true]);

        $jewellery = Jewellery::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.jewellery.edit', $jewellery));

        $response->assertStatus(200);
        $response->assertViewIs('admin.jewellery.edit');
        $response->assertViewHas('jewellery', $jewellery);
    }
}
