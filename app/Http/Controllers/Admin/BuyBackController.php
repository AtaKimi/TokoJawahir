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
        $buybacks = BuyBack::latest()->paginate(10);
        return view('admin.buyback.index', compact('buybacks'));
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
}
