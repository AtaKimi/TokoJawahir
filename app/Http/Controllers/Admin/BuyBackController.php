<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\BuyBack;
use App\Enum\BuyBackStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Database\Eloquent\Builder;

class BuyBackController extends Controller
{
    public function index()
    {
        $buy_backs = BuyBack::latest()->paginate(10);
        return view('admin.buyback.index', compact('buy_backs'));
    }

    public function users()
    {
        $users = User::latest()->filterByName(request()->query())->with(['buyBacks' => function (Builder $query) {
            $query->where('status', '=', BuyBackStatus::PENDING);
        }])->paginate(10);
        return view('admin.buyback.users', compact('users'));
    }

    public function create(User $user)
    {
        return view('admin.buyback.create', compact('user'));
    }

    public function review(User $user, BuyBack $buy_back)
    {
        return view('admin.buyback.review', compact('user', 'buy_back'));
    }

    public function confirmation(User $user, BuyBack $buy_back)
    {
        $validated = request()->validate([
            'status' => 'required|string|in:success,failed,pending',
        ]);

        if ($validated['status'] == 'failed') {
            $buy_back->update([
                'status' => BuyBackStatus::FAILED,
            ]);
        } else if ($validated['status'] == 'success') {

            foreach ($buy_back->buyBackDetails as $buy_back_detail) {
                if ($buy_back_detail->quantity > $buy_back_detail->transactionDetail->quantity_left) {
                    $buy_back_detail->delete();
                }
            }

            $buy_back->update([
                'status' => BuyBackStatus::SUCCESS,
                'total' => $buy_back->buyBackDetails()->sum('total'),
                'total_sold' => $buy_back->buyBackDetails()->sum('total_sold'),
            ]);

            foreach ($buy_back->buyBackDetails as $buy_back_detail) {
                $transaction_detail = $buy_back_detail->transactionDetail;
                $transaction_detail->update([
                    'quantity_left' => $transaction_detail->quantity_left - $buy_back_detail->quantity,
                ]);
            }
        }
        return redirect()->route('admin.buyback.index');
    }
}
