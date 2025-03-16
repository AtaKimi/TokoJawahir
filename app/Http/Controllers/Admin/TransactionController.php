<?php

namespace App\Http\Controllers\Admin;

use App\Enum\TransactionStatus;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Database\Eloquent\Builder;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::whereHas('user', function ($query) {
            $query->where('name', 'like', '%' . request()->query('search') . '%');
        })->latest()->paginate(10);

        return view('admin.transaction.index', compact('transactions'));
    }
    public function users()
    {
        $users = User::latest()->filterByName(request()->query())->with(['transactions' => function (Builder $query) {
            $query->where('status', '=', TransactionStatus::PENDING);
        }])->paginate(10);
        return view('admin.transaction.users', compact('users'));
    }

    public function create(User $user)
    {
        return view('admin.transaction.create', compact('user'));
    }

    public function review(User $user, Transaction $transaction)
    {
        $transaction->update([
            'total' => $transaction->transactionDetails->sum('total'),
        ]);
        return view('admin.transaction.review', compact('user', 'transaction'));
    }

    public function confirmation(User $user, Transaction $transaction)
    {
        $validated = request()->validate([
            'status' => 'required|string|in:success,failed,pending',
        ]);

        if ($validated['status'] == 'failed') {
            $transaction->update([
                'status' => TransactionStatus::FAILED,
            ]);
        } else if ($validated['status'] == 'success') {

            foreach ($transaction->transactionDetails as $transaction_detail) {
                if ($transaction_detail->jewellery->quantity < $transaction_detail->quantity) {
                    $transaction_detail->delete();
                }
            }

            $transaction->update([
                'status' => TransactionStatus::SUCCESS,
                'total' => $transaction->transactionDetails()->sum('total'),
            ]);

            foreach ($transaction->transactionDetails as $transaction_detail) {
                $jewellery = $transaction_detail->jewellery;
                $jewellery->update([
                    'quantity' => $jewellery->quantity - $transaction_detail->quantity,
                ]);
            }
        }
        return redirect()->route('admin.transaction.index');
    }
}
