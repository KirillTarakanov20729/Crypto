<?php

namespace App\Traits\Tests;

use App\Models\Admin;
use App\Models\Coin;
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

}
