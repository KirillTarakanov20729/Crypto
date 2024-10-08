<?php

namespace App\Http\Resources\API_Telegram;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'request_user' => new UserResource($this->requestUser),
            'response_user' => new UserResource($this->responseUser),
            'bid' => new BidResource($this->bid),
        ];
    }
}
