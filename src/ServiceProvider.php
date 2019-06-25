<?php

namespace Laravelista\Comments;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        if (config('comments.routes') === true) {
            $this->loadRoutesFrom(__DIR__ . '/routes.php');
        }

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'comments');

        Blade::include('comments::components.comments', 'comments');

        // Define permission defined in config
        $permissions = config('comments.permissions');

        foreach($permissions as $permission => $policy) {
            Gate::define($permission, $policy);
        }

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
