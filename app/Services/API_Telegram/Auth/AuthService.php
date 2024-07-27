<?php

namespace App\Services\API_Telegram\Auth;

use App\DTO\API_Telegram\Auth\LoginDTO;
use App\DTO\API_Telegram\Auth\RegisterDTO;
use App\DTO\API_Telegram\Auth\TelegramIdDTO;
use App\Exceptions\Auth\API_Telegram\ChangeLoginStatusException;
use App\Exceptions\Auth\API_Telegram\CheckAuthException;
use App\Exceptions\Auth\API_Telegram\FindUserException;
use App\Exceptions\Auth\API_Telegram\LoginException;
use App\Exceptions\Auth\API_Telegram\LoginTelegramIdException;
use App\Exceptions\Auth\API_Telegram\LogoutException;
use App\Exceptions\Auth\API_Telegram\StoreUserException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService
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
            return $user->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new StoreUserException('An error has occurred', 500);
        }
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
            throw new FindUserException('User not found');
        }

        if (!$user->is_logged_in) {
            throw new LogoutException('User is not logged in');
        }

        $user->is_logged_in = false;

        return $user->save();
    }
}

