<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Check maintenance mode
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register Composer Autoloader
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel and handle request
(require_once __DIR__.'/bootstrap/app.php')
    ->handleRequest(Request::capture());
