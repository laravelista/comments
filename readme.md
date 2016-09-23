## Installation

```
composer require laravelista/comments
```

Add `Laravelista\Comments\Providers\CommentsServiceProvider::class` to `config/app.php` providers array.

Add `'auth.comments' => \Laravelista\Comments\Http\Middleware\Authenticate::class,` to `app/Http/Kernel.php` under `$routeMiddleware`.

## Intructions

### Run Migrations

```
php artisan vendor:publish --provider="Laravelista\Comments\Providers\CommentsServiceProvider" --tag=migrations

php artisan migrate
```

### User model & "content" models

Add to User.php:

```
use Laravelista\Comments\Comments\Traits\Comments;

class User extends Model
{
    use Comments;
}
```

### Publish Config & configure

```
php artisan vendor:publish --provider="Laravelista\Comments\Providers\CommentsServiceProvider" --tag=config
```

**Important!** Make sure to enter content classes for models that can be commented upon.

### Publish public assets

```
php artisan vendor:publish --provider="Laravelista\Comments\Providers\CommentsServiceProvider" --tag=public --force
```
