<?php

namespace MService\Notification\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadViewsFrom($this->app->basePath('views'), "notification");
        $this->loadMigrationsFrom($this->app->path('Migrations'));
    }
}
