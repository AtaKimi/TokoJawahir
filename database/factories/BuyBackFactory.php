<?php

namespace Database\Factories;

use App\Enum\BuyBackStatus;
use App\Models\BuyBackPercentage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BuyBack>
 */
class BuyBackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => BuyBackStatus::PENDING,
            'buy_back_percentage_id' => BuyBackPercentage::latest()->first()->id,
        ];
    }
}
