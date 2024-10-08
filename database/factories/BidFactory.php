<?php

namespace Database\Factories;

use App\Enums\API_Client\Bid\BidPaymentMethodEnum;
use App\Enums\API_Client\Bid\BidStatusEnum;
use App\Enums\API_Client\Bid\BidTypeEnum;
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
            'uuid' => $this->faker->uuid(),
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'coin_id' => Coin::query()->inRandomOrder()->first()->id,
            'currency_id' => Currency::query()->inRandomOrder()->first()->id,
            'amount' => $this->faker->numberBetween(1, 1000),
            'price' => $this->faker->numberBetween(1, 1000),
            'status' => BidStatusEnum::CREATED(),
            'type' => rand(0, 1) ? BidTypeEnum::BUY() : BidTypeEnum::SELL(),
            'number' => '+79104321916',
            'payment_method' => rand(0, 1) ? BidPaymentMethodEnum::SBER() : BidPaymentMethodEnum::ALFA()
        ];
    }
}
