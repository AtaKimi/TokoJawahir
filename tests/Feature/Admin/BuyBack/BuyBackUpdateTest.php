<?php

namespace Tests\Feature\Admin\BuyBack;

use App\Enum\BuyBackStatus;
use App\Enum\TransactionStatus;
use App\Models\BuyBack;
use App\Models\BuyBackDetail;
use App\Models\Jewellery;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BuyBackUpdateTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $seed = true;

    protected $seeder = TestSeeder::class;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_updates_status_to_failed_when_status_is_failed()
    {
        $user = User::factory()->create(['is_admin' => true]);

        $user1 = User::factory()->create();
        $buyBack = BuyBack::factory()->create(['user_id' => $user1->id, 'status' => BuyBackStatus::PENDING]);

        $response = $this->actingAs($user)->put(route('admin.buyback.confirmation', [$user1, $buyBack]), ['status' => 'failed']);

        $buyBack->refresh();
        $this->assertEquals(BuyBackStatus::FAILED->value, $buyBack->status);
        $response->assertRedirect(route('admin.buyback.index'));
    }

    public function test_updates_status_to_success_and_updates_details_when_status_is_success()
    {
        $user = User::factory()->create(['is_admin' => true]);

        $jewelleryWithQuantityLeft = Jewellery::factory()->create(['quantity' => 10]);
        $jewelleryWithoutQuantityLeft = Jewellery::factory()->create(['quantity' => 0]);

        $user1 = User::factory()->create();
        $buyBack = BuyBack::factory()->create(['user_id' => $user1->id, 'status' => BuyBackStatus::PENDING]);
        $transaction = Transaction::factory()->create(['user_id' => $user1->id, 'status' => TransactionStatus::SUCCESS]);
        $transactionDetail1 = TransactionDetail::factory()->create(['transaction_id' => $transaction->id, 'jewellery_id' => $jewelleryWithQuantityLeft->id, 'quantity' => 5, 'quantity_sold' => 0, 'total' => 10000]);
        $transactionDetail2 = TransactionDetail::factory()->create(['transaction_id' => $transaction->id, 'jewellery_id' => $jewelleryWithoutQuantityLeft->id, 'quantity' => 3, 'quantity_sold' => 1, 'total' => 5000]);

        $buyBackDetail1 = BuyBackDetail::factory()->create([
            'buy_back_id' => $buyBack->id,
            'transaction_detail_id' => $transactionDetail1->id,
            'quantity' => 3, // Quantity less than quantity_left
            'total' => 6000, // Example total
            'total_sold' => 5000, // Example total_sold
        ]);
        $buyBackDetail2 = BuyBackDetail::factory()->create([
            'buy_back_id' => $buyBack->id,
            'transaction_detail_id' => $transactionDetail2->id,
            'quantity' => 3, // Quantity greater than quantity_left
            'total' => 7500, // Example total
            'total_sold' => 6000, // Example total_sold
        ]);

        $response = $this->actingAs($user)->put(route('admin.buyback.confirmation', [$user1, $buyBack]), ['status' => 'success']);

        $buyBack->refresh();
        $transactionDetail1->refresh();
        $transactionDetail2->refresh();

        $this->assertEquals(BuyBackStatus::SUCCESS->value, $buyBack->status);
        $this->assertEquals($buyBackDetail1->total, $buyBack->total); // Only buyBackDetail1 should remain
        $this->assertEquals($buyBackDetail1->total_sold, $buyBack->total_sold); // Only buyBackDetail1 should remain

        $this->assertDatabaseMissing('buy_back_details', ['id' => $buyBackDetail2->id]);
        $this->assertDatabaseHas('buy_back_details', ['id' => $buyBackDetail1->id]);

        $this->assertEquals(5 - 3, $transactionDetail1->quantity_left); // quantity_left reduced by buyback quantity
        $this->assertEquals(2, $transactionDetail2->quantity_left); // quantity_left remains unchanged as buyback detail was deleted

        $response->assertRedirect(route('admin.buyback.index'));
    }

    public function test_confirmation_requires_status_field()
    {
        $user = User::factory()->create(['is_admin' => true]);

        $user1 = User::factory()->create();
        $buyBack = BuyBack::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user)->put(route('admin.buyback.confirmation', [$user1, $buyBack]), []);

        $response->assertSessionHasErrors('status');
    }

    public function test_confirmation_requires_valid_status_value()
    {
        $user = User::factory()->create(['is_admin' => true]);

        $user1 = User::factory()->create();
        $buyBack = BuyBack::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user)->put(route('admin.buyback.confirmation', [$user1, $buyBack]), ['status' => 'invalid_status']);

        $response->assertSessionHasErrors('status');
    }
}
