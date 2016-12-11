# Comments

[![Latest Stable Version](https://poser.pugx.org/laravelista/comments/v/stable)](https://packagist.org/packages/laravelista/comments)
[![Total Downloads](https://poser.pugx.org/laravelista/comments/downloads)](https://packagist.org/packages/laravelista/comments)
[![License](https://poser.pugx.org/laravelista/comments/license)](https://packagist.org/packages/laravelista/comments)

[![forthebadge](http://forthebadge.com/images/badges/uses-js.svg)](http://forthebadge.com)
[![forthebadge](http://forthebadge.com/images/badges/built-with-love.svg)](http://forthebadge.com)

Comments is a Laravel package. With it you can easily implement native comments for your application.

## Overview

Comments can be used to comment on any model you have in your application.

All comments are stored in a single table with a polymorphic relation for content and a one-to-many relation for the user who posted the comment.

This package comes with a trait for models, so that you can easily access comments for the model/user. Also, whenever a comments is created, updated or deleted an event is fired.

The default frontend UI is built with [React.js](https://facebook.github.io/react/).

### Screenshots

Here are a few screenshots.

No comments & guest:

![Not logged in & no comments](http://i.imgur.com/aVXdWgX.png)

No comments & logged in:

![No Comments & logged in](http://i.imgur.com/AxG4Yeb.png)

One comment:

![One Comment & logged in](http://i.imgur.com/y2pkenw.png)

One comment edit form:

![One Comment Edit & logged in](http://i.imgur.com/JKdNw9r.png)

Two comments from different users:

![Two Comments & logged in](http://i.imgur.com/s357B1J.png)

### Tutorials & articles

I plan to expand this chapter with more tutorials and articles. If you write something about this package let me know, so that I can update this chapter.

**Articles:**

- [Laravelista: Comments preview](https://laravelista.com/posts/comments-preview)

## Requirements

- PHP version `>=5.6.4`

## Installation

From the command line:

```bash
composer require laravelista/comments
```

Include the service provider in `config/app.php`:

```php
'providers' => [
    ...,
    Laravelista\Comments\Providers\CommentsServiceProvider::class
];
```

Add `auth.comments` middleware in `app/Http/Kernel.php` under `$routeMiddleware`:

```php
protected $routeMiddleware = [
    ...,
    'auth.comments' => \Laravelista\Comments\Http\Middleware\Authenticate::class,
];
```

And finally, append `api/v1/*` in `app/Http/Middleware/VerifyCsrfToken.php` so that it looks like this:

```php
protected $except = [
    'api/v1/*'
];
```

### Run migrations

We need to create the table for comments.

```bash
php artisan vendor:publish --provider="Laravelista\Comments\Providers\CommentsServiceProvider" --tag=migrations

php artisan migrate
```

### Add a relationship to your User model

First, add this code to your User model so that you can retrieve the comments for a user:

```php
public function comments()
{
    return $this->hasMany(\Laravelista\Comments\Comments\Comment::class);
}
```

### Apply Comments trait to models

This is the first step to enabling comments on a model. Add trait `Comments` to any model that you want to be able to comment upon or get comments for.

Add the `Comments` trait to the model for which you want to enable comments for:

```php
use Laravelista\Comments\Comments\Traits\Comments;

class Product extends Model
{
    use Comments;
}
```

### Publish Config & configure

In the `config` file you should specify:

- which models can be commented upon
- where is your User model located
- what is the path to your login page

Publish the config file:

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

*Replace the classes from the sample above, with your own model classes.*

### Publish public assets

The default UI is built with [React.js](https://facebook.github.io/react/) and made for [Bootstrap](http://getbootstrap.com/). You need to publish its assets in order for it to work correctly.

```bash
php artisan vendor:publish --provider="Laravelista\Comments\Providers\CommentsServiceProvider" --tag=public --force
```

**You should run this command every time a new release of this package is released to keep the assets up to date.**

## Usage

In the view where you want to display comments, place this code and modify it:

```
@include('comments::comments-react', [
    'content_type' => App\Book::class,
    'content_id' => $book->id
])
```

In the example above we are setting the `content_type` to a `App\Book` model, which means that we are enabling comments on a book. We are also passing the `content_id` the `id` of the book so that we know to which book the comments relate to. Behind the scenes, the package detects the currently logged in user if any.

If you open the page containing the view where you have placed the above code, you should see a working comments form.

## Events

This package fires events to let you easily hook into it.

- `Laravelista\Comments\Events\CommentWasPosted` - this is where you would usually notify users who commented on the given model.
- `Laravelista\Comments\Events\CommentWasUpdated`
- `Laravelista\Comments\Events\CommentWasDeleted`

### Get users who commented

On my website [Laravelista](https://laravelista.com), whenever someone posts a comment on something, I send an email to everyone who posted on the same thing (except the user who posted the actual comment), to let them know that there is a new comment.

First you have to specify the event you want to listen to and the listener which will trigger when that event occcurs. Go to `app/Providers/EventServiceProvider.php` and append this code to the `$listen` array:

```php
protected $listen = [
    ...,
    'Laravelista\Comments\Events\CommentWasPosted' => [
        'App\Listeners\SendEmailToUsersWhoCommentedOnGivenContent',
    ]
];
```

Then, from the command line run `php artisan event:generate`. This will create the necessary listener class in `App/Listeners`. Open the file `app/Listeners/SendEmailToUsersWhoCommentedOnGivenContent.php` and add this code:

```
public function handle(CommentWasPosted $event)
{
    $comment = $event->comment;
    $users = $comment->getUsersWhoCommented();

    foreach($users as $user)
    {
        // send email to each user
    }
}
```
