<?php

namespace Laravelista\Comments;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * If routes are enabled (by default they are),
     * then load the routes, otherwise don't load
     * the routes.
     */
    protected function loadRoutes()
    {
        if (config('comments.routes') === true) {
            $this->loadRoutesFrom(__DIR__ . '/routes.php');
        }
    }

    /**
     * If for some reason you want to override the component.
     */
    protected function includeBladeComponent()
    {
        Blade::include('comments::components.comments', 'comments');
    }

    /**
     * Define permission defined in the config.
     */
    protected function definePermissions()
    {
        foreach(config('comments.permissions') as $permission => $policy) {
            Gate::define($permission, $policy);
        }
    }

    public function boot()
    {
        $this->loadRoutes();

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'comments');

        $this->includeBladeComponent();

        $this->definePermissions();

        $this->publishes([
            __DIR__.'/../migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/comments'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../config/comments.php' => config_path('comments.php'),
        ], 'config');

        Route::model('comment', config('comments.model'));
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/comments.php',
            'comments'
        );
    }
}
