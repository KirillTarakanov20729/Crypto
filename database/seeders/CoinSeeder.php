<?php

namespace Database\Seeders;

use App\Models\Coin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoinSeeder extends Seeder
{

    public function run(): void
    {
        $this->create_BTC();
        $this->create_ETH();
        $this->create_SOL();
        $this->create_BNB();
        $this->create_USDT();
        $this->create_USDC();
        $this->create_XRP();
    }

    private function create_BTC(): void
    {

        $coin = new Coin();
        $coin->name = 'Bitcoin';
        $coin->symbol = 'BTC';
        $coin->price = 0;
        $coin->save();
    }

    private function create_ETH(): void
    {
        $coin = new Coin();
        $coin->name = 'Ethereum';
        $coin->symbol = 'ETH';
        $coin->price = 0;
        $coin->save();
    }

    private function create_SOL(): void
    {
        $coin = new Coin();
        $coin->name = 'Solana';
        $coin->symbol = 'SOL';
        $coin->price = 0;
        $coin->save();
    }

    private function create_BNB(): void
    {
        $coin = new Coin();
        $coin->name = 'BNB';
        $coin->symbol = 'BNB';
        $coin->price = 0;
        $coin->save();
    }

    private function create_USDT(): void
    {
        $coin = new Coin();
        $coin->name = 'Tether';
        $coin->symbol = 'USDT';
        $coin->price = 0;
        $coin->save();
    }

    private function create_USDC(): void
    {
        $coin = new Coin();
        $coin->name = 'USD Coin';
        $coin->symbol = 'USDC';
        $coin->price = 0;
        $coin->save();
    }

    private function create_XRP(): void
    {
        $coin = new Coin();
        $coin->name = 'XRP';
        $coin->symbol = 'XRP';
        $coin->price = 0;
        $coin->save();
    }
}
