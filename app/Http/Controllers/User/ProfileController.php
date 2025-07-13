<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('user.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();

        return view('user.profile.edit', compact('user'));
    }

    public function update()
    {
        $user = auth()->user();

        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|numeric',
        ]);

        $user->update($validated);

        return redirect()->route('user.profile.index');
    }

    public function updatePhoto()
    {
        $user = auth()->user();
        $validated = request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (request()->hasFile('image')) {
            if (! empty($user->getFirstMediaUrl('image'))) {
                $user->clearMediaCollection('image');
            }
            $user->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('user.profile.index');
    }
}
