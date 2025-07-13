<?php

namespace App\Livewire\Admin;

use App\Enum\TransactionStatus;
use App\Models\Jewellery;
use App\Models\Transaction as TransactionModel;
use App\Models\User;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Transaction extends Component
{
    use WithoutUrlPagination, WithPagination;

    public TransactionModel $transaction;

    public User $user;

    public function mount()
    {
        if (TransactionModel::where('user_id', $this->user->id)->where('status', TransactionStatus::PENDING)->exists()) {
            $this->transaction = TransactionModel::where('user_id', $this->user->id)->where('status', TransactionStatus::PENDING)->first();
            foreach ($this->transaction->transactionDetails as $transaction_detail) {
                if ($transaction_detail->jewellery->quantity < $transaction_detail->quantity) {
                    $transaction_detail->delete();
                }
            }
        } else {
            $this->transaction = TransactionModel::create([
                'user_id' => $this->user->id,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.transaction', [
            'jewelleries' => Jewellery::latest()->where('quantity', '>', 0)->filterByName(request()->query())->paginate(10),
            'transaction' => $this->transaction,
        ]);
    }
}
