<?php

namespace App\Console\Commands\Coins;

use App\Models\Coin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GetCoinsPrice extends Command
{
    protected $signature = 'app:get-coins-price';
    public function handle(): void
    {
        $this->get_eth_price();
        $this->get_btc_price();
        $this->get_bnb_price();
        $this->get_sol_price();
        Cache::forget('coins');
    }

    private function get_eth_price(): void
    {
        $price = file_get_contents('https://api.binance.com/api/v3/ticker/price?symbol=ETHUSDT');
        $priceData = json_decode($price, true);

        /** @var Coin $eth */
        $eth = Coin::query()->where('symbol', 'ETH')->first();
        $eth->price = number_format($priceData['price'], 2, '.', '');
        $eth->save();
    }

    private function get_btc_price(): void
    {
        $price     = file_get_contents('https://api.binance.com/api/v3/ticker/price?symbol=BTCUSDT');
        $priceData = json_decode($price, true);

        /** @var Coin $btc */
        $btc        = Coin::query()->where('symbol', 'BTC')->first();
        $btc->price = number_format($priceData['price'], 2, '.', '');
        $btc->save();
    }

    private function get_bnb_price(): void
    {
        $price     = file_get_contents('https://api.binance.com/api/v3/ticker/price?symbol=BNBUSDT');
        $priceData = json_decode($price, true);

        /** @var Coin $bnb */
        $bnb        = Coin::query()->where('symbol', 'BNB')->first();
        $bnb->price = number_format($priceData['price'], 2, '.', '');
        $bnb->save();
    }

    private function get_sol_price(): void
    {
        $price     = file_get_contents('https://api.binance.com/api/v3/ticker/price?symbol=SOLUSDT');
        $priceData = json_decode($price, true);

        /** @var Coin $sol */
        $sol        = Coin::query()->where('symbol', 'SOL')->first();
        $sol->price = number_format($priceData['price'], 2, '.', '');
        $sol->save();
    }
}
