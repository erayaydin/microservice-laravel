<?php

namespace MService\FileManagement\Providers;

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
    ];

    public function register(): void
    {
        $this->loadMigrationsFrom($this->app->path('Migrations'));
    }
}
