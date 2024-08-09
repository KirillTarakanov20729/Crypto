<?php

namespace App\Contracts\API_Telegram\Auth;

use App\DTO\API_Telegram\Auth\LoginDTO;
use App\DTO\API_Telegram\Auth\RegisterDTO;
use App\DTO\API_Telegram\Auth\TelegramIdDTO;

interface AuthContract
{
    public function store_user(RegisterDTO $data): bool;

    public function check_credentials(LoginDTO $data): bool;

    public function change_login_status(LoginDTO $data): bool;

    public function check_telegram_id(LoginDTO $data):bool;

    public function check_auth(TelegramIdDTO $data): bool;

    public function logout(TelegramIdDTO $data): bool;
}
