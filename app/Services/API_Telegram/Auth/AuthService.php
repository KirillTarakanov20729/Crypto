<?php

namespace App\Services\API_Telegram\Auth;

use App\DTO\API_Telegram\Auth\LoginDTO;
use App\DTO\API_Telegram\Auth\RegisterDTO;
use App\DTO\API_Telegram\Auth\TelegramIdDTO;
use App\Exceptions\Auth\CheckAuthException;
use App\Exceptions\Auth\LoginTelegramIdException;
use App\Exceptions\Auth\LogoutException;
use App\Exceptions\Auth\StoreUserException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public function store_user(RegisterDTO $data): void
    {
        try {
            $user           = new User;
            $user->name     = $data->name;
            $user->email    = $data->email;
            $user->password = bcrypt($data->password);
            $user->telegram_id = $data->telegram_id;
            $user->is_logged_in = true;
            $user->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new StoreUserException($e->getMessage());
        }
    }

    public function login(LoginDTO $data): bool
    {
        if (Auth::attempt(['email' => $data->email, 'password' => $data->password])) {

            return true;
        } else {
            return false;
        }
    }

    public function change_login_status(TelegramIdDTO $data): bool
    {
        /** @var User $user */
        $user = User::query()->where('telegram_id', $data->telegram_id)->first();

        if (!$user) {
            throw new LoginTelegramIdException('User not found');
        }

        $user->is_logged_in = !$user->is_logged_in;
        return $user->save();
    }

    public function check_telegram_id(LoginDTO $data):bool
    {
        /** @var User $user */
        $user = User::query()->where('email', $data->email)->first();

        if ($user->telegram_id == $data->telegram_id) {
            return true;
        } else {
            return throw new LoginTelegramIdException('Неверный Telegram ID');
        }
    }

    public function check_auth(TelegramIdDTO $data): bool
    {
        /** @var User $user */
        $user = User::query()->where('telegram_id', $data->telegram_id)->first();
        if (!$user) {
            throw new CheckAuthException('User not found');
        }
        return $user->is_logged_in;
    }

    public function logout(TelegramIdDTO $data): bool
    {
        /** @var User $user */
        $user = User::query()->where('telegram_id', $data->telegram_id)->first();

        if (!$user) {
            throw new LogoutException('User not found');
        }

        if (!$user->is_logged_in) {
            throw new LogoutException('User is not logged in');
        }

        $user->is_logged_in = false;
        return $user->save();
    }
}

