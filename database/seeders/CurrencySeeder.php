<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $this->create_RUB();
        $this->create_USD();
        $this->create_EUR();
    }

    private function create_RUB(): void
    {
        $currency = new Currency;

        $currency->name = 'Russian ruble';
        $currency->symbol = 'RUB';

        $currency->save();
    }

    private function create_USD(): void
    {
        $currency = new Currency;

        $currency->name = 'US Dollar';
        $currency->symbol = 'USD';

        $currency->save();
    }

    private function create_EUR(): void
    {
        $currency = new Currency;

        $currency->name = 'Euro';
        $currency->symbol = 'EUR';

        $currency->save();
    }
}
