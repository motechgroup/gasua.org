<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Services\Payments\PaymentManagerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaystackWebhookController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $payload = $request->all();
        $headers = $request->headers->all();

        $paymentManager = app(PaymentManagerService::class);
        $result = $paymentManager->handleWebhook('paystack', $payload, $headers);

        if ($result['success']) {
            return response()->json(['status' => 'success', 'message' => 'Paystack Webhook Processed'], 200);
        }

        return response()->json(['status' => 'error', 'message' => $result['message'] ?? 'Paystack Webhook Failed'], 400);
    }
}
