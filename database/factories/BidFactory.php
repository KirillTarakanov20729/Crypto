<?php

namespace Database\Factories;

use App\Enums\API_Client\Bid\BidStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bid>
 */
class BidFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'coin_id' => 1,
            'currency_id' => 1,
            'amount' => $this->faker->numberBetween(1, 1000),
            'price' => $this->faker->numberBetween(1, 1000),
            'status' => BidStatusEnum::CREATED(),
        ];
    }
}
