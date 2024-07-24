<?php

namespace App\Http\Requests\API_Telegram\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CheckAuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'telegram_id' => ['required', 'string', 'max:255'],
        ];
    }
}
