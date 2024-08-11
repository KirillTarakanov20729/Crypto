<?php

namespace App\Http\Requests\API_Telegram\Bid;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ShowBidRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uuid' => ['required', 'string', 'exists:bids,uuid'],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
    }
}
