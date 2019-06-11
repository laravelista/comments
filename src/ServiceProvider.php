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
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->publishes([
            __DIR__ . '/../config/comments.php' => config_path('comments.php'),
        ], 'config');

        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'comments');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/comments'),
        ], 'views');

        Blade::component('comments::components.comments', 'comments');

        // Define permission defined in config
        $permissions = config('comments.permissions', [
            'create-comment' => 'Laravelista\Comments\CommentPolicy@create',
            'delete-comment' => 'Laravelista\Comments\CommentPolicy@delete',
            'edit-comment' => 'Laravelista\Comments\CommentPolicy@update',
            'reply-to-comment' => 'Laravelista\Comments\CommentPolicy@reply',
        ]);
        foreach($permissions as $permission => $policy) {
            Gate::define($permission, $policy);
        }

        Route::model('comment', config('comments.comment_class'));
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/comments.php',
            'comments'
        );
    }
}
