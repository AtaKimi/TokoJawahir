<?php

namespace App\Livewire\Admin;

use App\Models\Transaction as TransactionModel;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class TransactionBubble extends Component
{

    public TransactionModel $transaction;

    public User $user;

    public $total;

    public $quantity;

    #[On('decrement')]
    public function decrement($price)
    {
        $this->quantity--;
        $this->total -= $price;
    }

    #[On('increment')]
    public function increment($price)
    {
        $this->quantity++;
        $this->total += $price;
    }

    #[On('reduction')]
    public function reduction($redacted_price, $reducted_quantity)
    {
        $this->total -= $redacted_price;
        $this->quantity -= $reducted_quantity;
    }

    public function mount()
    {
        $this->total = $this->transaction->transactionDetails()->sum('total');
        $this->quantity = $this->transaction->transactionDetails()->sum('quantity');
    }

    public function render()
    {
        return view('livewire.admin.transaction-bubble', [
            'quantity' => $this->quantity,
            'total' => $this->total,
        ]);
    }
}
