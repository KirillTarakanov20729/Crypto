<?php

namespace App\Http\Resources\API_Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'request_user' => new UserResource($this->requestUser),
            'response_user' => new UserResource($this->responseUser),
            'bid' => new BidResource($this->bid),
        ];
    }
}
