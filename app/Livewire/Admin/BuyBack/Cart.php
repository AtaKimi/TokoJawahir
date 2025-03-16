<?php

namespace App\Livewire\Admin\BuyBack;

use App\Models\User;
use App\Models\BuyBack;
use Livewire\Component;
use App\Enum\BuyBackStatus;
use App\Models\Transaction;
use App\Enum\TransactionStatus;
use Livewire\Attributes\Locked;
use App\Models\BuyBackPercentage;

class Cart extends Component
{
    public User $user;

    #[Locked]
    public $transactions;

    #[Locked]
    public $buy_backs;

    #[Locked]
    public $buy_back;

    public function mount(User $user)
    {
        $this->transactions = Transaction::where('user_id', $user->id)->where('status', TransactionStatus::SUCCESS)->with([
            'transactionDetails' => function ($query) {
                $query->withSum('buyBackDetails', 'quantity');
            }
        ])->get();


        if (BuyBack::where('user_id', $this->user->id)->where('status', BuyBackStatus::PENDING)->exists()) {
            $this->buy_back = BuyBack::where('user_id', $this->user->id)->where('status', BuyBackStatus::PENDING)->first();
            foreach ($this->buy_back->buyBackDetails as $buy_back_detail) {
                if ($buy_back_detail->quantity > $buy_back_detail->transactionDetail->quantity_left) {
                    $buy_back_detail->delete();
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
