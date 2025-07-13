<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jewellery;

class JewelleryController extends Controller
{
    public function index()
    {
        $jewelleries = Jewellery::latest()->filterByName(request()->query())->paginate(10);

        return view('admin.jewellery.index', compact('jewelleries'));
    }

    public function create()
    {
        return view('admin.jewellery.create');
    }

    public function edit(Jewellery $jewellery)
    {
        return view('admin.jewellery.edit', compact('jewellery'));
    }

    public function store()
    {

        $input = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:0|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $jewellery = Jewellery::create($input);

        $jewellery->addMediaFromRequest('image')->toMediaCollection('image');

        return redirect()->route('admin.jewellery.index');
    }

    public function update(Jewellery $jewellery)
    {
        $input = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:0|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $jewellery->update($input);

        if (request('image')) {
            $jewellery->clearMediaCollection('image');
            $jewellery->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('admin.jewellery.index');
    }

    public function destroy(Jewellery $jewellery)
    {
        $jewellery->delete();

        return redirect()->route('admin.jewellery.index');
    }
}
