<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Jewellery;

class JewelleryController extends Controller
{
    public function index()
    {
        $jewelleries = Jewellery::where('quantity', '>', 0)->latest()->filterByName(request()->query())->paginate(25);

        return view('guest.jewellery.index', compact('jewelleries'));
    }

    public function show(Jewellery $jewellery)
    {
        return view('guest.jewellery.show', compact('jewellery'));
    }
}
