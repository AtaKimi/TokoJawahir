<?php

namespace Tests\Feature\Guest\Jewellery;

use App\Models\Jewellery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JewelleryReadTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_can_be_displayed(): void
    {
        Jewellery::factory()->create(['quantity' => 5]);
        Jewellery::factory()->create(['quantity' => 0]);

        $response = $this->get('/jewellery');
        $response->assertStatus(200);
        $response->assertViewIs('guest.jewellery.index');
        $response->assertViewHas('jewelleries');

        $jewelleries = $response->original->getData()['jewelleries'];
        $this->assertCount(1, $jewelleries);
        $this->assertTrue($jewelleries->first()->quantity > 0);
    }

    public function test_index_page_filters_by_name(): void
    {
        Jewellery::factory()->create(['name' => 'Gold Ring', 'quantity' => 10]);
        Jewellery::factory()->create(['name' => 'Silver Necklace', 'quantity' => 5]);
        Jewellery::factory()->create(['name' => 'Diamond Ring', 'quantity' => 2]);
        Jewellery::factory()->create(['name' => 'Old Brooch', 'quantity' => 0]);

        $response = $this->get('/jewellery?search=Ring');

        $response->assertStatus(200);
        $response->assertViewIs('guest.jewellery.index');
        $response->assertViewHas('jewelleries');

        $jewelleries = $response->original->getData()['jewelleries'];

        $this->assertCount(2, $jewelleries);
        $this->assertEquals('Gold Ring', $jewelleries[0]->name);
        $this->assertEquals('Diamond Ring', $jewelleries[1]->name);
    }

    public function test_index_page_handles_non_matching_filter(): void
    {
        // Create some items
        Jewellery::factory()->create(['name' => 'Gold Ring', 'quantity' => 10]);
        Jewellery::factory()->create(['name' => 'Silver Necklace', 'quantity' => 5]);

        $response = $this->get('/jewellery?search=NonExistentItem');

        $response->assertStatus(200);
        $response->assertViewIs('guest.jewellery.index');
        $response->assertViewHas('jewelleries');

        $jewelleries = $response->original->getData()['jewelleries'];
        $this->assertCount(0, $jewelleries);
    }

    public function test_show_page_can_be_displayed_for_existing_jewellery(): void
    {
        $jewellery = Jewellery::factory()->create(['quantity' => 1]);

        $response = $this->get('/jewellery/'.$jewellery->id);

        $response->assertStatus(200);
        $response->assertViewIs('guest.jewellery.show');
        $response->assertViewHas('jewellery', function ($viewJewellery) use ($jewellery) {
            return $viewJewellery->id === $jewellery->id;
        });

        $response->assertSeeText($jewellery->name);
    }

    public function test_show_page_returns_404_for_non_existent_jewellery(): void
    {
        $response = $this->get('/jewellery/9999');
        $response->assertStatus(404);
    }
}
