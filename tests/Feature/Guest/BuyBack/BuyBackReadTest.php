<?php

namespace Tests\Feature\Guest\BuyBack;

use App\Enum\BuyBackStatus;
use App\Models\BuyBack;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class BuyBackReadTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_displays_only_successful_buybacks_for_authenticated_user()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $successfulBuyBack1 = BuyBack::factory()->create(['user_id' => $user->id, 'status' => BuyBackStatus::SUCCESS]);
        $successfulBuyBack2 = BuyBack::factory()->create(['user_id' => $user->id, 'status' => BuyBackStatus::SUCCESS]);

        $pendingBuyBack = BuyBack::factory()->create(['user_id' => $user->id, 'status' => BuyBackStatus::PENDING]);
        $failedBuyBack = BuyBack::factory()->create(['user_id' => $user->id, 'status' => BuyBackStatus::FAILED]);

        $otherUserSuccessfulBuyBack = BuyBack::factory()->create(['user_id' => $otherUser->id, 'status' => BuyBackStatus::SUCCESS]);

        $response = $this->actingAs($user)->get(route('user.buyback.index'));

        $response->assertViewIs('user.buyback.index');
        $response->assertViewHas('buy_backs');

        $buyBacksInView = $response->original->getData()['buy_backs'];

        $this->assertInstanceOf(LengthAwarePaginator::class, $buyBacksInView);

        $this->assertTrue($buyBacksInView->contains($successfulBuyBack1));
        $this->assertTrue($buyBacksInView->contains($successfulBuyBack2));

        $this->assertFalse($buyBacksInView->contains($pendingBuyBack));
        $this->assertFalse($buyBacksInView->contains($failedBuyBack));
        $this->assertFalse($buyBacksInView->contains($otherUserSuccessfulBuyBack));

        $this->assertCount(2, $buyBacksInView);
    }

    public function test_view_paginates_results()
    {
        $user = User::factory()->create();
        BuyBack::factory()->count(15)->create(['user_id' => $user->id, 'status' => BuyBackStatus::SUCCESS]);

        $response = $this->actingAs($user)->get(route('user.buyback.index'));

        $response->assertViewHas('buy_backs', function ($buyBacks) {
            return $buyBacks instanceof LengthAwarePaginator && $buyBacks->count() === 10;
        });
    }

    public function test_displays_buyback_if_status_is_success()
    {
        $user = User::factory()->create();
        $buyBack = BuyBack::factory()->create(['user_id' => $user->id, 'status' => BuyBackStatus::SUCCESS]);

        $response = $this->actingAs($user)->get(route('user.buyback.show', $buyBack));

        $response->assertViewIs('user.buyback.show');
        $response->assertViewHas('buy_back', $buyBack);
    }

    public function test_redirects_to_index_if_status_is_not_success()
    {
        $user = User::factory()->create();
        $buyBack = BuyBack::factory()->create(['user_id' => $user->id, 'status' => BuyBackStatus::PENDING]);

        $response = $this->actingAs($user)->get(route('user.buyback.show', $buyBack));

        $response->assertRedirect(route('user.buyback.index'));
    }

    public function test_returns_403_if_buyback_does_not_belong_to_authenticated_user()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $buyBack = BuyBack::factory()->create(['user_id' => $otherUser->id, 'status' => BuyBackStatus::SUCCESS]);

        $this->actingAs($user);

        $response = $this->get(route('user.buyback.show', $buyBack));

        $response->assertStatus(403);
    }
}
