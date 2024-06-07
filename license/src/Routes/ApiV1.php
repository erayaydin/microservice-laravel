<?php

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Router;
use MService\License\Actions\GetLicenseOfUser;
use MService\License\Actions\MeLicense;
use MService\License\Middlewares\EnsureTokenIsValid;

/** @var Router $route */
try {
    $route = app()->make(Router::class);
} catch (BindingResolutionException $e) {
    abort(500, $e->getMessage());
}

$route->get('me', MeLicense::class)->middleware(EnsureTokenIsValid::class);
// TODO: check `admin.license` scope to internal RestAPI
$route->get('users/{user}', GetLicenseOfUser::class);
