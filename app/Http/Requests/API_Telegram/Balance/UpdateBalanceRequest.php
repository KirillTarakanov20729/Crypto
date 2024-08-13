<?php

namespace App\Http\Requests\API_Telegram\Balance;

use App\Enums\API_Client\Bid\BidTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBalanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_telegram_id' => ['required', 'string', 'exists:users,telegram_id'],
            'coin_symbol' => ['required', 'string', 'exists:coins,symbol'],
            'amount' => ['required', 'string'],
            'type' => ['required', 'string', 'in:add,sub'],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
    }
}
