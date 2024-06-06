<?php

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Router;
use MService\Security\Actions\CreateNewUser;

/** @var Router $route */
try {
    $route = app()->make(Router::class);
} catch (BindingResolutionException $e) {
    abort(500, $e->getMessage());
}

$route->group(['prefix' => 'users', 'as' => 'user.'], function (Router $route) {
    $route->post('/', CreateNewUser::class);
});
