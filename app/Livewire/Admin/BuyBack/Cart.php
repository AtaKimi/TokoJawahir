<?php

namespace App\Livewire\Admin\BuyBack;

use App\Models\User;
use App\Models\BuyBack;
use Livewire\Component;
use App\Enum\BuyBackStatus;
use App\Models\BuyBackPercentage;

class Cart extends Component
{
    public User $user;

    public $transaction_details = [];

    public BuyBack $buy_back;

    public function mount(User $user)
    {
        $this->user = $user;
        $transactions = $user->transactions()->with('transactionDetails')->get();

        foreach ($transactions as $transaction) {
            foreach ($transaction->transactionDetails as $transaction_detail) {
                $this->transaction_details[] = $transaction_detail;
            }
        }

        if (BuyBack::where('user_id', $this->user->id)->where('status', BuyBackStatus::PENDING)->exists()) {
            $this->buy_back = BuyBack::where('user_id', $this->user->id)->where('status', BuyBackStatus::PENDING)->first();


            foreach ($this->buy_back->buyBackDetails as $buy_back_detail) {
                if ($buy_back_detail->transactionDetail->quantity <  $buy_back_detail->quantity) {
                    $transaction_detail->delete();
                }
            }
        } else {
            $this->buy_back = BuyBack::create([
                'user_id' => $this->user->id,
                'buy_back_percentage_id' => BuyBackPercentage::latest()->first()->id
            ]);
        }
    }
    public function render()
    {
        return view('livewire.admin.buy-back.cart');
    }
}
