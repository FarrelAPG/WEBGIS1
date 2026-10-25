<?php

define('LARAVEL_START', microtime(true));

// 1. Buat semua folder /tmp yang dibutuhkan Laravel
$tmpDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/logs',
    '/tmp/database',
    '/tmp/bootstrap/cache',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// 2. Siapkan file database SQLite di /tmp
$destDb = '/tmp/database/database.sqlite';
$isNewDb = !file_exists($destDb) || filesize($destDb) === 0;

if (!file_exists($destDb)) {
    @touch($destDb);
}

// 3. Set seluruh environment variable yang dibutuhkan
$envOverrides = [
    'DB_CONNECTION'       => 'sqlite',
    'DB_DATABASE'         => $destDb,
    'VIEW_COMPILED_PATH'  => '/tmp/storage/framework/views',
    'SESSION_DRIVER'      => 'cookie',
    'SESSION_ENCRYPT'     => 'false',
    'CACHE_STORE'         => 'array',
    'LOG_CHANNEL'         => 'stderr',
    'APP_ENV'             => 'production',
    'APP_DEBUG'           => 'false',
    'STORAGE_PATH'        => '/tmp/storage',
    'APP_SERVICES_CACHE'  => '/tmp/bootstrap/cache/services.php',
    'APP_PACKAGES_CACHE'  => '/tmp/bootstrap/cache/packages.php',
    'APP_CONFIG_CACHE'    => '/tmp/bootstrap/cache/config.php',
    'APP_ROUTES_CACHE'    => '/tmp/bootstrap/cache/routes-v7.php',
    'APP_EVENTS_CACHE'    => '/tmp/bootstrap/cache/events.php',
];

foreach ($envOverrides as $key => $value) {
    putenv("{$key}={$value}");
    $_ENV[$key]    = $value;
    $_SERVER[$key] = $value;
}

// 4. Load Composer autoloader & bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';

// 5. Mode maintenance
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 6. Jalankan migrasi & seeder jika database SQLite baru (cold start pertama)
if ($isNewDb) {
    try {
        $artisan = $app->make(\Illuminate\Contracts\Console\Kernel::class);
        $artisan->bootstrap();
        $artisan->call('migrate', ['--force' => true]);
        $artisan->call('db:seed', ['--force' => true]);
    } catch (\Throwable $e) {
        error_log('[SIGAP Vercel] Migrate/seed gagal: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
    }
}

// 7. Tangani request web
$app->handleRequest(\Illuminate\Http\Request::capture());
