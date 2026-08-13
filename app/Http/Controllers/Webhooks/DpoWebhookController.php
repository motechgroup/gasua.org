<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Services\Payments\PaymentManagerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DpoWebhookController extends Controller
{
    public function __invoke(Request $request, PaymentManagerService $paymentManager): JsonResponse
    {
        $payload = $request->all();
        $result = $paymentManager->handleWebhook('dpo', $payload);

        return response()->json($result);
    }
}
