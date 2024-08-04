<?php

namespace App\Http\Requests\API_Client\Bid;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'page' => ['required', 'integer', 'min:1', 'max:500'],
            'coin_id' => ['nullable', 'integer', 'min:1', 'exists:coins,id'],
            'user_email' => ['nullable', 'string'],
            'currency_id' => ['nullable', 'integer', 'min:1', 'exists:currencies,id'],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
    }
}
