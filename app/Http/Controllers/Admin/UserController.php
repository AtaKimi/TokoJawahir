<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->filterByName(request()->query())->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    public function transactions(User $user)
    {
        $transactions = $user->transactions()->latest()->paginate(10);

        return view('admin.user.transaction', compact('user', 'transactions'));
    }

    public function buyBacks(User $user)
    {
        $buy_backs = $user->buyBacks()->latest()->paginate(10);

        return view('admin.user.buyback', compact('user', 'buy_backs'));
    }
}
