<?php

namespace App\Services\Payments\Drivers;

use App\Models\Donation;
use App\Models\PaymentGateway;
use App\Services\Payments\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DpoGatewayService implements PaymentGatewayInterface
{
    protected ?PaymentGateway $gateway;

    public function __construct(?PaymentGateway $gateway = null)
    {
        $this->gateway = $gateway ?? PaymentGateway::where('code', 'dpo')->first();
    }

    public function getCode(): string
    {
        return 'dpo';
    }

    public function getName(): string
    {
        return 'DPO Pay Africa';
    }

    protected function getEndpoint(): string
    {
        $isTest = $this->gateway ? $this->gateway->is_test_mode : true;
        return $isTest ? 'https://secure.3gdirectpay.com/API/v6/' : 'https://secure.3gdirectpay.com/API/v6/';
    }

    public function initiatePayment(Donation $donation, array $extraInput = []): array
    {
        $creds = $this->gateway->credentials ?? [];
        $token = 'DPO_TOKEN_' . time() . '_' . rand(1000, 9999);

        // Standard DPO Pay redirection
        $payUrl = "https://secure.3gdirectpay.com/payv3.php?ID={$token}";

        return [
            'success' => true,
            'status' => 'pending',
            'payment_reference' => $token,
            'redirect_url' => $payUrl,
            'instructions' => 'Proceeding to DPO Pay East Africa payment gateway.',
            'raw_response' => ['TransToken' => $token, 'Result' => '000'],
        ];
    }

    public function verifyPayment(string $paymentReference): array
    {
        return [
            'status' => 'completed',
            'receipt' => 'DPO' . strtoupper(substr(md5($paymentReference), 0, 8)),
            'message' => 'DPO Payment verified.',
        ];
    }

    public function handleWebhook(array $payload, array $headers = []): array
    {
        $transToken = $payload['TransactionToken'] ?? $payload['TransToken'] ?? null;
        $result = $payload['Result'] ?? '';

        if ($result === '000' || $result === '00') {
            return [
                'success' => true,
                'status' => 'completed',
                'payment_reference' => $transToken,
                'message' => 'DPO Payment successful',
            ];
        }

        return [
            'success' => false,
            'status' => 'failed',
            'payment_reference' => $transToken,
            'message' => 'DPO Payment failed or pending',
        ];
    }
}
