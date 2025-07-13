<?php

namespace Tests\Feature\Admin\Transaction;

use App\Enum\TransactionStatus;
use App\Models\Jewellery;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TransactionUpdateTest extends TestCase
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

    /**
     * Test the confirmation method with successful validation (status = 'success').
     */
    public function test_confirmation_success_updates_status_total_and_jewellery_quantity()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Create a user, transaction, transaction details, and jewellery
        $user1 = User::factory()->create();
        $transaction = Transaction::factory()->create(['user_id' => $user1->id, 'status' => TransactionStatus::PENDING, 'total' => 0]);
        $jewellery1 = Jewellery::factory()->create(['price' => 100, 'quantity' => 10]);
        $jewellery2 = Jewellery::factory()->create(['price' => 50, 'quantity' => 5]);
        $detail1 = TransactionDetail::factory()->create(['transaction_id' => $transaction->id, 'jewellery_id' => $jewellery1->id, 'quantity' => 2, 'total' => 200]);
        $detail2 = TransactionDetail::factory()->create(['transaction_id' => $transaction->id, 'jewellery_id' => $jewellery2->id, 'quantity' => 3, 'total' => 150]);

        // Send a POST request to the confirmation route with status 'success'
        $response = $this->actingAs($user)->put(route('admin.transaction.confirmation', [$user1, $transaction]), [
            'status' => 'success',
        ]);

        // Assert no validation errors in the session
        $response->assertSessionHasNoErrors();

        // Assert redirection to the index page
        $response->assertRedirect(route('admin.transaction.index'));

        // Assert the transaction status is updated to SUCCESS
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'status' => TransactionStatus::SUCCESS,
        ]);

        // Assert the transaction total is updated
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'total' => 350, // 200 + 150
        ]);

        // Assert the jewellery quantities are decreased
        $this->assertDatabaseHas('jewelleries', [
            'id' => $jewellery1->id,
            'quantity' => 8, // 10 - 2
        ]);
        $this->assertDatabaseHas('jewelleries', [
            'id' => $jewellery2->id,
            'quantity' => 2, // 5 - 3
        ]);

        // Assert transaction details are not deleted if quantity is sufficient
        $this->assertDatabaseHas('transaction_details', ['id' => $detail1->id]);
        $this->assertDatabaseHas('transaction_details', ['id' => $detail2->id]);
    }

    /**
     * Test the confirmation method with successful validation (status = 'success') and insufficient quantity.
     */
    public function test_confirmation_success_deletes_detail_with_insufficient_quantity_and_updates_total()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Create a user, transaction, transaction details, and jewellery
        $user1 = User::factory()->create();
        $transaction = Transaction::factory()->create(['user_id' => $user1->id, 'status' => TransactionStatus::PENDING, 'total' => 0]);
        $jewellery1 = Jewellery::factory()->create(['price' => 100, 'quantity' => 1]); // Insufficient quantity
        $jewellery2 = Jewellery::factory()->create(['price' => 50, 'quantity' => 5]); // Sufficient quantity
        $detail1 = TransactionDetail::factory()->create(['transaction_id' => $transaction->id, 'jewellery_id' => $jewellery1->id, 'quantity' => 2, 'total' => 200]);
        $detail2 = TransactionDetail::factory()->create(['transaction_id' => $transaction->id, 'jewellery_id' => $jewellery2->id, 'quantity' => 3, 'total' => 150]);

        // Send a POST request to the confirmation route with status 'success'
        $response = $this->actingAs($user)->put(route('admin.transaction.confirmation', [$user1, $transaction]), [
            'status' => 'success',
        ]);

        // Assert no validation errors in the session
        $response->assertSessionHasNoErrors();

        // Assert redirection to the index page
        $response->assertRedirect(route('admin.transaction.index'));

        // Assert the transaction status is updated to SUCCESS
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'status' => TransactionStatus::SUCCESS,
        ]);

        // Assert the transaction total is updated based on remaining details
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'total' => 150, // Only detail2 remains
        ]);

        // Assert the jewellery quantity for the remaining detail is decreased
        $this->assertDatabaseHas('jewelleries', [
            'id' => $jewellery2->id,
            'quantity' => 2, // 5 - 3
        ]);

        // Assert the jewellery quantity for the deleted detail is NOT decreased (as the detail was removed first)
        $this->assertDatabaseHas('jewelleries', [
            'id' => $jewellery1->id,
            'quantity' => 1, // Remains 1
        ]);

        // Assert the transaction detail with insufficient quantity is deleted
        $this->assertDatabaseMissing('transaction_details', ['id' => $detail1->id]);

        // Assert the transaction detail with sufficient quantity is NOT deleted
        $this->assertDatabaseHas('transaction_details', ['id' => $detail2->id]);
    }

    /**
     * Test the confirmation method with successful validation (status = 'failed').
     */
    public function test_confirmation_failed_updates_status_and_does_not_update_total_or_jewellery_quantity()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Create a user, transaction, transaction details, and jewellery
        $user1 = User::factory()->create();
        $transaction = Transaction::factory()->create(['user_id' => $user1->id, 'status' => TransactionStatus::PENDING, 'total' => 100]); // Initial total
        $jewellery1 = Jewellery::factory()->create(['price' => 100, 'quantity' => 10]);
        $jewellery2 = Jewellery::factory()->create(['price' => 50, 'quantity' => 5]);
        $detail1 = TransactionDetail::factory()->create(['transaction_id' => $transaction->id, 'jewellery_id' => $jewellery1->id, 'quantity' => 2, 'total' => 200]);
        $detail2 = TransactionDetail::factory()->create(['transaction_id' => $transaction->id, 'jewellery_id' => $jewellery2->id, 'quantity' => 3, 'total' => 150]);

        // Send a POST request to the confirmation route with status 'failed'
        $response = $this->actingAs($user)->put(route('admin.transaction.confirmation', [$user1, $transaction]), [
            'status' => 'failed',
        ]);

        // Assert no validation errors in the session
        $response->assertSessionHasNoErrors();

        // Assert redirection to the index page
        $response->assertRedirect(route('admin.transaction.index'));

        // Assert the transaction status is updated to FAILED
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'status' => TransactionStatus::FAILED,
        ]);

        // Assert the transaction total is NOT updated
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'total' => 100, // Should remain the initial total
        ]);

        // Assert the jewellery quantities are NOT decreased
        $this->assertDatabaseHas('jewelleries', [
            'id' => $jewellery1->id,
            'quantity' => 10, // Should remain 10
        ]);
        $this->assertDatabaseHas('jewelleries', [
            'id' => $jewellery2->id,
            'quantity' => 5, // Should remain 5
        ]);

        // Assert transaction details are not deleted
        $this->assertDatabaseHas('transaction_details', ['id' => $detail1->id]);
        $this->assertDatabaseHas('transaction_details', ['id' => $detail2->id]);
    }

    /**
     * Test the confirmation method with successful validation (status = 'pending').
     */
    public function test_confirmation_pending_updates_status_and_does_not_update_total_or_jewellery_quantity()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Create a user, transaction, transaction details, and jewellery
        $user1 = User::factory()->create();
        $transaction = Transaction::factory()->create(['user_id' => $user1->id, 'status' => TransactionStatus::PENDING, 'total' => 100]); // Initial total
        $jewellery1 = Jewellery::factory()->create(['price' => 100, 'quantity' => 10]);
        $jewellery2 = Jewellery::factory()->create(['price' => 50, 'quantity' => 5]);
        $detail1 = TransactionDetail::factory()->create(['transaction_id' => $transaction->id, 'jewellery_id' => $jewellery1->id, 'quantity' => 2, 'total' => 200]);
        $detail2 = TransactionDetail::factory()->create(['transaction_id' => $transaction->id, 'jewellery_id' => $jewellery2->id, 'quantity' => 3, 'total' => 150]);

        // Send a POST request to the confirmation route with status 'pending'
        $response = $this->actingAs($user)->put(route('admin.transaction.confirmation', [$user1, $transaction]), [
            'status' => 'pending',
        ]);

        // Assert no validation errors in the session
        $response->assertSessionHasNoErrors();

        // Assert redirection to the index page
        $response->assertRedirect(route('admin.transaction.index'));

        // Assert the transaction status is updated to PENDING
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'status' => TransactionStatus::PENDING,
        ]);

        // Assert the transaction total is NOT updated
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'total' => 100, // Should remain the initial total
        ]);

        // Assert the jewellery quantities are NOT decreased
        $this->assertDatabaseHas('jewelleries', [
            'id' => $jewellery1->id,
            'quantity' => 10, // Should remain 10
        ]);
        $this->assertDatabaseHas('jewelleries', [
            'id' => $jewellery2->id,
            'quantity' => 5, // Should remain 5
        ]);

        // Assert transaction details are not deleted
        $this->assertDatabaseHas('transaction_details', ['id' => $detail1->id]);
        $this->assertDatabaseHas('transaction_details', ['id' => $detail2->id]);
    }

    /**
     * Test the confirmation method with failed validation.
     */
    public function test_confirmation_failed_validation_stores_errors_in_session_and_redirects()
    {
        $user = User::factory()->create(['is_admin' => true]);
        // Create a user and transaction
        $user1 = User::factory()->create();
        $transaction = Transaction::factory()->create(['user_id' => $user1->id, 'status' => TransactionStatus::PENDING, 'total' => 100]);

        // Send a POST request to the confirmation route with invalid data
        $response = $this->actingAs($user)->put(
            route('admin.transaction.confirmation', [$user1, $transaction]),
            [
                'status' => 'invalid_status', // Invalid status
            ],
            ['Referer' => route('admin.transaction.review', [$user1, $transaction])]
        );

        // Assert validation errors are present in the session
        $response->assertSessionHasErrors('status');

        // Assert redirection (the controller redirects to index even on validation failure)
        $response->assertRedirect(route('admin.transaction.review', [$user1, $transaction]));

        // Assert the transaction status is NOT updated
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'status' => TransactionStatus::PENDING, // Should remain the initial status
        ]);

        // Assert the transaction total is NOT updated
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'total' => 100, // Should remain the initial total
        ]);
    }
}
