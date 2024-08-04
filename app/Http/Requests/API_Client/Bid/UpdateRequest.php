<?php

namespace App\Http\Requests\API_Client\Bid;

use App\Enums\API_Client\Bid\BidPaymentMethodEnum;
use App\Enums\API_Client\Bid\BidStatusEnum;
use App\Enums\API_Client\Bid\BidTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer'],
            'amount' => ['required', 'integer', 'min:1', 'max:100000000'],
            'price' => ['required', 'integer', 'min:1', 'max:100000000'],
            'coin_id' => ['required', 'integer', 'exists:coins,id'],
            'user_telegram_id' => ['required', 'string', 'exists:users,telegram_id'],
            'currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'status' => ['required', 'string', 'in:' . implode(',', BidStatusEnum::getValues())],
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
