<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// 1. Tampung konfigurasi ke variabel $app
$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Mendaftarkan alias middleware Anda
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class, // Sesuaikan jika nama file Anda berbeda
            'guru'  => \App\Http\Middleware\IsGuru::class,
            'siswa' => \App\Http\Middleware\IsSiswa::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Biarkan isi exceptions Anda di sini jika ada
    })->create();

// 2. --- TAMBAHKAN HACK VERCEL INI DI SINI ---
$storagePath = '/tmp/storage';
if (!is_dir($storagePath)) {
    mkdir($storagePath . '/framework/cache/data', 0777, true);
    mkdir($storagePath . '/framework/sessions', 0777, true);
    mkdir($storagePath . '/framework/views', 0777, true);
    mkdir($storagePath . '/logs', 0777, true);
}
$app->useStoragePath($storagePath);
// --------------------------------------------

// 3. Kembalikan variabel $app
return $app;
