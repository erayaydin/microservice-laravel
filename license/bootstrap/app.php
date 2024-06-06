<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use MService\License\Commands\ConsumeMessages;
use function Illuminate\Filesystem\join_paths;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withCommands([ConsumeMessages::class])
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
