<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::factory(60)->sequence([
            'user_id' => fn () => User::all()->random()->id,
        ])->create();

        Transaction::factory(10)->sequence([
            'user_id' => fn () => User::where('name', 'customer1')->first()->id,
        ])->create();
    }
}
