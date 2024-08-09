<?php

namespace App\Traits\Tests;

use App\Enums\API_Client\Bid\BidPaymentMethodEnum;
use App\Enums\API_Client\Bid\BidTypeEnum;
use App\Models\Admin;
use App\Models\Bid;
use App\Models\Coin;
use App\Models\Currency;
use App\Models\User;
use App\Models\Wallet;

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

        $this->create_admins();
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

        $coin_three = new Coin;

        $coin_three->name = 'Solana';
        $coin_three->symbol = 'SOL';
        $coin_three->price = 400;
        $coin_three->save();

        $coin_four = new Coin;

        $coin_four->name = 'BNB';
        $coin_four->symbol = 'BNB';
        $coin_four->price = 400;
        $coin_four->save();
    }

    public function create_users(): void
    {
        $user_one = new User;

        $user_one->name = 'User One';
        $user_one->email = 'user@mail.ru';
        $user_one->password = bcrypt('user1234');
        $user_one->telegram_id = '232323';
        $user_one->save();

        $wallet_for_user_one = new Wallet;
        $wallet_for_user_one->user_id = $user_one->id;
        $wallet_for_user_one->balance = 0;
        $wallet_for_user_one->uuid = uuid_create();
        $wallet_for_user_one->coin_id = 1;
        $wallet_for_user_one->save();

        $user_two = new User;

        $user_two->name = 'User Two';
        $user_two->email = 'user2@mail.ru';
        $user_two->password = bcrypt('user1234');
        $user_two->telegram_id = '2323233434';
        $user_two->save();

        $wallet_for_user_two = new Wallet;
        $wallet_for_user_two->user_id = $user_two->id;
        $wallet_for_user_two->balance = 0;
        $wallet_for_user_two->uuid = uuid_create();
        $wallet_for_user_two->coin_id = 2;
        $wallet_for_user_two->save();
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
        $bid_one->type = BidTypeEnum::BUY();
        $bid_one->number = '+7(999) 999-99-99';
        $bid_one->payment_method = BidPaymentMethodEnum::ALFA();
        $bid_one->save();

        $bid_two = new Bid;

        $bid_two->user_id = 2;
        $bid_two->coin_id = 2;
        $bid_two->currency_id = 2;
        $bid_two->price = 4000;
        $bid_two->amount = 4000;
        $bid_two->type = BidTypeEnum::BUY();
        $bid_two->number = '+7(999) 999-99-99';
        $bid_two->payment_method = BidPaymentMethodEnum::ALFA();
        $bid_two->save();
    }

    public function create_admins(): void
    {
        $admin_one = new Admin;

        $admin_one->email = 'admin_one@mail.ru';
        $admin_one->password = bcrypt('admin1234');
        $admin_one->save();

        $admin_two = new Admin;

        $admin_two->email = 'admin_two@mail.ru';
        $admin_two->password = bcrypt('admin1234');
        $admin_two->save();
    }

}
