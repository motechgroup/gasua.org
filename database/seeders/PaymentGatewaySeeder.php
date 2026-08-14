<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    public function run(): void
    {
        $gateways = [
            [
                'code' => 'mpesa',
                'name' => 'Safaricom M-Pesa (Daraja API)',
                'is_enabled' => true,
                'is_test_mode' => true,
                'is_default' => true,
                'fee_percentage' => 0.00,
                'instructions' => 'Enter your Safaricom M-Pesa phone number (e.g. 2547XXXXXXXX) to receive an STK Push prompt on your handset.',
                'credentials' => [
                    'consumer_key' => 'DEMO_MPESA_CONSUMER_KEY',
                    'consumer_secret' => 'DEMO_MPESA_CONSUMER_SECRET',
                    'passkey' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
                    'shortcode' => '174379',
                    'headdb_type' => 'paybill', // paybill or till
                ],
            ],
            [
                'code' => 'flutterwave',
                'name' => 'Flutterwave (Cards & Mobile Money)',
                'is_enabled' => true,
                'is_test_mode' => true,
                'is_default' => false,
                'fee_percentage' => 1.50,
                'instructions' => 'Pay via Visa, Mastercard, Airtel Money, MTN Mobile Money or Bank Transfer.',
                'credentials' => [
                    'public_key' => 'FLWPUBK_TEST-DEMO_KEY-X',
                    'secret_key' => 'FLWSECK_TEST-DEMO_KEY-X',
                    'encryption_key' => 'FLWSECK_TEST12345678',
                    'secret_hash' => 'gasua_flw_secret_hash_998',
                ],
            ],
            [
                'code' => 'dpo',
                'name' => 'DPO Pay (Direct Pay Africa)',
                'is_enabled' => true,
                'is_test_mode' => true,
                'is_default' => false,
                'fee_percentage' => 2.00,
                'instructions' => 'East Africa regional card and mobile wallet checkout portal.',
                'credentials' => [
                    'company_token' => 'DEMO_DPO_COMPANY_TOKEN',
                    'service_type' => '3854', // Standard Charity Service Type
                ],
            ],
            [
                'code' => 'paypal',
                'name' => 'PayPal Worldwide',
                'is_enabled' => true,
                'is_test_mode' => true,
                'is_default' => false,
                'fee_percentage' => 3.50,
                'instructions' => 'Donate securely using your PayPal account or Debit/Credit card globally.',
                'credentials' => [
                    'client_id' => 'DEMO_PAYPAL_CLIENT_ID',
                    'client_secret' => 'DEMO_PAYPAL_CLIENT_SECRET',
                ],
            ],
            [
                'code' => 'nowpayments',
                'name' => 'NOWPayments (Cryptocurrency)',
                'is_enabled' => true,
                'is_test_mode' => true,
                'is_default' => false,
                'fee_percentage' => 0.50,
                'instructions' => 'Donate using Bitcoin (BTC), Ethereum (ETH), USDT, USDC, Solana (SOL) & 300+ cryptocurrencies.',
                'credentials' => [
                    'api_key' => 'DEMO_NOWPAYMENTS_API_KEY',
                    'ipn_secret' => 'DEMO_NOWPAYMENTS_IPN_SECRET',
                ],
            ],
            [
                'code' => 'stripe',
                'name' => 'Stripe Credit/Debit Cards',
                'is_enabled' => true,
                'is_test_mode' => true,
                'is_default' => false,
                'fee_percentage' => 2.90,
                'instructions' => 'Donate securely using Visa, Mastercard, American Express, Apple Pay, and Google Pay via Stripe.',
                'credentials' => [
                    'public_key' => 'pk_test_DEMO_STRIPE_PUBLIC_KEY',
                    'secret_key' => 'sk_test_DEMO_STRIPE_SECRET_KEY',
                    'webhook_secret' => 'whsec_DEMO_STRIPE_WEBHOOK_SECRET',
                ],
            ],
        ];

        foreach ($gateways as $gw) {
            PaymentGateway::updateOrCreate(['code' => $gw['code']], $gw);
        }
    }
}
