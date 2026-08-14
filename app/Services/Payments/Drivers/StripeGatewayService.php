<?php

namespace App\Services\Payments\Drivers;

use App\Models\Donation;
use App\Models\PaymentGateway;
use App\Services\Payments\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StripeGatewayService implements PaymentGatewayInterface
{
    protected ?PaymentGateway $gateway;
    protected string $secretKey;
    protected string $publicKey;
    protected string $webhookSecret;

    public function __construct(?PaymentGateway $gateway = null)
    {
        $this->gateway = $gateway ?? PaymentGateway::where('code', 'stripe')->first();
        $credentials = $this->gateway?->credentials ?? [];

        $this->secretKey = $credentials['secret_key'] ?? config('services.stripe.secret', '');
        $this->publicKey = $credentials['public_key'] ?? config('services.stripe.key', '');
        $this->webhookSecret = $credentials['webhook_secret'] ?? config('services.stripe.webhook_secret', '');
    }

    public function getCode(): string
    {
        return 'stripe';
    }

    public function getName(): string
    {
        return 'Stripe Credit/Debit Cards';
    }

    public function initiatePayment(Donation $donation, array $extraInput = []): array
    {
        try {
            $amountInCents = (int) round($donation->amount * 100);
            $currency = strtolower($donation->currency ?? 'usd');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->asForm()->post('https://api.stripe.com/v1/checkout/sessions', [
                'payment_method_types' => ['card'],
                'mode' => 'payment',
                'client_reference_id' => $donation->transaction_reference,
                'customer_email' => $donation->donor_email ?? null,
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $currency,
                            'unit_amount' => $amountInCents,
                            'product_data' => [
                                'name' => 'Donation to Gusii All Stars Foundation',
                                'description' => 'Reference: ' . $donation->transaction_reference,
                            ],
                        ],
                        'quantity' => 1,
                    ],
                ],
                'success_url' => route('public.donate.checkout') . '?reference=' . $donation->transaction_reference . '&status=success&session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('public.donate.checkout') . '?reference=' . $donation->transaction_reference . '&status=cancelled',
            ]);

            if ($response->successful()) {
                $session = $response->json();

                return [
                    'success' => true,
                    'status' => 'pending',
                    'redirect_url' => $session['url'] ?? null,
                    'payment_reference' => $session['id'] ?? null,
                    'instructions' => 'Redirecting to Stripe Secure Payment Gateway...',
                    'raw_response' => $session,
                ];
            }

            Log::error('Stripe Initiation Error: ' . $response->body());
            return [
                'success' => false,
                'status' => 'failed',
                'message' => 'Failed to initialize Stripe payment session.',
            ];
        } catch (\Exception $e) {
            Log::error('Stripe Driver Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'status' => 'failed',
                'message' => 'Stripe exception: ' . $e->getMessage(),
            ];
        }
    }

    public function verifyPayment(string $paymentReference): array
    {
        try {
            if (!$paymentReference) {
                return ['success' => false, 'message' => 'No Stripe Session ID provided.'];
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
            ])->get("https://api.stripe.com/v1/checkout/sessions/{$paymentReference}");

            if ($response->successful()) {
                $data = $response->json();
                $isPaid = ($data['payment_status'] ?? '') === 'paid';

                return [
                    'success' => $isPaid,
                    'status' => $isPaid ? 'completed' : 'pending',
                    'external_reference' => $data['id'] ?? null,
                ];
            }

            return ['success' => false, 'message' => 'Stripe session lookup failed.'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function handleWebhook(array $payload, array $headers = []): array
    {
        $event = $payload['type'] ?? '';
        $dataObject = $payload['data']['object'] ?? [];

        if (in_array($event, ['checkout.session.completed', 'payment_intent.succeeded'])) {
            $reference = $dataObject['client_reference_id'] ?? null;
            $externalRef = $dataObject['id'] ?? null;

            return [
                'success' => true,
                'status' => 'completed',
                'payment_reference' => $reference,
                'external_reference' => $externalRef,
            ];
        }

        return ['success' => false, 'message' => 'Unhandled Stripe event type: ' . $event];
    }
}
