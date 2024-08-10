<?php

namespace App\Http\Requests\API_Telegram\Bid;

use App\Enums\API_Client\Bid\BidPaymentMethodEnum;
use App\Enums\API_Client\Bid\BidTypeEnum;
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
            'amount' => ['required', 'integer', 'min:1', 'max:100000000'],
            'price' => ['required', 'integer', 'min:1', 'max:100000000'],
            'coin_id' => ['required', 'integer', 'exists:coins,id'],
            'user_telegram_id' => ['required', 'string', 'exists:users,telegram_id'],
            'currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'type' => ['required', 'string', 'in:' . implode(',', BidTypeEnum::getValues())],
            'payment_method' => ['required', 'string', 'in:' . implode(',', BidPaymentMethodEnum::getValues())],
            'number' => ['required', 'string'],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
    }
}
