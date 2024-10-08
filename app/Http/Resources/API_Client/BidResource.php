<?php

namespace App\Http\Resources\API_Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BidResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user' => new UserResource($this->user),
            'coin' => new CoinResource($this->coin),
            'currency' => new CurrencyResource($this->currency),
            'price' => $this->price,
            'amount' => $this->amount,
            'status' => $this->status,
            'type' => $this->type,
            'number' => $this->number,
            'payment_method' => $this->payment_method,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
