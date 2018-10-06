<?php

namespace Bitfumes\Blogg;

use Illuminate\Support\ServiceProvider;

class BloggServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config/blogg.php', 'blogg');
        $this->publisheThings();
    }

    public function register()
    {
        // code...
    }

    protected function publisheThings()
    {
        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations'),
        ], 'blogg:migrations');
        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/blogg'),
        ], 'blogg:views');
        $this->publishes([
            __DIR__ . '/database/factories' => database_path('factories'),
        ], 'blogg:factories');
        $this->publishes([
            __DIR__ . '/../config/blogg.php' => config_path('blogg.php'),
        ], 'blogg:config');
        $this->publishes([
            __DIR__ . '/routes/routes.php' => base_path('routes/Blog.php'),
        ], 'blogg:routes');
    }
}
