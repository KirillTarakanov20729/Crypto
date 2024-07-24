<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CoinFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'symbol' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
