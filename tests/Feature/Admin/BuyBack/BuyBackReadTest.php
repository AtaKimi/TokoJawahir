<?php

namespace Tests\Feature\Admin\BuyBack;

use App\Enum\BuyBackStatus;
use App\Models\BuyBack;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BuyBackReadTest extends TestCase
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

    public function test_displays_latest_buybacks()
    {
        $user = User::factory()->create(['is_admin' => true]);

        $customer = User::factory()->create();

        $oldBuyBack = BuyBack::factory()->create(['created_at' => now()->subDays(5), 'user_id' => $customer->id]);
        $newBuyBack = BuyBack::factory()->create(['created_at' => now(), 'user_id' => $customer->id]);

        $response = $this->actingAs($user)->get(route('admin.buyback.index'));

        $response->assertViewIs('admin.buyback.index');
        $response->assertViewHas('buy_backs');

        $buyBacksInView = $response->original->getData()['buy_backs'];

        $this->assertInstanceOf(LengthAwarePaginator::class, $buyBacksInView);

        $this->assertTrue($buyBacksInView->contains($newBuyBack));
        $this->assertTrue($buyBacksInView->contains($oldBuyBack));
    }

    public function test_displays_users_with_pending_buybacks()
    {
        $user = User::factory()->create(['is_admin' => true]);

        $userWithPending = User::factory()->create();
        $userWithoutPending = User::factory()->create();

        BuyBack::factory()->create(['user_id' => $userWithPending->id, 'status' => BuyBackStatus::PENDING]);
        BuyBack::factory()->create(['user_id' => $userWithPending->id, 'status' => BuyBackStatus::SUCCESS]); // Should not be loaded in the relation
        BuyBack::factory()->create(['user_id' => $userWithoutPending->id, 'status' => BuyBackStatus::SUCCESS]); // Should not be loaded in the relation

        $response = $this->actingAs($user)->get(route('admin.buyback.users'));

        $response->assertViewIs('admin.buyback.users');
        $response->assertViewHas('users');

        $usersInView = $response->original->getData()['users'];

        $this->assertInstanceOf(LengthAwarePaginator::class, $usersInView);

        $this->assertTrue($usersInView->contains($userWithPending));

        $this->assertTrue($usersInView->contains($userWithoutPending));

        $loadedUser = $usersInView->firstWhere('id', $userWithPending->id);
        $this->assertCount(1, $loadedUser->buyBacks);
        $this->assertEquals(BuyBackStatus::PENDING->value, $loadedUser->buyBacks->first()->status);

        $loadedUserWithoutPending = $usersInView->firstWhere('id', $userWithoutPending->id);
        $this->assertCount(0, $loadedUserWithoutPending->buyBacks);
    }

    public function test_filters_by_name_when_query_parameter_is_present()
    {
        $user = User::factory()->create(['is_admin' => true]);

        $user1 = User::factory()->create(['name' => 'Alice']);
        $user2 = User::factory()->create(['name' => 'Bob']);
        $user3 = User::factory()->create(['name' => 'Charlie']);

        $response = $this->actingAs($user)->get(route('admin.buyback.users', ['search' => 'Ali']));

        $response->assertViewIs('admin.buyback.users');
        $response->assertViewHas('users');

        $usersInView = $response->original->getData()['users'];

        $this->assertInstanceOf(LengthAwarePaginator::class, $usersInView);
        $this->assertCount(1, $usersInView); // Only Alice should be present from the ones created in this test
        $this->assertTrue($usersInView->contains($user1));
        $this->assertFalse($usersInView->contains($user2));
        $this->assertFalse($usersInView->contains($user3));
    }

    public function test_displays_create_view_with_user()
    {
        $user = User::factory()->create(['is_admin' => true]);

        $user1 = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.buyback.create', $user1));

        $response->assertViewIs('admin.buyback.create');
        $response->assertViewHas('user', $user1);
    }

    public function test_displays_review_view_with_user_and_buyback()
    {
        $user = User::factory()->create(['is_admin' => true]);

        $user1 = User::factory()->create();
        $buyBack = BuyBack::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user)->get(route('admin.buyback.review', [$user1, $buyBack]));

        $response->assertViewIs('admin.buyback.review');
        $response->assertViewHas('user', $user1);
        $response->assertViewHas('buy_back', $buyBack);
    }
}
