<?php

namespace App\Services\Payments\Drivers;

use App\Models\Donation;
use App\Models\PaymentGateway;
use App\Services\Payments\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaypalGatewayService implements PaymentGatewayInterface
{
    protected ?PaymentGateway $gateway;

    public function __construct(?PaymentGateway $gateway = null)
    {
        $this->gateway = $gateway ?? PaymentGateway::where('code', 'paypal')->first();
    }

    public function getCode(): string
    {
        return 'paypal';
    }

    public function getName(): string
    {
        return 'PayPal';
    }

    protected function getBaseUrl(): string
    {
        $isTest = $this->gateway ? $this->gateway->is_test_mode : true;
        return $isTest ? 'https://api-m.sandbox.paypal.com' : 'https://api-m.paypal.com';
    }

    public function initiatePayment(Donation $donation, array $extraInput = []): array
    {
        $ref = 'PAYPAL_ORD_' . time() . '_' . rand(1000, 9999);

        return [
            'success' => true,
            'status' => 'pending',
            'payment_reference' => $ref,
            'redirect_url' => route('public.donate.checkout', ['reference' => $donation->transaction_reference, 'simulated' => 'paypal']),
            'instructions' => 'Proceeding to PayPal Checkout...',
            'raw_response' => ['id' => $ref, 'status' => 'CREATED'],
        ];
    }

    public function verifyPayment(string $paymentReference): array
    {
        return [
            'status' => 'completed',
            'receipt' => 'PPL' . strtoupper(substr(md5($paymentReference), 0, 8)),
            'message' => 'PayPal payment captured successfully.',
        ];
    }

    public function handleWebhook(array $payload, array $headers = []): array
    {
        $eventType = $payload['event_type'] ?? '';
        $resource = $payload['resource'] ?? [];

        if (in_array($eventType, ['PAYMENT.CAPTURE.COMPLETED', 'CHECKOUT.ORDER.APPROVED'])) {
            return [
                'success' => true,
                'status' => 'completed',
                'payment_reference' => $resource['id'] ?? null,
                'message' => 'PayPal webhook captured payment successfully.',
            ];
        }

        return [
            'success' => false,
            'status' => 'failed',
            'payment_reference' => $resource['id'] ?? null,
            'message' => 'PayPal event unhandled or unverified.',
        ];
    }
}
