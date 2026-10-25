<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

define('LARAVEL_START', microtime(true));

// 1. Buat folder sementara di /tmp untuk cache & views
$tmpDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/logs',
    '/tmp/database',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// 2. Siapkan file database SQLite di /tmp
$destDb = '/tmp/database/database.sqlite';
$isNewDb = !file_exists($destDb) || filesize($destDb) === 0;

if (!file_exists($destDb)) {
    @touch($destDb);
}

// 3. Konfigurasi path environment runtime Vercel
putenv("DB_DATABASE={$destDb}");
$_ENV['DB_DATABASE'] = $destDb;
$_SERVER['DB_DATABASE'] = $destDb;

putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');

// 4. Load autoloader & bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 5. Jalankan migrasi & seeder jika database baru dibuat di /tmp
if ($isNewDb) {
    try {
        Artisan::call('migrate', ['--force' => true, '--seed' => true]);
    } catch (\Throwable $e) {
        // Fallback jika migrasi gagal
    }
}

// 6. Tangani request web
$app->handleRequest(Request::capture());
