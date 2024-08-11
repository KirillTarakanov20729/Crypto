<?php

namespace App\Http\Controllers\API_Telegram\Payment;

use App\Contracts\API_Telegram\Payment\PaymentContract;
use App\DTO\API_Telegram\Payment\ShowPaymentDTO;
use App\Exceptions\API_Telegram\Payment\ShowPaymentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API_Telegram\Payment\ShowPaymentRequest;
use App\Http\Resources\API_Telegram\PaymentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private PaymentContract $service;
    public function __construct(PaymentContract $service)
    {
        $this->service = $service;
    }

    public function show(ShowPaymentRequest $request): PaymentResource|JsonResponse
    {
        $data = new ShowPaymentDTO($request->validated());

        try {
            $payment = $this->service->show($data);
        } catch (ShowPaymentException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return new PaymentResource($payment);
    }
}
