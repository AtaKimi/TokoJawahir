<?php

namespace Database\Seeders;

use App\Enum\TransactionStatus;
use App\Models\Jewellery;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = Transaction::get();

        foreach ($transactions as $transaction) {
            for ($i = 0; $i < fake()->numberBetween(1, 5); $i++) {
                $jewellery = Jewellery::inRandomOrder()->first();
                $quantity = fake()->numberBetween(1, 10);
                $transaction->transactionDetails()->create([
                    'jewellery_id' => $jewellery->id,
                    'quantity' => $quantity,
                    'total' => $quantity * $jewellery->price,
                ]);
            }

            $rng = fake()->numberBetween(1, 3);

            if ($rng == 1) {
                $status = TransactionStatus::PENDING;
            } elseif ($rng == 2) {
                $status = TransactionStatus::SUCCESS;
            } else {
                $status = TransactionStatus::FAILED;
            }

            $transaction->update([
                'status' => $status,
                'total' => $transaction->transactionDetails()->sum('total'),
            ]);
        }
    }
}
