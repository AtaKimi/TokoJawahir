<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BuyBackPercentageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\BuyBackPercentage::factory(1)->create();
    }
}
