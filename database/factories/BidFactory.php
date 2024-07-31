<?php

namespace Database\Factories;

use App\Enums\API_Client\Bid\BidStatusEnum;
use App\Models\Coin;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bid>
 */
class BidFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'coin_id' => Coin::query()->inRandomOrder()->first()->id,
            'currency_id' => Currency::query()->inRandomOrder()->first()->id,
            'amount' => $this->faker->numberBetween(1, 1000),
            'price' => $this->faker->numberBetween(1, 1000),
            'status' => BidStatusEnum::CREATED(),
        ];
    }
}
