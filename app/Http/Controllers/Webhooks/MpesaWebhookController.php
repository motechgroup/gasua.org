<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Services\Payments\PaymentManagerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MpesaWebhookController extends Controller
{
    public function __invoke(Request $request, PaymentManagerService $paymentManager): JsonResponse
    {
        $payload = $request->all();
        $headers = $request->headers->all();

        $result = $paymentManager->handleWebhook('mpesa', $payload, $headers);

        return response()->json([
            'ResultCode' => 0,
            'ResultDesc' => 'Accepted',
        ]);
    }
}
