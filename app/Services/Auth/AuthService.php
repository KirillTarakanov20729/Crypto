<?php

namespace App\Services\Auth;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
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
}
