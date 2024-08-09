<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users_count = User::query()->count();

        for ($i = 0; $i < $users_count; $i++) {
            /** @var User $user */
            $user = User::query()->find($i + 1);

            $btc_wallet = new Wallet;
            $btc_wallet->user_id = $user->id;
            $btc_wallet->coin_id = 4;
            $btc_wallet->balance = rand(1, 100);
            $btc_wallet->uuid = uuid_create();
            $btc_wallet->save();

            $eth_wallet = new Wallet;
            $eth_wallet->user_id = $user->id;
            $eth_wallet->coin_id = 1;
            $eth_wallet->balance = rand(1, 100);
            $eth_wallet->uuid = uuid_create();
            $eth_wallet->save();

            $sol_wallet = new Wallet;
            $sol_wallet->user_id = $user->id;
            $sol_wallet->coin_id = 2;
            $sol_wallet->balance = rand(100, 1000);
            $sol_wallet->uuid = uuid_create();
            $sol_wallet->save();

            $bnb_wallet = new Wallet;
            $bnb_wallet->user_id = $user->id;
            $bnb_wallet->coin_id = 3;
            $bnb_wallet->balance = rand(20, 400);
            $bnb_wallet->uuid = uuid_create();
            $bnb_wallet->save();
        }
    }
}
