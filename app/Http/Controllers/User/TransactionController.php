<?php

namespace App\Http\Controllers\User;

use App\Enum\TransactionStatus;
use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $transactions = $user->transactions()->where('status', TransactionStatus::SUCCESS)->latest()->paginate(10);

        return view('user.transaction.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->status != TransactionStatus::SUCCESS->value) {
            return redirect()->route('user.transaction.index');
        }

        return view('user.transaction.show', compact('transaction'));
    }
}
