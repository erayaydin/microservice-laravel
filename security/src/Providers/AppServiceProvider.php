<?php

namespace MService\Security\Providers;

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
        AuthServiceProvider::class,
    ];

    /**
     * @throws BindingResolutionException
     */
    public function register(): void
    {
        parent::register();

        /** @var Repository $config */
        $config = $this->app->make(Repository::class);
        $config->set('kafka.brokers', env('KAFKA_BROKERS'));
    }
}
