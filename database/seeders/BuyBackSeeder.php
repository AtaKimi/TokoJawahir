<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;

class BuyBackSeeder extends Seeder
{
    public $user_exceptions = [];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_exceptions = [];

        \App\Models\BuyBack::factory(10)->state(new Sequence(
            fn(Sequence $sequence) => [
                'user_id' => $this->getNewUser()->id,
            ],
        ))->create()->each(function ($buyBack) {
            $transaction = \App\Models\Transaction::where('user_id', $buyBack->user_id)->inRandomOrder()->first();
            foreach ($transaction->transactionDetails as $transaction_detail) {
                if (fake()->boolean(80)) {
                    $quantity = fake()->numberBetween(1, $transaction_detail->quantity);
                    $buyBack->buyBackDetails()->save(
                        \App\Models\BuyBackDetail::factory()->create(
                            [
                                'buy_back_id' => $buyBack->id,
                                'transaction_detail_id' => $transaction_detail->id,
                                'quantity' => $quantity,
                                'total' => $transaction_detail->jewellery->price * $quantity,
                            ]
                        )
                    );
                }
            }
        });
    }

    public function getNewUser()
    {
        $user = User::has('transactions')->whereNotIn('id', $this->user_exceptions)->inRandomOrder()->first();
        $this->user_exceptions[] = $user->id;
        return $user;
    }
}
