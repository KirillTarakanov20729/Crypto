<?php

namespace App\Http\Requests\API_Client\Coin;

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
            'symbol' => ['required', 'string', 'min:2' ,'max:5', 'unique:coins,symbol'],
            'price' => ['required', 'numeric', 'min:0.01', 'max:99999.99'],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
    }
}
