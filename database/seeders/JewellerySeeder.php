<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JewellerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Jewellery::factory(25)->create();
    }
}
