<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Jewellery;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use App\Models\Transaction as TransactionModel;
use App\Models\TransactionDetail as TransactionDetailModel;
use Illuminate\Support\Facades\Validator;

class TransactionDetail extends Component
{
    public Jewellery $jewellery;
    public TransactionModel $transaction;
    public TransactionDetailModel $transaction_detail;
    public $count = 0;
    public $lastQuantity = 0;

    public function updateQuantity()
    {
        $this->resetValidation();
        $validator = Validator::make(
            ['count' => $this->count],
            ['count' => ['required', 'integer', 'min:0', 'max:' . $this->jewellery->quantity]],
            [
                'count.required' => 'Quantity is required',
                'count.integer' => 'Quantity must be an integer',
                'count.min' => 'Quantity must be at least 0',
                'count.max' => 'Quantity must be less than or equal to ' . $this->jewellery->quantity
            ],
        )->validate();

        if ($this->count <= 0) {
            $this->lastQuantity = $this->transaction_detail->quantity;
            if (!empty($this->transaction_detail) or $this->transaction_detail->exists()) {
                $this->transaction_detail->delete();
            }
            $this->count = 0;
        } else if ($this->count <= $this->jewellery->quantity) {
            if (empty($this->transaction_detail) or !$this->transaction_detail->exists()) {
                $this->transaction_detail = TransactionDetailModel::create([
                    'transaction_id' => $this->transaction->id,
                    'jewellery_id' => $this->jewellery->id,
                    'quantity' => $this->count,
                    'total' => $this->jewellery->price * $this->count
                ]);
            } else {
                $this->lastQuantity = $this->transaction_detail->quantity;
                $this->transaction_detail->update([
                    'quantity' => $this->count,
                    'total' => $this->jewellery->price * $this->count
                ]);
            }
        }

        $this->dispatch('updateQuantityAndTotal',  $this->count - $this->lastQuantity, $this->jewellery->price * ($this->count - $this->lastQuantity));
    }

    public function mount()
    {
        if (TransactionDetailModel::where('transaction_id', $this->transaction->id)->where('jewellery_id', $this->jewellery->id)->exists()) {
            $this->transaction_detail = TransactionDetailModel::where('transaction_id', $this->transaction->id)->where('jewellery_id', $this->jewellery->id)->first();
            $this->count = $this->transaction_detail->quantity;
        }
    }

    public function render()
    {
        return view('livewire.admin.transaction-detail');
    }
}
