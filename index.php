<?php

// Enable error reporting for shared hosting diagnostics
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Check if vendor autoloader exists
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    die('
    <!DOCTYPE html>
    <html>
    <head><title>Gusii Foundation - Missing Dependencies</title></head>
    <body style="font-family:sans-serif;padding:40px;background:#0f172a;color:#f8fafc;">
        <div style="background:#1e293b;padding:30px;border-radius:16px;border:1px solid #334155;max-w:800px;margin:0 auto;">
            <h2 style="color:#ef4444;margin-top:0;">❌ Composer Vendor Dependencies Missing</h2>
            <p>The file <code>vendor/autoload.php</code> was not found in <code>' . htmlspecialchars(__DIR__) . '</code>.</p>
            <h3 style="color:#10b981;">How to Resolve on Shared Hosting:</h3>
            <ol style="line-height:1.8;color:#cbd5e1;">
                <li>Open <strong>cPanel Terminal</strong> and run: <br><code style="background:#0f172a;padding:4px 8px;border-radius:6px;color:#38bdf8;">composer install --optimize-autoloader --no-dev</code></li>
                <li>Or compress and upload your local <code>vendor/</code> folder to <code>/public_html/vendor/</code> using cPanel File Manager.</li>
            </ol>
        </div>
    </body>
    </html>
    ');
}

// 2. Check maintenance mode
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// 3. Register Composer Autoloader
require __DIR__.'/vendor/autoload.php';

// 4. Bootstrap Laravel Application
try {
    (require_once __DIR__.'/bootstrap/app.php')
        ->handleRequest(Request::capture());
} catch (\Throwable $e) {
    echo "
    <!DOCTYPE html>
    <html>
    <head><title>Gusii Foundation - Runtime Exception</title></head>
    <body style='font-family:sans-serif;padding:40px;background:#0f172a;color:#f8fafc;'>
        <div style='background:#1e293b;padding:30px;border-radius:16px;border:1px solid #ef4444;max-w:900px;margin:0 auto;'>
            <h2 style='color:#ef4444;margin-top:0;'>❌ Laravel Runtime Exception</h2>
            <p><strong>Error Message:</strong> <span style='color:#f43f5e;'>" . htmlspecialchars($e->getMessage()) . "</span></p>
            <p><strong>File:</strong> <code>" . htmlspecialchars($e->getFile()) . "</code> (Line " . $e->getLine() . ")</p>
            <h3 style='color:#38bdf8;'>Stack Trace:</h3>
            <pre style='background:#0f172a;color:#38bdf8;padding:15px;border-radius:10px;overflow-x:auto;font-size:12px;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>
        </div>
    </body>
    </html>
    ";
}
