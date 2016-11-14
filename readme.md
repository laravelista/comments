# Comments

Laravel package for comments using [React.js](https://facebook.github.io/react/) and an API built with [Syndra](https://github.com/laravelista/Syndra).

**It just works!**

See this post for more details: [Comments preview](https://laravelista.com/posts/comments-preview).

## Installation

```bash
composer require laravelista/comments
```

Add `Laravelista\Comments\Providers\CommentsServiceProvider::class` to `config/app.php` providers array.

Add `'auth.comments' => \Laravelista\Comments\Http\Middleware\Authenticate::class,` to `app/Http/Kernel.php` under `$routeMiddleware`.

## Instructions

### Run Migrations

```bash
php artisan vendor:publish --provider="Laravelista\Comments\Providers\CommentsServiceProvider" --tag=migrations

php artisan migrate
```

### User model & "content" models

Add to `User.php` and any other model that you want to be able to get comments for:

```php
use Laravelista\Comments\Comments\Traits\Comments;

class User extends Model
{
    use Comments;
}
```

### Publish Config & configure

```bash
php artisan vendor:publish --provider="Laravelista\Comments\Providers\CommentsServiceProvider" --tag=config
```

**Important!** Make sure to enter content classes for models that can be commented upon in `config/comments.php` like so:

```php
/**
 * Enter models which can be commented upon.
 */
'content' => [
    Laravelista\Lessons\Lesson::class,
    Laravelista\Archive\Post::class
],
```

### Publish public assets

```bash
php artisan vendor:publish --provider="Laravelista\Comments\Providers\CommentsServiceProvider" --tag=public --force
```

You should run this command every time a new release of this package is released to keep the assets up to date.

## Events

This package fires events to let you easily hook into it.

- `Laravelista\Comments\Events\CommentWasPosted` - this is where you would usually notify users who commented on the given model.
- `Laravelista\Comments\Events\CommentWasUpdated`
- `Laravelista\Comments\Events\CommentWasDeleted`

## Usage

This is the most simplest part yet :)

In the view where you want to display comments, place this code and modify it:

```
@include('comments::comments-react', [
    'content_type' => App\Book::class,
    'content_id' => $book->id
])
```

In the example above we are setting the `content_type` to a `App\Book` model, which means that we are enabling comments on a book and we are also passing the `content_id` the `id` of the book so that we know to which book the comments relate to.

If you open the page containing the view where you have placed the above code, you should see a working comments form.
