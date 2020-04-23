<?php

namespace Bitfumes\Blogg;

use Bitfumes\Blogg\Providers\AuthServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use GrahamCampbell\Markdown\MarkdownServiceProvider;
use Bitfumes\Blogg\Providers\EventServiceProvider;

class BloggServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/blogg.php', 'blogg');
        $this->registerRoutes();
        $this->blogViews();
        $this->publisheThings();
    }

    public function register()
    {
        app()->register(MarkdownServiceProvider::class);
        app()->register(EventServiceProvider::class);
        app()->register(AuthServiceProvider::class);
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        });
    }

    protected function loadRoutesFrom($path)
    {
        $routeDir = base_path('routes');
        if (file_exists($routeDir)) {
            $routeDir    = base_path('routes');
            $appRouteDir = scandir($routeDir);
            if (!$this->app->routesAreCached()) {
                require in_array('Blog.php', $appRouteDir) ? base_path('routes/Blog.php') : $path;
            }
        } else {
            require $path;
        }
    }

    /**
     * Get the Blogg route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'namespace'  => "Bitfumes\Blogg\Http\Controllers",
            'middleware' => 'web',
        ];
    }

    protected function publisheThings()
    {
        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations'),
        ], 'blogg:migrations');
        $this->publishes([
            __DIR__ . '/database/factories' => database_path('factories'),
        ], 'blogg:factories');
        $this->publishes([
            __DIR__ . '/../config/blogg.php' => config_path('blogg.php'),
        ], 'blogg:config');
        $this->publishes([
            __DIR__ . '/Http/routes.php' => base_path('routes/Blog.php'),
        ], 'blogg:routes');
    }

    public function blogViews()
    {
        if (config('blogg.include_views')) {
            // Frontend
            $this->loadViewsFrom(__DIR__ . '/../resources/views', 'blogg');
            // Publishing assets
            $this->publishes([
                __DIR__ . '/views' => resource_path('views/vendor/blogg'),
            ], 'blogg:views');
            // Routes
            Route::group($this->routeConfiguration(), function () {
                Route::get('/{view?}', 'HomeController@index')->where('view', '(.*)')->name('blogg');
            });
        }
    }
}
