<?php

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Router;

/** @var Router $route */
try {
    $route = app()->make(Router::class);
} catch (BindingResolutionException $e) {
    abort(500, $e->getMessage());
}
