<?php

return [
    'driver' => env('SESSION_DRIVER', 'cookie'), // Changed from 'file' to 'cookie'
    'lifetime' => env('SESSION_LIFETIME', 120),
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => env('SESSION_FILES_PATH', storage_path('framework/sessions')),
    'connection' => env('SESSION_CONNECTION'),
    'table' => 'sessions',
    'store' => env('SESSION_STORE'),
    'lottery' => [2, 100],
    'cookie' => env(
        'SESSION_COOKIE',
        str_slug(env('APP_NAME', 'laravel'), '_') . '_session'
    ),
    'path' => '/',
    'domain' => env('SESSION_DOMAIN'), // Will be null for Vercel
    'secure' => env('SESSION_SECURE_COOKIE', true), // Force HTTPS
    'http_only' => true,
    'same_site' => env('SESSION_SAME_SITE', 'lax'),
    'partitioned' => false,
];
