<?php

namespace Tests\Feature\Admin\Transaction;

use App\Models\Jewellery;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TransactionReadTest extends TestCase
{
    use RefreshDatabase; // Reset the database for each test
    use WithFaker; // Use Faker for generating fake data

    protected $seed = true;

    protected $seeder = TestSeeder::class;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_index_returns_correct_view_with_transactions()
    {
        // Create some users and transactions
        $user = User::factory()->create(['is_admin' => true]);

        $user1 = User::factory()->create(['name' => 'John Doe']);
        $user2 = User::factory()->create(['name' => 'Jane Smith']);
        Transaction::factory()->count(5)->create(['user_id' => $user1->id]);
        Transaction::factory()->count(3)->create(['user_id' => $user2->id]);

        // Access the index route
        $response = $this->actingAs($user)->get(route('admin.transaction.index'));

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the correct view is rendered
        $response->assertViewIs('admin.transaction.index');

        // Assert that transactions are passed to the view
        $response->assertViewHas('transactions');
    }

    /**
     * Test the index method with search query (view).
     */
    public function test_index_filters_transactions_by_user_name_search()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Create users and transactions
        $user1 = User::factory()->create(['name' => 'Alice Wonderland']);
        $user2 = User::factory()->create(['name' => 'Bob The Builder']);
        $transaction1 = Transaction::factory()->create(['user_id' => $user1->id]);
        $transaction2 = Transaction::factory()->create(['user_id' => $user2->id]);
        $transaction3 = Transaction::factory()->create(['user_id' => $user1->id]);

        // Access the index route with a search query
        $response = $this->actingAs($user)->get(route('admin.transaction.index', ['search' => 'Alice']));

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the correct view is rendered
        $response->assertViewIs('admin.transaction.index');

        // Assert that only transactions related to 'Alice' are in the view data
        $response->assertViewHas('transactions', function ($transactions) use ($transaction1, $transaction3, $transaction2) {
            return $transactions->contains($transaction1)
                && $transactions->contains($transaction3)
                && ! $transactions->contains($transaction2);
        });
    }

    /**
     * Test the users method (view).
     */
    public function test_users_returns_correct_view_with_users()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Create some users and transactions
        User::factory()->count(10)->create();

        // Access the users route
        $response = $this->actingAs($user)->get(route('admin.transaction.users'));

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the correct view is rendered
        $response->assertViewIs('admin.transaction.users');

        // Assert that users are passed to the view
        $response->assertViewHas('users');
    }

    /**
     * Test the users method with search query (view).
     */
    public function test_users_filters_users_by_name_search()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Create users
        $user1 = User::factory()->create(['name' => 'Charlie Chaplin']);
        $user2 = User::factory()->create(['name' => 'David Bowie']);
        $user3 = User::factory()->create(['name' => 'Charlie Brown']);

        // Access the users route with a search query
        $response = $this->actingAs($user)->get(route('admin.transaction.users', ['search' => 'Charlie']));

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the correct view is rendered
        $response->assertViewIs('admin.transaction.users');

        // Assert that only users with 'Charlie' in their name are in the view data
        $response->assertViewHas('users', function ($users) use ($user1, $user3, $user2) {
            return $users->contains($user1)
                && $users->contains($user3)
                && ! $users->contains($user2);
        });
    }

    /**
     * Test the create method (view).
     */
    public function test_create_returns_correct_view_with_user()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Create a user
        $user1 = User::factory()->create();

        // Access the create route with the user
        $response = $this->actingAs($user)->get(route('admin.transaction.create', $user1));

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the correct view is rendered
        $response->assertViewIs('admin.transaction.create');

        // Assert that the user is passed to the view
        $response->assertViewHas('user', $user1);
    }

    /**
     * Test the review method (view).
     */
    public function test_review_returns_correct_view_and_updates_transaction_total()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Create a user, transaction, transaction details, and jewellery
        $user1 = User::factory()->create();
        $transaction = Transaction::factory()->create(['user_id' => $user1->id, 'total' => 0]);
        $jewellery1 = Jewellery::factory()->create(['price' => 100, 'quantity' => 5]);
        $jewellery2 = Jewellery::factory()->create(['price' => 50, 'quantity' => 10]);
        TransactionDetail::factory()->create(['transaction_id' => $transaction->id, 'jewellery_id' => $jewellery1->id, 'quantity' => 2, 'total' => 200]);
        TransactionDetail::factory()->create(['transaction_id' => $transaction->id, 'jewellery_id' => $jewellery2->id, 'quantity' => 3, 'total' => 150]);

        // Access the review route with the user and transaction
        $response = $this->actingAs($user)->get(route('admin.transaction.review', [$user1, $transaction]));

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the correct view is rendered
        $response->assertViewIs('admin.transaction.review');

        // Assert that the user and transaction are passed to the view
        $response->assertViewHas('user', $user1);
        $response->assertViewHas('transaction', function ($viewTransaction) use ($transaction) {
            // Reload the transaction from the database to check the updated total
            $transaction->refresh();

            return $viewTransaction->is($transaction) && $viewTransaction->total == 350; // 200 + 150
        });

        // Assert that the transaction total was updated in the database
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'total' => 350,
        ]);
    }
}
