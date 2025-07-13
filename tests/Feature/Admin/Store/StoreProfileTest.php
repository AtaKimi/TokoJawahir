<?php

namespace Tests\Feature\Admin\Store;

use App\Models\BuyBackPercentage;
use App\Models\Store;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreProfileTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $seed = true;

    protected $seeder = TestSeeder::class;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user with admin role
        User::factory()->create([
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);
    }

    public function test_index_displays_correct_data_and_view(): void
    {
        // Arrange: Create a BuyBackPercentage record
        $buyBackPercentage = BuyBackPercentage::get()->first();

        $user = User::where('email', 'admin@example.com')->first();

        // Act: Make a GET request to the index route
        $response = $this->actingAs($user)->get(route('admin.store.index'));

        // Assert:
        // 1. The response status is 200 (OK)
        $response->assertStatus(200);

        // 2. The correct view is returned
        $response->assertViewIs('admin.store.index');

        // 3. The view receives the 'buy_back_percentage' variable
        $response->assertViewHas('buy_back_percentage', function ($percentage) use ($buyBackPercentage) {
            return $percentage->is($buyBackPercentage);
        });

        // 4. The view receives the 'store' variable
        $response->assertViewHas('store', function ($store) {
            return $store->id === 1; // Check if the correct store is passed
        });
    }

    public function test_edit_displays_correct_data_and_view(): void
    {

        $user = User::where('email', 'admin@example.com')->first();
        // Act: Make a GET request to the edit route
        $response = $this->actingAs($user)->get(route('admin.store.edit'));

        // Assert:
        // 1. The response status is 200 (OK)
        $response->assertStatus(200);

        // 2. The correct view is returned
        $response->assertViewIs('admin.store.edit');

        // 3. The view receives the 'store' variable
        $response->assertViewHas('store', function ($store) {
            return $store->id === 1; // Check if the correct store is passed
        });
    }

    public function test_update_can_update_store_with_valid_data(): void
    {
        // Arrange: Prepare new data for the store
        $newData = [
            'name' => 'New Store Name',
            'address' => '456 New St, City',
            'phone' => '0987654321',
            'email' => 'new@example.com',
        ];

        // Act: Make a PUT request to the update route

        $user = User::where('email', 'admin@example.com')->first();

        $this->actingAs($user);
        $response = $this->put(route('admin.store.update'), $newData);

        // Assert:
        // 1. The user is redirected to the index page
        $response->assertRedirect(route('admin.store.index'));

        // 2. The database has been updated with the new data
        $this->assertDatabaseHas('stores', [
            'id' => 1,
            'name' => 'New Store Name',
            'address' => '456 New St, City',
            'phone' => '0987654321',
            'email' => 'new@example.com',
        ]);
    }

    /**
     * Test the update method with invalid data (missing name).
     * Ensures validation errors and no update.
     */
    public function test_update_cannot_update_store_with_invalid_data_missing_name(): void
    {
        // Arrange: Prepare invalid data (missing name)
        $invalidData = [
            'address' => '456 New St, City',
            'phone' => '0987654321',
            'email' => 'new@example.com',
        ];

        $store = Store::find(1);

        $user = User::where('email', 'admin@example.com')->first();

        $this->actingAs($user);

        // Act: Make a PUT request to the update route
        $response = $this->put(route('admin.store.update'), $invalidData);

        // Assert:
        // 1. The response has validation errors for 'name'
        $response->assertSessionHasErrors('name');

        // 2. The database has NOT been updated (still has original data)
        $this->assertDatabaseHas('stores', [
            'id' => $store->id,
            'name' => $store->name, // Original name
            'address' => $store->address, // Original address
            'phone' => $store->phone, // Original phone
            'email' => $store->email, // Original email
        ]);
    }

    /**
     * Test the update method with invalid data (invalid email format).
     * Ensures validation errors and no update.
     */
    public function test_update_cannot_update_store_with_invalid_data_invalid_email(): void
    {
        // Arrange: Prepare invalid data (invalid email)
        $invalidData = [
            'name' => 'New Store Name',
            'address' => '456 New St, City',
            'phone' => '0987654321',
            'email' => 'invalid-email', // Invalid email format
        ];

        $store = Store::find(1);

        $user = User::where('email', 'admin@example.com')->first();

        $this->actingAs($user);

        // Act: Make a PUT request to the update route
        $response = $this->put(route('admin.store.update'), $invalidData);

        // Assert:
        // 1. The response has validation errors for 'email'
        $response->assertSessionHasErrors('email');

        // 2. The database has NOT been updated
        $this->assertDatabaseHas('stores', [
            'id' => $store->id,
            'name' => $store->name,
            'address' => $store->address,
            'phone' => $store->phone,
            'email' => $store->email,
        ]);
    }

    /**
     * Test the updateBuyBackPercentage method with valid data.
     * Ensures a new percentage is created and redirected.
     */
    public function test_update_buy_back_percentage_can_create_new_percentage_with_valid_data(): void
    {
        // Arrange: Prepare new percentage data
        $newPercentage = ['percentage' => 15];

        $user = User::where('email', 'admin@example.com')->first();

        $this->actingAs($user);

        // Act: Make a POST request to the updateBuyBackPercentage route
        $response = $this->put(route('admin.store.update-buyback-percentage'), $newPercentage);

        // Assert:
        // 1. The user is redirected to the index page
        $response->assertRedirect(route('admin.store.index'));

        // 2. A new BuyBackPercentage record is created in the database
        $this->assertDatabaseHas('buy_back_percentages', [
            'percentage' => 15,
        ]);

        // 3. Ensure only one record exists if this is the first one, or check count
        $this->assertCount(2, BuyBackPercentage::all());
    }

    /**
     * Test the updateBuyBackPercentage method with invalid data (percentage out of range).
     * Ensures validation errors and no new record.
     */
    public function test_update_buy_back_percentage_cannot_create_with_invalid_data_out_of_range(): void
    {
        // Arrange: Prepare invalid percentage data (too high)
        $invalidPercentage = ['percentage' => 101];

        $user = User::where('email', 'admin@example.com')->first();

        $this->actingAs($user);

        // Act: Make a POST request to the updateBuyBackPercentage route
        $response = $this->put(route('admin.store.update-buyback-percentage'), $invalidPercentage);

        // Assert:
        // 1. The response has validation errors for 'percentage'
        $response->assertSessionHasErrors('percentage');

        // 2. No new BuyBackPercentage record is created in the database
        $this->assertDatabaseCount('buy_back_percentages', 1);
    }

    /**
     * Test the updateBuyBackPercentage method with invalid data (non-numeric percentage).
     * Ensures validation errors and no new record.
     */
    public function test_update_buy_back_percentage_cannot_create_with_invalid_data_non_numeric(): void
    {
        // Arrange: Prepare invalid percentage data (non-numeric)
        $invalidPercentage = ['percentage' => 'abc'];

        $user = User::where('email', 'admin@example.com')->first();

        $this->actingAs($user);

        // Act: Make a POST request to the updateBuyBackPercentage route
        $response = $this->put(route('admin.store.update-buyback-percentage'), $invalidPercentage);

        // Assert:
        // 1. The response has validation errors for 'percentage'
        $response->assertSessionHasErrors('percentage');

        // 2. No new BuyBackPercentage record is created in the database
        $this->assertDatabaseCount('buy_back_percentages', 1);
    }
}
