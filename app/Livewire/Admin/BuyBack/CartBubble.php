<?php

namespace App\Livewire\Admin\BuyBack;

use Livewire\Component;
use Livewire\Attributes\On;

class CartBubble extends Component
{

    public $buy_back;

    public $total = 0;

    public $quantity = 0;

    public $user;

    #[On('updateQuantityAndTotalBuyBack')]
    public function updateQuantityAndTotal($quantity, $price)
    {
        $this->quantity += $quantity;
        $this->total += $price;
    }

    public function mount()
    {
        $this->total = $this->buy_back->buyBackDetails()->sum('total');
        $this->quantity = $this->buy_back->buyBackDetails()->sum('quantity');
        // dd($this->total);
    }


    public function render()
    {
        return view('livewire.admin.buy-back.cart-bubble');
    }
}
