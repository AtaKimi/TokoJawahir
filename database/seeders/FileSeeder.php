<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jewellery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Storage::disk('public')->exists('media')) {
            Storage::disk('public')->deleteDirectory('media');
        }

        $jewelleries = Jewellery::all();

        foreach ($jewelleries as $jewellery) {
            $jewellery->addMediaFromUrl('https://picsum.photos/200/300')->toMediaCollection('image');
        }

        // ---------------------------------------------------------------------------------------

        $users = User::all();

        foreach ($users as $user) {
             $user->addMediaFromUrl('https://picsum.photos/200/300')->toMediaCollection('image');
        }
    }
}
