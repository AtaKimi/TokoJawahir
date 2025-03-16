<?php

namespace App\Livewire\Admin\BuyBack;

use Livewire\Component;
use App\Models\BuyBackDetail;
use Illuminate\Support\Facades\Validator;

class CartDetail extends Component
{
    public $transaction_detail;

    public $buy_back;

    public $buy_back_detail;

    public $count = 0;

    public $lastQuantity = 0;

    public function mount()
    {
        if (BuyBackDetail::where('transaction_detail_id', $this->transaction_detail->id)->where('buy_back_id', $this->buy_back->id)->exists()) {
            $this->buy_back_detail = BuyBackDetail::where('transaction_detail_id', $this->transaction_detail->id)->where('buy_back_id', $this->buy_back->id)->first();
            $this->count = $this->buy_back_detail->quantity;
        }
    }

    public function updateQuantity()
    {
        $this->resetValidation();
        Validator::make(
            ['count' => $this->count],
            ['count' => ['required', 'integer', 'min:0', 'max:' . $this->transaction_detail->quantity_left]],
            [
                'count.required' => 'Quantity is required',
                'count.integer' => 'Quantity must be an integer',
                'count.min' => 'Quantity must be at least 0',
                'count.max' => 'Quantity must be less than or equal to ' . $this->transaction_detail->quantity_left
            ],
        )->validate();

        if ($this->count <= 0 or $this->transaction_detail->quantity_left <= 0) {
            if (!empty($this->buy_back_detail)) {
                $this->lastQuantity = $this->buy_back_detail->quantity;
                $this->buy_back_detail->delete();
                $this->buy_back_detail = null;
            }
            $this->count = 0;
        } else if ($this->count <= $this->transaction_detail->quantity_left) {
            if (empty($this->buy_back_detail)) {
                $this->buy_back_detail = BuyBackDetail::create([
                    'buy_back_id' => $this->buy_back->id,
                    'transaction_detail_id' => $this->transaction_detail->id,
                    'quantity' => $this->count,
                    'total' => ($this->transaction_detail->total / $this->transaction_detail->quantity) * $this->count,
                    'total_sold' => ($this->transaction_detail->total / $this->transaction_detail->quantity) * $this->count - ($this->transaction_detail->total / $this->transaction_detail->quantity) * ($this->buy_back->buyBackPercentage->percentage / 100)
                ]);
                $this->lastQuantity = 0;
            } else {
                $this->lastQuantity = $this->buy_back_detail->quantity;
                $this->buy_back_detail->update([
                    'quantity' => $this->count,
                    'total' => ($this->transaction_detail->total / $this->transaction_detail->quantity) * $this->count,
                    'total_sold' => ($this->transaction_detail->total / $this->transaction_detail->quantity) * $this->count - ($this->transaction_detail->total / $this->transaction_detail->quantity * $this->count) * ($this->buy_back->buyBackPercentage->percentage / 100)
                ]);
            }
        }
        $this->dispatch(
            'updateQuantityAndTotalBuyBack',
            $this->count - $this->lastQuantity,
            ($this->transaction_detail->total / $this->transaction_detail->quantity) * ($this->count - $this->lastQuantity)
        );
    }

    public function render()
    {
        return view('livewire.admin.buy-back.cart-detail');
    }
}
