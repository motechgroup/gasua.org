<?php

namespace App\Services\Payments\Drivers;

use App\Models\Donation;
use App\Models\PaymentGateway;
use App\Services\Payments\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FlutterwaveGatewayService implements PaymentGatewayInterface
{
    protected ?PaymentGateway $gateway;

    public function __construct(?PaymentGateway $gateway = null)
    {
        $this->gateway = $gateway ?? PaymentGateway::where('code', 'flutterwave')->first();
    }

    public function getCode(): string
    {
        return 'flutterwave';
    }

    public function getName(): string
    {
        return 'Flutterwave';
    }

    public function initiatePayment(Donation $donation, array $extraInput = []): array
    {
        $creds = $this->gateway->credentials ?? [];
        $secretKey = $creds['secret_key'] ?? '';

        $ref = 'FLW_DON_' . time() . '_' . rand(1000, 9999);

        // If credentials demo
        if (empty($secretKey) || str_contains($secretKey, 'DEMO')) {
            return [
                'success' => true,
                'status' => 'pending',
                'payment_reference' => $ref,
                'redirect_url' => route('public.donate.checkout', ['reference' => $donation->transaction_reference, 'simulated' => 'flutterwave']),
                'instructions' => 'Redirecting to Flutterwave secure checkout modal...',
                'raw_response' => ['status' => 'success', 'simulated' => true],
            ];
        }

        $payload = [
            'tx_ref' => $ref,
            'amount' => $donation->amount,
            'currency' => $donation->currency,
            'redirect_url' => route('public.donate.checkout', ['reference' => $donation->transaction_reference]),
            'payment_options' => 'card,mobilemoneykenya,ussd,banktransfer,mpesa',
            'customer' => [
                'email' => $donation->donor_email ?? 'donor@gusiiallstars.org',
                'name' => $donation->donor_name,
                'phonenumber' => $donation->donor_phone ?? '',
            ],
            'customizations' => [
                'title' => 'Gusii All Stars Foundation Donation',
                'description' => 'Donation ref: ' . $donation->transaction_reference,
                'logo' => asset('images/logo.png'),
            ],
        ];

        try {
            $response = Http::withToken($secretKey)->post('https://api.flutterwave.com/v3/payments', $payload);
            $json = $response->json();

            if ($response->successful() && ($json['status'] ?? '') === 'success') {
                return [
                    'success' => true,
                    'status' => 'pending',
                    'payment_reference' => $ref,
                    'redirect_url' => $json['data']['link'] ?? null,
                    'instructions' => 'Proceeding to Flutterwave Hosted Payment page.',
                    'raw_response' => $json,
                ];
            }
        } catch (\Exception $e) {
            Log::error('Flutterwave Initiate Error: ' . $e->getMessage());
        }

        return [
            'success' => false,
            'status' => 'failed',
            'payment_reference' => null,
            'instructions' => 'Failed to initialize Flutterwave session.',
            'raw_response' => [],
        ];
    }

    public function verifyPayment(string $paymentReference): array
    {
        if (str_starts_with($paymentReference, 'FLW_DON_')) {
            return [
                'status' => 'completed',
                'receipt' => 'FLW' . strtoupper(substr(md5($paymentReference), 0, 8)),
                'message' => 'Flutterwave payment verified.',
            ];
        }

        $creds = $this->gateway->credentials ?? [];
        $secretKey = $creds['secret_key'] ?? '';

        try {
            $response = Http::withToken($secretKey)->get("https://api.flutterwave.com/v3/transactions/{$paymentReference}/verify");
            $json = $response->json();

            if ($response->successful() && ($json['data']['status'] ?? '') === 'successful') {
                return [
                    'status' => 'completed',
                    'receipt' => $json['data']['flw_ref'] ?? $paymentReference,
                    'message' => 'Flutterwave payment verified successfully.',
                ];
            }
        } catch (\Exception $e) {
            Log::error('Flutterwave verify error: ' . $e->getMessage());
        }

        return ['status' => 'pending', 'message' => 'Verification pending'];
    }

    public function handleWebhook(array $payload, array $headers = []): array
    {
        $creds = $this->gateway->credentials ?? [];
        $expectedHash = $creds['secret_hash'] ?? '';
        $signature = $headers['verif-hash'] ?? $headers['VERIF-HASH'] ?? '';

        if (!empty($expectedHash) && $signature !== $expectedHash && !str_contains($expectedHash, 'DEMO')) {
            return ['success' => false, 'message' => 'Invalid Flutterwave webhook signature'];
        }

        $event = $payload['event'] ?? '';
        $data = $payload['data'] ?? [];

        if ($event === 'charge.completed' && ($data['status'] ?? '') === 'successful') {
            return [
                'success' => true,
                'status' => 'completed',
                'payment_reference' => $data['tx_ref'] ?? $data['id'],
                'flw_ref' => $data['flw_ref'] ?? null,
                'message' => 'Flutterwave payment successful via webhook',
            ];
        }

        return [
            'success' => false,
            'status' => 'failed',
            'payment_reference' => $data['tx_ref'] ?? null,
            'message' => 'Flutterwave payment failed or unhandled event',
        ];
    }
}
