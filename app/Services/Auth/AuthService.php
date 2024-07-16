<?php

namespace App\Services\Auth;

use App\Models\User;

class AuthService
{
    public function store_user(array $data): void
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->save();
    }
}
