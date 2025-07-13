<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Jewellery;
use Illuminate\Http\Request;

class Homepage extends Controller
{
    public function index()
    {
        // $jewelleries = Jewellery::where('quantity', '>', 0)->latest()->filterByName(request()->query())->paginate(25);
        // return view('guest.index', compact('jewelleries'));

        return redirect()->route('guest.jewellery.index');
    }

    public function show(Jewellery $jewellery)
    {
        return view('guest.show', compact('jewellery'));
    }
}
