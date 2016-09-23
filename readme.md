## Installation

```
composer require laravelista/comments
```

Add `Laravelista\Comments\CommentsServiceProvider::class` to `config/app.php` providers array.

## Intructions

### Run Migrations

```
php artisan vendor:publish --provider="Laravelista\Comments\CommentsServiceProvider" --tag=migrations

php artisan migrate
```

### User model & "content" models

Add to User.php:

```
use Laravelista\Comments\Traits\Comments;

class User extends Model
{
    use Comments;
}
```

### Publish Config & configure

```
php artisan vendor:publish --provider="Laravelista\Comments\CommentsServiceProvider" --tag=config
```

**Important!** Make sure to enter content classes for models that can be commented upon.
