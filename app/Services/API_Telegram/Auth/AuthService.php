<?php

namespace App\Services\API_Telegram\Auth;

use App\Contracts\API_Telegram\Auth\AuthContract;
use App\DTO\API_Telegram\Auth\LoginDTO;
use App\DTO\API_Telegram\Auth\RegisterDTO;
use App\DTO\API_Telegram\Auth\TelegramIdDTO;
use App\Exceptions\API_Telegram\Auth\ChangeLoginStatusException;
use App\Exceptions\API_Telegram\Auth\CheckAuthException;
use App\Exceptions\API_Telegram\Auth\FindUserException;
use App\Exceptions\API_Telegram\Auth\LoginException;
use App\Exceptions\API_Telegram\Auth\LoginTelegramIdException;
use App\Exceptions\API_Telegram\Auth\LogoutException;
use App\Exceptions\API_Telegram\Auth\StoreUserException;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService implements AuthContract
{
    public function store_user(RegisterDTO $data): bool
    {
        try {
            $user           = new User;
            $user->name     = $data->name;
            $user->email    = $data->email;
            $user->password = bcrypt($data->password);
            $user->telegram_id = $data->telegram_id;
            $user->is_logged_in = true;
            $user->save();

            $this->store_wallets($user->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new StoreUserException('An error has occurred', 500);
        }

        return true;
    }

    public function check_credentials(LoginDTO $data): bool
    {
        if (Auth::guard('web')->validate(['email' => $data->email, 'password' => $data->password])) {
            return true;
        } else {
            throw new LoginException('Incorrect email or password', 401);
        }
    }

    public function change_login_status(LoginDTO $data): bool
    {
        /** @var User $user */
        $user = User::query()->where('telegram_id', $data->telegram_id)->first();

        if (!$user) {
            throw new FindUserException('User not found', 404);
        }

        try {
            $user->is_logged_in = true;
            $user->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new ChangeLoginStatusException('Error', 500);
        }

        return true;
    }

    public function check_telegram_id(LoginDTO $data):bool
    {
        /** @var User $user */
        $user = User::query()->where('email', $data->email)->first();

        if (!$user) {
            throw new FindUserException('User not found', 404);
        }

        if ($user->telegram_id !== $data->telegram_id) {
            throw new LoginTelegramIdException('Telegram ID is incorrect', 401);
        }

        return true;
    }

    public function check_auth(TelegramIdDTO $data): bool
    {
        /** @var User $user */
        $user = User::query()->where('telegram_id', $data->telegram_id)->first();

        if (!$user) {
            throw new FindUserException('User not found', 404);
        }

        if (!$user->is_logged_in) {
            throw new CheckAuthException('User is not logged in', 403);
        }

        return true;
    }

    public function logout(TelegramIdDTO $data): bool
    {
        /** @var User $user */
        $user = User::query()->where('telegram_id', $data->telegram_id)->first();

        if (!$user) {
            throw new FindUserException('User not found', 404);
        }

        if (!$user->is_logged_in) {
            throw new LogoutException('User is not logged in', 403);
        }

        $user->is_logged_in = false;

        return $user->save();
    }

    private function store_wallets(int $user_id): void
    {
        try {
            $btc_wallet          = new Wallet;
            $btc_wallet->user_id = $user_id;
            $btc_wallet->coin_id = 1;
            $btc_wallet->balance = 0;
            $btc_wallet->uuid = uuid_create();
            $btc_wallet->save();

            $eth_wallet          = new Wallet;
            $eth_wallet->user_id = $user_id;
            $eth_wallet->coin_id = 2;
            $eth_wallet->balance = 0;
            $eth_wallet->uuid = uuid_create();
            $eth_wallet->save();

            $sol_wallet          = new Wallet;
            $sol_wallet->user_id = $user_id;
            $sol_wallet->coin_id = 3;
            $sol_wallet->balance = 0;
            $sol_wallet->uuid = uuid_create();
            $sol_wallet->save();

            $bnb_wallet          = new Wallet;
            $bnb_wallet->user_id = $user_id;
            $bnb_wallet->coin_id = 4;
            $bnb_wallet->balance = 0;
            $bnb_wallet->uuid = uuid_create();
            $bnb_wallet->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new StoreUserException('An error has occurred', 500);
        }
    }
}

