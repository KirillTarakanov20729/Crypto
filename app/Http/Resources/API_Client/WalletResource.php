<?php

namespace App\Http\Resources\API_Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'user_id' => $this->user_id,
            'coin' => new CoinResource($this->coin),
            'balance' => $this->balance,
        ];
    }
}
