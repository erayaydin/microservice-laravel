<?php

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Router;
use MService\License\Actions\GetLicense;

/** @var Router $route */
try {
    $route = app()->make(Router::class);
} catch (BindingResolutionException $e) {
    abort(500, $e->getMessage());
}

$route->get('me', GetLicense::class);
