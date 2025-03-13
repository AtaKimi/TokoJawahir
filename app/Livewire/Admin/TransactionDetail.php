<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Jewellery;
use Livewire\Attributes\Locked;
use App\Models\TransactionDetail as TransactionDetailModel;
use App\Models\Transaction as TransactionModel;

class TransactionDetail extends Component
{
    public Jewellery $jewellery;
    public TransactionModel $transaction;
    public TransactionDetailModel $transaction_detail;
    #[Locked]
    public $count = 0;
    public $deleted = false;

    public function increment()
    {
        if ($this->count < $this->jewellery->quantity) {
            if (empty($this->transaction_detail) or !$this->transaction_detail->exists()) {
                $this->transaction_detail = TransactionDetailModel::create([
                    'transaction_id' => $this->transaction->id,
                    'jewellery_id' => $this->jewellery->id,
                    'quantity' => $this->count,
                    'total' => $this->jewellery->price
                ]);
            }

            $this->count++;
            $this->dispatch('increment', $this->jewellery->price);
            $this->transaction_detail->update([
                'quantity' => $this->count,
                'total' => $this->jewellery->price * $this->count
            ]);
        }
    }

    public function decrement()
    {
        if ($this->count > 0) {
            $this->count--;
            $this->dispatch('decrement', $this->jewellery->price);  
            if($this->count == 0) {
                $this->transaction_detail->delete();
            } else {
                $this->transaction_detail->update([
                    'quantity' => $this->count
                ]);
            }
        }
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
