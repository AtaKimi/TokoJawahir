<?php

namespace App\Http\Controllers\User;

use App\Enum\BuyBackStatus;
use App\Http\Controllers\Controller;
use App\Models\BuyBack;

class BuyBackController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $buy_backs = BuyBack::where('user_id', $user->id)->where('status', BuyBackStatus::SUCCESS)->latest()->paginate(10);

        return view('user.buyback.index', compact('buy_backs'));
    }

    public function show(BuyBack $buy_back)
    {
        if ($buy_back->user_id != auth()->user()->id) {
            abort(403);
        }
        if ($buy_back->status != BuyBackStatus::SUCCESS->value) {
            return redirect()->route('user.buyback.index');
        }

        return view('user.buyback.show', compact('buy_back'));
    }
}
