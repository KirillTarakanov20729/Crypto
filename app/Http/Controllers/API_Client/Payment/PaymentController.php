<?php

namespace App\Http\Controllers\API_Client\Payment;

use App\Contracts\API_Client\Payment\PaymentContract;
use App\DTO\API_Client\Payment\IndexDTO;
use App\Exceptions\API_Client\Payment\DeletePaymentException;
use App\Exceptions\API_Client\Payment\FindPaymentException;
use App\Exceptions\API_Client\Payment\IndexPaymentException;
use App\Http\Controllers\Controller;
use App\Http\Resources\API_Client\PaymentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaymentController extends Controller
{
    private PaymentContract $service;

    public function __construct(PaymentContract $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexDTO($request->all());

        try {
            $payments = $this->service->index($data);
        } catch (IndexPaymentException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return PaymentResource::collection($payments);
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);
        } catch (DeletePaymentException|FindPaymentException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully deleted'], 200);
    }
}
