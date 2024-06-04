<?php

namespace MService\Security\Providers;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use MService\Security\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        Passport::loadKeysFrom('/tmp/secrets');

        Passport::enablePasswordGrant();
        Passport::tokensExpireIn(now()->addHour());
        Passport::refreshTokensExpireIn(now()->addWeek());
        Passport::personalAccessTokensExpireIn(now()->addMonths(3));

        /** @var ConfigRepository $config */
        $config = $this->app->make(ConfigRepository::class);
        $config->set('auth.providers.users', [
            'driver' => 'eloquent',
            'model' => User::class,
        ]);
        $config->set('auth.guards.api', [
            'driver' => 'passport',
            'provider' => 'users',
        ]);
    }

    public function register(): void
    {

    }
}
