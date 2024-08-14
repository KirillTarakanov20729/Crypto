<?php

namespace App\Http\Requests\API_Telegram\Bid\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResponseBidRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uuid' => ['required', 'string', 'exists:bids,uuid'],
            'user_telegram_id' => ['required', 'string', 'exists:users,telegram_id'],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
    }
}
