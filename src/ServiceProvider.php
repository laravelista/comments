<?php

namespace Laravelista\Comments;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
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
        if (Config::get('comments.routes') === true) {
            $this->loadRoutesFrom(__DIR__ . '/routes.php');
        }
    }

    /**
     * If load_migrations config is true (by default it is),
     * then load the package migrations, otherwise don't load
     * the migrations.
     */
    protected function loadMigrations()
    {
        if (Config::get('comments.load_migrations') === true) {
            $this->loadMigrationsFrom(__DIR__ . '/../migrations');
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
        foreach(Config::get('comments.permissions', []) as $permission => $policy) {
            Gate::define($permission, $policy);
        }
    }

    public function boot()
    {
        $this->loadRoutes();

        $this->loadMigrations();

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'comments');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'comments');

        $this->includeBladeComponent();

        $this->definePermissions();

        $this->publishes([
            __DIR__.'/../migrations/' => App::databasePath('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../resources/views' => App::resourcePath('views/vendor/comments'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../config/comments.php' => App::configPath('comments.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/lang' => App::resourcePath('lang/vendor/comments'),
        ], 'translations');

        Route::model('comment', Config::get('comments.model'));

        Paginator::useBootstrap();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/comments.php',
            'comments'
        );
    }
}
