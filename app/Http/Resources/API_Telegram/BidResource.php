<?php

namespace App\Http\Resources\API_Telegram;

use App\Http\Resources\API_Client\CoinResource;
use App\Http\Resources\API_Client\CurrencyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BidResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user' => new UserResource($this->user),
            'coin' => new CoinResource($this->coin),
            'currency' => new CurrencyResource($this->currency),
            'amount' => $this->amount,
            'price' => $this->price,
            'status' => $this->status,
            'number' => $this->number,
            'type' => $this->type,
            'payment_method' => $this->payment_method,
            'created_at' => $this->created_at
        ];
    }
}
