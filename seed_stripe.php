<?php

// Standalone Direct Stripe Gateway Inserter
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<html><head><title>Stripe Gateway Inserter</title>";
echo "<style>body{font-family:sans-serif;padding:30px;background:#0f172a;color:#f8fafc;} h1{color:#10b981;} a{color:#38bdf8;font-weight:bold;} .card{background:#1e293b;padding:25px;border-radius:16px;max-w:600px;margin:40px auto;box-shadow:0 20px 25px -5px rgba(0,0,0,0.5);}</style>";
echo "</head><body><div class='card'>";

try {
    require __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';

    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    \App\Models\PaymentGateway::updateOrCreate(
        ['code' => 'stripe'],
        [
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
        ]
    );

    echo "<h1>🎉 Success! Stripe Gateway Active!</h1>";
    echo "<p>Stripe Credit/Debit Card gateway has been inserted into your database.</p>";
    echo "<p><a href='/admin/gateways'>👉 Open Admin Payment Gateways Manager</a></p>";
} catch (\Throwable $e) {
    echo "<h1 style='color:#ef4444;'>❌ Error Inserting Gateway</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "</div></body></html>";
