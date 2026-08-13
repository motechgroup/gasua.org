<?php

namespace App\Services\Payments\Contracts;

use App\Models\Donation;

interface PaymentGatewayInterface
{
    /**
     * Get unique code identifier for the gateway (e.g. 'mpesa', 'flutterwave')
     */
    public function getCode(): string;

    /**
     * Get display name for the gateway
     */
    public function getName(): string;

    /**
     * Initiate a payment transaction for a donation
     * Returns array containing: [
     *    'success' => bool,
     *    'status' => 'pending'|'completed'|'failed',
     *    'payment_reference' => string,
     *    'redirect_url' => string|null,
     *    'instructions' => string|null,
     *    'raw_response' => array
     * ]
     */
    public function initiatePayment(Donation $donation, array $extraInput = []): array;

    /**
     * Manually check/verify payment status by transaction reference
     */
    public function verifyPayment(string $paymentReference): array;

    /**
     * Handle incoming asynchronous webhook/IPN callback
     */
    public function handleWebhook(array $payload, array $headers = []): array;
}
