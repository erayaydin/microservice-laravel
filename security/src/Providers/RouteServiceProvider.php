<?php

namespace MService\Security\Providers;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Foundation\Events\DiagnosingHealth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The controller namespace for the application.
     *
     * @var string|null
     */
    protected ?string $namespace = null;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->booted(function () {
            if (! is_null($this->namespace)) {
                $this->app[UrlGenerator::class]->setRootControllerNamespace($this->namespace);
            }

            if ($this->app->routesAreCached()) {
                $this->app->booted(function () {
                    require $this->app->getCachedRoutesPath();
                });
            } else {
                $this->app->call([$this, 'routing']);

                $this->app->booted(function () {
                    $this->app['router']->getRoutes()->refreshNameLookups();
                    $this->app['router']->getRoutes()->refreshActionLookups();
                });
            }
        });
    }

    public function routing(): void
    {
        Route::middleware('api')
            ->prefix('api/v1')
            ->group($this->app->path('Routes/ApiV1.php'));

        Route::get('/health', function () {
            Event::dispatch(new DiagnosingHealth);

            return response(status: 200);
        });
    }
}
