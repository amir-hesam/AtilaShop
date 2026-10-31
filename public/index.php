<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Auto-redirect to installer if application is not yet installed on cPanel/shared host
if (!file_exists(__DIR__ . '/../storage/installed') && !file_exists(__DIR__ . '/storage/installed')) {
    if (file_exists(__DIR__ . '/install.php') && basename($_SERVER['SCRIPT_NAME'] ?? '') !== 'install.php') {
        $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        $installUrl = ($baseUrl === '' ? '' : $baseUrl) . '/install.php';
        header("Location: {$installUrl}");
        exit;
    }
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
