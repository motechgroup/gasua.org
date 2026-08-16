<?php

namespace App\Services\Payments;

use App\Models\Donation;
use App\Models\PaymentGateway;
use App\Models\PaymentLog;
use App\Models\WebhookLog;
use App\Services\Payments\Contracts\PaymentGatewayInterface;
use App\Services\Payments\Drivers\MpesaGatewayService;
use App\Services\Payments\Drivers\PaystackGatewayService;
use App\Services\Payments\Drivers\FlutterwaveGatewayService;
use App\Services\Payments\Drivers\DpoGatewayService;
use App\Services\Payments\Drivers\PaypalGatewayService;
use App\Services\Payments\Drivers\NowpaymentsGatewayService;
use App\Services\Payments\Drivers\StripeGatewayService;
use App\Services\DonationService;
use Illuminate\Support\Facades\Log;

class PaymentManagerService
{
    /**
     * Resolve driver by code
     */
    public function driver(string $code): PaymentGatewayInterface
    {
        $gateway = PaymentGateway::where('code', $code)->first();

        return match ($code) {
            'mpesa' => new MpesaGatewayService($gateway),
            'paystack' => new PaystackGatewayService($gateway),
            'flutterwave' => new FlutterwaveGatewayService($gateway),
            'dpo' => new DpoGatewayService($gateway),
            'paypal' => new PaypalGatewayService($gateway),
            'nowpayments' => new NowpaymentsGatewayService($gateway),
            'stripe' => new StripeGatewayService(),
            default => throw new \InvalidArgumentException("Unsupported payment gateway code: {$code}"),
        };
    }

    /**
     * Initiate payment for donation
     */
    public function initiate(Donation $donation, array $extraInput = []): array
    {
        $driver = $this->driver($donation->gateway_code);
        $result = $driver->initiatePayment($donation, $extraInput);

        if (!empty($result['payment_reference'])) {
            $donation->update([
                'payment_reference' => $result['payment_reference'],
                'payment_status' => $result['status'] ?? 'pending',
            ]);
        }

        // Record log
        PaymentLog::create([
            'donation_id' => $donation->id,
            'gateway_code' => $donation->gateway_code,
            'request_payload' => $extraInput,
            'response_payload' => $result['raw_response'] ?? [],
            'ip_address' => request()->ip(),
            'status' => $result['success'] ? 'initiated' : 'failed',
        ]);

        return $result;
    }

    /**
     * Process completed payment
     */
    public function markAsCompleted(Donation $donation, ?string $reference = null, ?string $receiptNo = null): void
    {
        if ($donation->payment_status === 'completed') {
            return;
        }

        $donationService = app(DonationService::class);
        $donationService->finalizeDonation($donation, $reference, $receiptNo);
    }

    /**
     * Handle webhook for gateway
     */
    public function handleWebhook(string $gatewayCode, array $payload, array $headers = []): array
    {
        $log = WebhookLog::create([
            'gateway_code' => $gatewayCode,
            'event_type' => $payload['event'] ?? $payload['event_type'] ?? 'ipn',
            'payload' => $payload,
            'status' => 'processed',
        ]);

        try {
            $driver = $this->driver($gatewayCode);
            $result = $driver->handleWebhook($payload, $headers);

            if ($result['success'] && !empty($result['payment_reference'])) {
                $donation = Donation::where('payment_reference', $result['payment_reference'])
                    ->orWhere('transaction_reference', $result['payment_reference'])
                    ->first();

                if ($donation) {
                    $this->markAsCompleted($donation, $result['mpesa_receipt'] ?? $result['flw_ref'] ?? $result['payment_reference']);
                }
            }

            return $result;
        } catch (\Exception $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            Log::error("Webhook error for {$gatewayCode}: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
