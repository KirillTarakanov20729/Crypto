<?php

namespace App\Http\Requests\API_Telegram\Bid;

use Illuminate\Foundation\Http\FormRequest;

class AskBidRequest extends FormRequest
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
}
