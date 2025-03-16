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

    #[On('updateQuantityAndTotal')]
    public function updateQuantityAndTotal($quantity, $price)
    {
        $this->quantity += $quantity;
        $this->total += $price;
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
