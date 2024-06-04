<?php

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Router;

/** @var Router $route */
try {
    $route = app()->make(Router::class);
} catch (BindingResolutionException $e) {
    abort(500, $e->getMessage());
}

$route->get('/', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'user_id' => $request->get('user_id'),
    ]);
});
