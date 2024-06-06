<?php

namespace MService\License\Providers;

use Illuminate\Support\ServiceProvider;
use function Illuminate\Filesystem\join_paths;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(join_paths(dirname(__DIR__), 'Migrations'));
    }
}
