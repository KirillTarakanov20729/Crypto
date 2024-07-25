<?php

namespace App\Http\Requests\API_Client\Coins;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'page' => ['nullable', 'integer'],
        ];
    }
}
