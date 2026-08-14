<?php

// Standalone Browser Migration & Seeder Runner for Shared Hosting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<html><head><title>Database Migration & Seeder Tool</title>";
echo "<style>body{font-family:sans-serif;padding:30px;background:#0f172a;color:#f8fafc;} h1{color:#10b981;} pre{background:#1e293b;padding:15px;border-radius:10px;overflow-x:auto;color:#38bdf8;} .card{background:#1e293b;padding:20px;border-radius:12px;margin-bottom:20px;}</style>";
echo "</head><body>";
echo "<h1>🚀 Gusii All Stars Foundation - Database Migration Tool</h1>";

// 1. Check Secret Key
$secret = $_GET['secret'] ?? '';
if ($secret !== 'gasua_deploy_token_99') {
    die("<p style='color:#ef4444;'>❌ Invalid or missing secret parameter. Access denied.</p>");
}

// 2. Load Composer Autoloader & Bootstrap Laravel Console Kernel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "<div class='card'><h2>1. Running Database Migrations...</h2>";
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo "<pre>" . htmlspecialchars(\Illuminate\Support\Facades\Artisan::output()) . "</pre>";
    echo "<p style='color:#10b981;'>✓ Migrations completed successfully!</p></div>";

    echo "<div class='card'><h2>2. Running Database Seeders...</h2>";
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
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
    echo "<pre>" . htmlspecialchars(\Illuminate\Support\Facades\Artisan::output()) . "</pre>";
    echo "<p style='color:#10b981;'>✓ Database Seeders & Stripe Gateway completed successfully!</p></div>";

    echo "<div class='card'><h2>3. Clearing & Refreshing Caches...</h2>";
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    echo "<p style='color:#10b981;'>✓ Caches refreshed!</p></div>";

    echo "<h2 style='color:#10b981;'>🎉 ALL DONE! You can now open <a href='/' style='color:#38bdf8;'>https://gasua.org</a></h2>";
} catch (\Throwable $e) {
    echo "<div class='card' style='border:1px solid #ef4444;'><h2 style='color:#ef4444;'>❌ Migration Exception</h2>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre></div>";
}

echo "</body></html>";
