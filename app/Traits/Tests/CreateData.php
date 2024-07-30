<?php

namespace App\Traits\Tests;

use App\Models\Admin;
use App\Models\Bid;
use App\Models\Coin;
use App\Models\Currency;
use App\Models\User;

trait CreateData
{

    public function create_admin_user(): Admin
    {
        $admin = new Admin;
        $admin->email = 'admin@mail.ru';
        $admin->password = bcrypt('admin1234');
        $admin->save();
        return $admin;
    }

    public function create_telegram_user(): void
    {
        $user = new User;
        $user->name = 'Telegram User';
        $user->email = 'telegram@mail.ru';
        $user->password = bcrypt('telegram1234');
        $user->telegram_id = '232323';
        $user->save();
    }

    public function create_data(): void
    {
        $this->create_coins();

        $this->create_users();

        $this->create_currencies();

        $this->create_bids();
    }

    public function create_coins(): void
    {
        $coin_one = new Coin;

        $coin_one->name = 'Bitcoin';
        $coin_one->symbol = 'BTC';
        $coin_one->price = 40000;
        $coin_one->save();

        $coin_two = new Coin;

        $coin_two->name = 'Ethereum';
        $coin_two->symbol = 'ETH';
        $coin_two->price = 4000;
        $coin_two->save();
    }

    public function create_users(): void
    {
        $user_one = new User;

        $user_one->name = 'User One';
        $user_one->email = 'user@mail.ru';
        $user_one->password = bcrypt('user1234');
        $user_one->telegram_id = '232323';
        $user_one->save();

        $user_two = new User;

        $user_two->name = 'User Two';
        $user_two->email = 'user2@mail.ru';
        $user_two->password = bcrypt('user1234');
        $user_two->telegram_id = '2323233434';
        $user_two->save();
    }

    public function create_currencies(): void
    {
        $currency_one = new Currency;

        $currency_one->name = 'US Dollar';
        $currency_one->symbol = 'USD';
        $currency_one->save();

        $currency_two = new Currency;

        $currency_two->name = 'Euro';
        $currency_two->symbol = 'EUR';
        $currency_two->save();
    }

    public function create_bids(): void
    {
        $bid_one = new Bid;

        $bid_one->user_id = 1;
        $bid_one->coin_id = 1;
        $bid_one->currency_id = 1;
        $bid_one->price = 40000;
        $bid_one->amount = 40000;
        $bid_one->save();

        $bid_two = new Bid;

        $bid_two->user_id = 2;
        $bid_two->coin_id = 2;
        $bid_two->currency_id = 2;
        $bid_two->price = 4000;
        $bid_two->amount = 4000;
        $bid_two->save();
    }

}
