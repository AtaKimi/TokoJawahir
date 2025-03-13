<?php

namespace App\Livewire\Admin\BuyBack;

use App\Models\BuyBack;
use Livewire\Component;
use App\Enum\BuyBackStatus;
use App\Models\BuyBackDetail;

class CartDetail extends Component
{
    public $transaction_detail;

    public $buy_back;

    public $buy_back_detail;

    public $count = 0;

    public function mount()
    {
        if (BuyBackDetail::where('transaction_detail_id', $this->transaction_detail->id)->where('buy_back_id', $this->buy_back->id)->exists()) {
            $this->buy_back_detail = BuyBackDetail::where('transaction_detail_id', $this->transaction_detail->id)->where('buy_back_id', $this->buy_back->id)->first();
            $this->count = $this->buy_back_detail->quantity;
        }
    }

    public function increment()
    {
        if (empty($this->buy_back_detail) or !$this->buy_back_detail->exists()) {
            $this->buy_back_detail = BuyBackDetail::create([
                'transaction_detail_id' => $this->transaction_detail->id,
                'buy_back_id' => $this->buy_back->id,
                'quantity' => $this->count,
            ]);
        }

        if ($this->count < $this->transaction_detail->buyBackQuantityLeft()) {
            $this->count++;
            if ($this->count == 0) {
                $this->buy_back_detail->delete();
            } else {
                $this->buy_back_detail->update([
                    'quantity' => $this->count,
                    'total' => $this->count * $this->transaction_detail->jewellery->price
                ]);
                $this->dispatch('increment', $this->transaction_detail->jewellery->price);
            }
        }
    }

    public function decrement()
    {
        if ($this->count > 0) {
            $this->count--;
            $this->buy_back_detail->update([
                'quantity' => $this->count,
                'total' => $this->count * $this->transaction_detail->jewellery->price
            ]);
        }
        $this->dispatch('decrement', $this->transaction_detail->jewellery->price);
    }

    public function render()
    {
        return view('livewire.admin.buy-back.cart-detail');
    }
}
