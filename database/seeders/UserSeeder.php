<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            User::factory()->create([
                'name' => 'admin'.$i,
                'email' => 'admin'.$i.'@example.com',
                'is_admin' => true,
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            User::factory()->create([
                'name' => 'customer'.$i,
                'email' => 'customer'.$i.'@example.com',
            ]);
        }
    }
}
