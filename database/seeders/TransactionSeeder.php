<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::factory(60)->sequence([
            'user_id' => fn() => User::all()->random()->id
        ])->create();

        Transaction::factory(10)->sequence([
            'user_id' => fn() => User::where('name', 'admin0')->first()->id
        ])->create();
    }
}
