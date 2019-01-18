<?php

namespace Bitfumes\Blogg;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use GrahamCampbell\Markdown\MarkdownServiceProvider;

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
