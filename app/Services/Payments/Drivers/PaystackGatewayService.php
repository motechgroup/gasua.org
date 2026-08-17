<?php

namespace App\Services\Payments\Drivers;

use App\Models\Donation;
use App\Models\PaymentGateway;
use App\Services\Payments\Contracts\PaymentGatewayInterface;
use App\Services\Payments\CallbackUrlDetector;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackGatewayService implements PaymentGatewayInterface
{
    protected ?PaymentGateway $gateway;

    public function __construct(?PaymentGateway $gateway = null)
    {
        $this->gateway = $gateway ?? PaymentGateway::where('code', 'paystack')->first();
    }

    public function getCode(): string
    {
        return 'paystack';
    }

    public function getName(): string
    {
        return 'Paystack (Cards, M-Pesa, Bank Transfer, Apple Pay)';
    }

    public function initiatePayment(Donation $donation, array $extraInput = []): array
    {
        $creds = $this->gateway->credentials ?? [];
        $secretKey = trim($creds['secret_key'] ?? config('services.paystack.secret_key', ''));

        $ref = $donation->transaction_reference;
        $currency = strtoupper($donation->currency ?? 'KES');

        // Subunit calculation: Paystack requires amount in smallest currency unit (cents/kobo * 100)
        $amountInSubunits = (int) round($donation->amount * 100);

        // If secret key is empty or set to placeholder DEMO
        if (empty($secretKey) || str_contains($secretKey, 'DEMO')) {
            return [
                'success' => false,
                'status' => 'failed',
                'payment_reference' => null,
                'instructions' => 'Paystack API Secret Key is not configured. Please enter your valid Paystack Secret Key in Admin Dashboard -> Payment Gateways.',
                'raw_response' => [],
            ];
        }

        $callbackUrl = CallbackUrlDetector::getReturnUrl('public.donate.checkout', ['reference' => $ref]);

        $payload = [
            'email' => !empty($donation->donor_email) ? $donation->donor_email : 'donor@gusiiallstars.org',
            'amount' => $amountInSubunits,
            'currency' => $currency,
            'reference' => $ref,
            'callback_url' => $callbackUrl,
            'metadata' => [
                'donation_id' => $donation->id,
                'donor_name' => $donation->donor_name,
                'donor_phone' => $donation->donor_phone,
                'campaign_id' => $donation->campaign_id,
                'custom_fields' => [
                    [
                        'display_name' => 'Foundation Campaign',
                        'variable_name' => 'campaign',
                        'value' => $donation->campaign->title ?? 'General Foundation Fund',
                    ]
                ]
            ],
        ];

        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $secretKey,
                    'Content-Type' => 'application/json',
                    'Cache-Control' => 'no-cache',
                ])
                ->post('https://api.paystack.co/transaction/initialize', $payload);

            $json = $response->json();

            if ($response->successful() && ($json['status'] ?? false) === true) {
                $authUrl = $json['data']['authorization_url'] ?? null;
                $reference = $json['data']['reference'] ?? $ref;

                return [
                    'success' => true,
                    'status' => 'pending',
                    'payment_reference' => $reference,
                    'redirect_url' => $authUrl,
                    'instructions' => 'Redirecting to Paystack Secure Checkout...',
                    'raw_response' => $json,
                ];
            }

            $errMsg = $json['message'] ?? 'Failed to initialize Paystack checkout session.';
            Log::error('Paystack Initialize API Error: ' . json_encode($json));

            return [
                'success' => false,
                'status' => 'failed',
                'payment_reference' => null,
                'instructions' => 'Paystack Error: ' . $errMsg . ' Please check your Paystack API Secret Key in Admin -> Payment Gateways.',
                'raw_response' => $json ?? [],
            ];
        } catch (\Exception $e) {
            Log::error('Paystack Driver Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'status' => 'failed',
                'payment_reference' => null,
                'instructions' => 'Paystack Connection Error: ' . $e->getMessage(),
                'raw_response' => ['error' => $e->getMessage()],
            ];
        }
    }

    public function verifyPayment(string $paymentReference): array
    {
        $creds = $this->gateway->credentials ?? [];
        $secretKey = trim($creds['secret_key'] ?? config('services.paystack.secret_key', ''));

        if (empty($secretKey) || str_contains($secretKey, 'DEMO')) {
            return [
                'status' => 'pending',
                'message' => 'Paystack API Secret Key not configured.',
            ];
        }

        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $secretKey,
                ])
                ->get("https://api.paystack.co/transaction/verify/" . rawurlencode($paymentReference));

            $json = $response->json();

            if ($response->successful() && ($json['status'] ?? false) === true && ($json['data']['status'] ?? '') === 'success') {
                return [
                    'status' => 'completed',
                    'receipt' => $json['data']['reference'] ?? $paymentReference,
                    'message' => 'Paystack payment verified successfully.',
                ];
            }
        } catch (\Exception $e) {
            Log::error('Paystack Verify Exception: ' . $e->getMessage());
        }

        return ['status' => 'pending', 'message' => 'Paystack payment verification pending.'];
    }

    public function handleWebhook(array $payload, array $headers = []): array
    {
        $creds = $this->gateway->credentials ?? [];
        $secretKey = trim($creds['secret_key'] ?? config('services.paystack.secret_key', ''));

        // Verify webhook signature header if provided
        $signature = $headers['x-paystack-signature'][0] ?? $headers['x-paystack-signature'] ?? null;
        if ($signature && !empty($secretKey) && !str_contains($secretKey, 'DEMO')) {
            $input = file_get_contents('php://input') ?: json_encode($payload);
            $computed = hash_hmac('sha512', $input, $secretKey);
            if (!hash_equals((string)$computed, (string)$signature)) {
                return ['success' => false, 'message' => 'Invalid Paystack webhook signature header'];
            }
        }

        $event = $payload['event'] ?? '';
        $data = $payload['data'] ?? [];
        $reference = $data['reference'] ?? null;

        if ($event === 'charge.success' && ($data['status'] ?? '') === 'success') {
            return [
                'success' => true,
                'status' => 'completed',
                'payment_reference' => $reference,
                'message' => 'Paystack charge.success webhook processed.',
            ];
        }

        return [
            'success' => false,
            'status' => 'failed',
            'payment_reference' => $reference,
            'message' => 'Unhandled Paystack event or non-successful charge status.',
        ];
    }
}
