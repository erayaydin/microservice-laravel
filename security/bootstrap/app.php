<?php

use Illuminate\Contracts\Console\Kernel as ConsoleKernelContract;
use Illuminate\Contracts\Http\Kernel as HttpKernelContract;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\RegisterProviders;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use function Illuminate\Filesystem\join_paths;

/*
// Initialize the application
$app = new Application(dirname(__DIR__));

// Add kernels
$app->singleton(
    HttpKernelContract::class,
    HttpKernel::class,
);
$app->singleton(
    ConsoleKernelContract::class,
    ConsoleKernel::class,
);

// Register essential providers
$app->register(EventServiceProvider::class);

// Register default bootstrap providers
RegisterProviders::merge([], $app->getBootstrapProvidersPath());
*/

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

$app->useAppPath(join_paths(dirname(__DIR__), 'src'));

return $app;
