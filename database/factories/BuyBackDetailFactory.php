<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BuyBackDetail>
 */
class BuyBackDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function ($buy_back_detail) {
            $buy_back = $buy_back_detail->buyBack;
            $buy_back->total = $buy_back->buyBackDetails()->sum('total');
            $buy_back->save();
        });
    }
}
