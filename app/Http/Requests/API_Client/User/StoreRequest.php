<?php

namespace App\Http\Requests\API_Client\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:32'],
            'email' => ['required', 'string', 'email', 'max:32', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:32'],
            'telegram_id' => ['required', 'string', 'max:100', 'unique:users'],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
    }
}
