<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Services\Payments\PaymentManagerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FlutterwaveWebhookController extends Controller
{
    public function __invoke(Request $request, PaymentManagerService $paymentManager): JsonResponse
    {
        $payload = $request->all();
        $headers = [
            'verif-hash' => $request->header('verif-hash'),
        ];

        $result = $paymentManager->handleWebhook('flutterwave', $payload, $headers);

        return response()->json($result);
    }
}
