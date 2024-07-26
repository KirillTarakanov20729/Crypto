<?php

namespace App\Services\API_Client\Auth;

use App\DTO\API_Client\Auth\LoginDTO;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(LoginDTO $data): bool
    {
        if (Auth::guard('admin')->attempt(['email' => $data->email, 'password' => $data->password])) {
            return true;
        } else {
            return false;
        }
    }
}
