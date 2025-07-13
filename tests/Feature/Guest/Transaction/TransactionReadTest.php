<?php

namespace Tests\Feature\Guest\Transaction;

use App\Enum\TransactionStatus;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionReadTest extends TestCase
{
    use RefreshDatabase; // Reset the database for each test

    /**
     * Test the index method for an authenticated user.
     */
    public function test_authenticated_user_can_view_their_successful_transactions_index()
    {
        // Create an authenticated user
        $user = User::factory()->create();

        // Create some transactions for the user
        $successfulTransaction1 = Transaction::factory()->create([
            'user_id' => $user->id,
            'status' => TransactionStatus::SUCCESS,
            'created_at' => now()->subDays(2), // Older transaction
        ]);
        $successfulTransaction2 = Transaction::factory()->create([
            'user_id' => $user->id,
            'status' => TransactionStatus::SUCCESS,
            'created_at' => now()->subDay(), // Newer transaction
        ]);
        $pendingTransaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'status' => TransactionStatus::PENDING,
        ]);
        $failedTransaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'status' => TransactionStatus::FAILED,
        ]);

        // Create a transaction for another user
        $anotherUser = User::factory()->create();
        $anotherUserTransaction = Transaction::factory()->create([
            'user_id' => $anotherUser->id,
            'status' => TransactionStatus::SUCCESS,
        ]);

        // Act as the authenticated user and access the index route
        $response = $this->actingAs($user)->get(route('user.transaction.index'));

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the correct view is rendered
        $response->assertViewIs('user.transaction.index');

        // Assert that only the authenticated user's successful transactions are passed to the view
        $response->assertViewHas('transactions', function ($transactions) use ($successfulTransaction1, $successfulTransaction2, $pendingTransaction, $failedTransaction, $anotherUserTransaction) {
            // Check that the successful transactions for the user are present and in latest order
            $containsUserSuccessful = $transactions->contains($successfulTransaction1) && $transactions->contains($successfulTransaction2);
            $isLatestOrder = $transactions->first()->is($successfulTransaction2) && $transactions->last()->is($successfulTransaction1);

            // Check that pending, failed, and other users' transactions are NOT present
            $doesNotContainOthers = ! $transactions->contains($pendingTransaction)
                && ! $transactions->contains($failedTransaction)
                && ! $transactions->contains($anotherUserTransaction);

            return $containsUserSuccessful && $isLatestOrder && $doesNotContainOthers;
        });
    }

    /**
     * Test the index method for a guest user.
     */
    public function test_guest_user_is_redirected_from_index()
    {
        // Access the index route as a guest
        $response = $this->get(route('user.transaction.index'));

        // Assert redirection to the login page (or wherever guests are redirected)
        // This assumes your application's authentication middleware redirects guests.
        $response->assertRedirect('/login'); // Adjust the redirect path if necessary
    }

    /**
     * Test the show method for a successful transaction.
     */
    public function test_authenticated_user_can_view_a_successful_transaction()
    {
        // Create an authenticated user
        $user = User::factory()->create();

        // Create a successful transaction for the user
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'status' => TransactionStatus::SUCCESS,
        ]);

        // Act as the authenticated user and access the show route
        $response = $this->actingAs($user)->get(route('user.transaction.show', $transaction));

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the correct view is rendered
        $response->assertViewIs('user.transaction.show');

        // Assert that the transaction is passed to the view
        $response->assertViewHas('transaction', $transaction);
    }

    /**
     * Test the show method for a pending transaction.
     */
    public function test_authenticated_user_is_redirected_from_pending_transaction_show()
    {
        // Create an authenticated user
        $user = User::factory()->create();

        // Create a pending transaction for the user
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'status' => TransactionStatus::PENDING,
        ]);

        // Act as the authenticated user and access the show route
        $response = $this->actingAs($user)->get(route('user.transaction.show', $transaction));

        // Assert redirection to the index page
        $response->assertRedirect(route('user.transaction.index'));
    }

    /**
     * Test the show method for a failed transaction.
     */
    public function test_authenticated_user_is_redirected_from_failed_transaction_show()
    {
        // Create an authenticated user
        $user = User::factory()->create();

        // Create a failed transaction for the user
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'status' => TransactionStatus::FAILED,
        ]);

        // Act as the authenticated user and access the show route
        $response = $this->actingAs($user)->get(route('user.transaction.show', $transaction));

        // Assert redirection to the index page
        $response->assertRedirect(route('user.transaction.index'));
    }

    /**
     * Test the show method for a transaction belonging to another user.
     * Note: The current controller code doesn't explicitly check ownership,
     * but this test verifies the status check and redirection logic still applies.
     * A more robust test would involve policies or explicit ownership checks.
     */
    public function test_authenticated_user_is_redirected_from_another_users_transaction_show_if_not_successful()
    {
        // Create an authenticated user
        $user = User::factory()->create();

        // Create a pending transaction for another user
        $anotherUser = User::factory()->create();
        $transaction = Transaction::factory()->create([
            'user_id' => $anotherUser->id,
            'status' => TransactionStatus::PENDING,
        ]);

        // Act as the authenticated user and access the show route for the other user's transaction
        $response = $this->actingAs($user)->get(route('user.transaction.show', $transaction));

        // Assert redirection to the index page (due to the status check)
        $response->assertRedirect(route('user.transaction.index'));
    }

    /**
     * Test the show method for a successful transaction belonging to another user.
     * Based on the provided controller code, a user *can* view another user's successful transaction
     * if they know the ID, as there's no ownership check. This test verifies that behavior.
     * In a real application, you would likely add an authorization check (e.g., using policies)
     * to prevent this.
     */
    public function test_authenticated_user_can_view_another_users_successful_transaction()
    {
        // Create an authenticated user
        $user = User::factory()->create();

        // Create a successful transaction for another user
        $anotherUser = User::factory()->create();
        $transaction = Transaction::factory()->create([
            'user_id' => $anotherUser->id,
            'status' => TransactionStatus::SUCCESS,
        ]);

        // Act as the authenticated user and access the show route for the other user's transaction
        $response = $this->actingAs($user)->get(route('user.transaction.show', $transaction));

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the correct view is rendered
        $response->assertViewIs('user.transaction.show');

        // Assert that the transaction is passed to the view
        $response->assertViewHas('transaction', $transaction);
    }

    /**
     * Test the show method for a guest user.
     */
    public function test_guest_user_is_redirected_from_show()
    {
        $user = User::factory()->create();
        // Create a transaction
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
        ]);

        // Access the show route as a guest
        $response = $this->get(route('user.transaction.show', $transaction));

        // Assert redirection to the login page (or wherever guests are redirected)
        $response->assertRedirect('/login'); // Adjust the redirect path if necessary
    }
}
