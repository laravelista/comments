<?php namespace Laravelista\Comments\Providers;

use Illuminate\Support\ServiceProvider;

class CommentsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      $this->publishes([
        __DIR__.'/../Database/Migrations' => database_path('migrations')
      ], 'migrations');

      $this->publishes([
          __DIR__.'/../Config/config.php' => config_path('comments.php'),
      ], 'config');

      if (! $this->app->routesAreCached()) {
        require __DIR__.'/../Http/routes.php';
      }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__. '/../Config/config.php', 'comments'
        );
    }
}
