<?php

namespace App\Livewire\Admin\BuyBack;

use Livewire\Component;
use Livewire\Attributes\On;

class CartBubble extends Component
{

    public $buy_back;

    public $total = 0;

    public $quantity = 0;

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
        $this->total = $this->buy_back->buyBackDetails()->sum('total');
        $this->quantity = $this->buy_back->buyBackDetails()->sum('quantity');
    }


    public function render()
    {
        return view('livewire.admin.buy-back.cart-bubble');
    }
}
