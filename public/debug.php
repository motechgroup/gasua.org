<?php

// Emergency Debugger for Shared Hosting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<html><head><title>Gusii Foundation - Shared Hosting Diagnostic Tool</title>";
echo "<style>body{font-family:sans-serif;padding:30px;background:#0f172a;color:#f8fafc;} h1{color:#10b981;} pre{background:#1e293b;padding:15px;border-radius:10px;overflow-x:auto;color:#38bdf8;} .card{background:#1e293b;padding:20px;border-radius:12px;margin-bottom:20px;}</style>";
echo "</head><body>";
echo "<h1>🛠️ Gusii All Stars Foundation - Environment Diagnostic</h1>";

// 1. PHP Version
echo "<div class='card'><h2>1. PHP Runtime</h2>";
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";
echo "<p><strong>Required Version:</strong> PHP 8.3 or higher</p>";
if (version_compare(PHP_VERSION, '8.3.0', '>=')) {
    echo "<p style='color:#10b981;'>✓ PHP version requirement met!</p>";
} else {
    echo "<p style='color:#ef4444;'>❌ PHP version is lower than 8.3. Please switch to PHP 8.4 in cPanel Select PHP Version / MultiPHP Manager.</p>";
}
echo "</div>";

// 2. Extensions Check
echo "<div class='card'><h2>2. Required PHP Extensions</h2>";
$required = ['pdo', 'pdo_mysql', 'openssl', 'mbstring', 'tokenizer', 'xml', 'curl', 'json', 'bcmath'];
echo "<ul>";
foreach ($required as $ext) {
    if (extension_loaded($ext)) {
        echo "<li style='color:#10b981;'>✓ $ext: Loaded</li>";
    } else {
        echo "<li style='color:#ef4444;'>❌ $ext: NOT LOADED</li>";
    }
}
echo "</ul></div>";

// 3. MySQL DB Connection Test from .env
echo "<div class='card'><h2>3. Database Connection Test</h2>";
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim(trim($value), '"\'');
            $env[$name] = $value;
        }
    }

    $dbHost = $env['DB_HOST'] ?? '127.0.0.1';
    $dbPort = $env['DB_PORT'] ?? '3306';
    $dbName = $env['DB_DATABASE'] ?? '';
    $dbUser = $env['DB_USERNAME'] ?? '';
    $dbPass = $env['DB_PASSWORD'] ?? '';

    echo "<p>Testing Connection to <code>$dbUser@$dbHost:$dbPort/$dbName</code>...</p>";

    try {
        $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=utf8mb4";
        $pdo = new PDO($dsn, $dbUser, $dbPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        echo "<p style='color:#10b981;font-weight:bold;'>✓ SUCCESS! Connected to MySQL Database successfully.</p>";
    } catch (Exception $e) {
        echo "<p style='color:#ef4444;font-weight:bold;'>❌ DATABASE CONNECTION FAILED: " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p style='color:#f59e0b;'>Tip: Make sure your DB_PASSWORD in .env is wrapped in double quotes if it contains # or $ characters (e.g. DB_PASSWORD=\"9Kky9\$bLl#TZK#.T\")</p>";
    }
} else {
    echo "<p style='color:#ef4444;'>❌ .env file not found in root directory!</p>";
}
echo "</div>";

// 4. Latest Laravel Log Errors
echo "<div class='card'><h2>4. Latest Laravel Errors (storage/logs/laravel.log)</h2>";
$logPath = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($logPath)) {
    $content = file_get_contents($logPath);
    $lines = explode("\n", $content);
    $lastLines = array_slice($lines, -40);
    echo "<pre>" . htmlspecialchars(implode("\n", $lastLines)) . "</pre>";
} else {
    echo "<p style='color:#f59e0b;'>No laravel.log file generated yet in storage/logs/.</p>";
}
echo "</div>";

echo "</body></html>";
