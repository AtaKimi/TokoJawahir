<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Database\Seeders\JewellerySeeder;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            User::factory()->create([
                'name' => 'admin' . $i,
                'email' => 'admin' . $i . '@example.com',
            ]);
        }

        $role = Role::create(['name' => 'admin']);
        $users = User::where('email', 'like', 'admin%')->get();

        foreach ($users as $user) {
            $user->assignRole($role);
        }

        for ($i = 0; $i < 10; $i++) {
            User::factory()->create([
                'name' => 'customer' . $i,
                'email' => 'customer' . $i . '@example.com',
            ]);
        }

        $role = Role::create(['name' => 'customer']);
        $users = User::where('email', 'like', 'customer%')->get();

        foreach ($users as $user) {
            $user->assignRole($role);
        }

        $this->call([
            JewellerySeeder::class,
            TransactionSeeder::class,
            TransactionDetailSeeder::class,
            BuyBackPercentageSeeder::class,
            BuyBackSeeder::class,
            BuyBackDetailSeeder::class,

            FileSeeder::class,
        ]);
    }
}
