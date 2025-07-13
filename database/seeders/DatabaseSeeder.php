<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            JewellerySeeder::class,
            TransactionSeeder::class,
            TransactionDetailSeeder::class,
            BuyBackPercentageSeeder::class,
            BuyBackSeeder::class,
            // BuyBackDetailSeeder::class,
            StoreSeeder::class,

            FileSeeder::class,
        ]);
    }
}
