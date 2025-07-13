<?php

namespace Database\Seeders;

use App\Enum\BuyBackStatus;
use App\Enum\TransactionStatus;
use App\Models\BuyBack;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Database\Seeder;

class BuyBackSeeder extends Seeder
{
    public $user_exceptions = [];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('name', 'customer1')->first();

        $transactions = Transaction::where('user_id', $user->id)->where('status', TransactionStatus::SUCCESS)->get();

        $transaction_details = TransactionDetail::whereIn('transaction_id', $transactions->pluck('id')->toArray())->get();

        $buy_backs = BuyBack::factory(3)->create([
            'user_id' => $user->id,
            'status' => BuyBackStatus::SUCCESS,
        ]);

        foreach ($transaction_details as $index => $transaction_detail) {
            if (fake()->boolean()) {
                $qty = fake()->numberBetween(1, $transaction_detail->quantity);
                $buy_backs[$index % 3]->buyBackDetails()->create([
                    'transaction_detail_id' => $transaction_detail->id,
                    'quantity' => $qty,
                    'total' => $qty * ($transaction_detail->total / $transaction_detail->quantity),
                    'total_sold' => $qty * ($transaction_detail->total / $transaction_detail->quantity) - $qty * ($transaction_detail->total / $transaction_detail->quantity) * ($buy_backs[$index % 3]->buyBackPercentage->percentage / 100),
                ]);

                $transaction_detail->update([
                    'quantity_sold' => $transaction_detail->quantity_sold + $qty,
                ]);
            }
        }

        foreach ($buy_backs as $buy_back) {
            $buy_back->update([
                'status' => BuyBackStatus::SUCCESS,
                'total' => $buy_back->buyBackDetails()->sum('total'),
                'total' => $buy_back->buyBackDetails()->sum('total_sold'),
            ]);
        }
    }
}
