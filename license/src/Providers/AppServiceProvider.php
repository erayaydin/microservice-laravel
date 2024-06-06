<?php

namespace MService\License\Providers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\AggregateServiceProvider;

class AppServiceProvider extends AggregateServiceProvider
{
    /**
     * The provider class names.
     *
     * @var string[]
     */
    protected $providers = [
        RouteServiceProvider::class,
        DatabaseServiceProvider::class,
    ];
}
