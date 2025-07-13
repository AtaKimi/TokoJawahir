<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuyBackPercentage;
use App\Models\Store;

class StoreController extends Controller
{
    public function index()
    {
        $buy_back_percentage = BuyBackPercentage::latest()->first();
        $store = Store::find(1);

        return view('admin.store.index', compact('buy_back_percentage', 'store'));
    }

    public function edit()
    {
        $store = Store::find(1);

        return view('admin.store.edit', compact('store'));
    }

    public function update()
    {
        $store = Store::find(1);
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|numeric',
            'email' => 'required|string|email',
        ]);
        $store->update($validated);

        return redirect()->route('admin.store.index');
    }

    public function updateBuyBackPercentage()
    {
        $validated = request()->validate([
            'percentage' => 'required|numeric|min:0|max:100',
        ]);
        BuyBackPercentage::create($validated);

        return redirect()->route('admin.store.index');
    }
}
