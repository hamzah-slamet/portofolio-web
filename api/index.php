<?php

/*
|--------------------------------------------------------------------------
| Entry point untuk Vercel (serverless)
|--------------------------------------------------------------------------
|
| Filesystem Vercel READ-ONLY kecuali /tmp. Sebelum Laravel boot, kita paksa
| semua path cache & compiled view ke /tmp, dan pakai driver stateless supaya
| tidak ada penulisan ke direktori aplikasi (yang akan menyebabkan 500).
| Nilai hanya diset jika belum disediakan environment.
|
*/

$defaults = [
    'VIEW_COMPILED_PATH'  => '/tmp',
    'APP_CONFIG_CACHE'    => '/tmp/config.php',
    'APP_EVENTS_CACHE'    => '/tmp/events.php',
    'APP_PACKAGES_CACHE'  => '/tmp/packages.php',
    'APP_ROUTES_CACHE'    => '/tmp/routes.php',
    'APP_SERVICES_CACHE'  => '/tmp/services.php',
    'CACHE_STORE'         => 'array',
    'SESSION_DRIVER'      => 'cookie',
    'LOG_CHANNEL'         => 'stderr',
    'FILESYSTEM_DISK'     => 'public',
];

foreach ($defaults as $key => $value) {
    $current = getenv($key);
    if ($current === false || $current === '') {
        putenv("{$key}={$value}");
        $_ENV[$key]    = $value;
        $_SERVER[$key] = $value;
    }
}

require __DIR__ . '/../public/index.php';
