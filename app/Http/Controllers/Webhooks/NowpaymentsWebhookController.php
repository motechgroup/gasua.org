<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Services\Payments\PaymentManagerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NowpaymentsWebhookController extends Controller
{
    public function __invoke(Request $request, PaymentManagerService $paymentManager): JsonResponse
    {
        $payload = $request->all();
        $headers = [
            'x-nowpayments-sig' => $request->header('x-nowpayments-sig'),
        ];

        $result = $paymentManager->handleWebhook('nowpayments', $payload, $headers);

        return response()->json($result);
    }
}
