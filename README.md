# Comments

Comments is a Laravel package. With it you can easily implement native comments for your application.

[![Become a Patron](https://img.shields.io/badge/Become%20a-Patron-f96854.svg?style=for-the-badge)](https://www.patreon.com/laravelista)


## Overview

This package can be used to comment on any model you have in your application.

All comments are stored in a single table with a polymorphic relation for content and a polymorphic relation for the user who posted the comment.


### Features

- View comments
- Create comments
- Delete comments
- Edit comments
- Reply to comments
- Authorization rules
- Support localization
- Dispatch events
- Route, Controller, Comment, Migration & View customizations
- Support for non-integer IDs
- Support for multiple User models
- Solved N+1 query problem
- Comment approval (opt-in)
- Guest commenting (opt-in)
- Pagination (opt-in)
- Soft deletes (opt-in)
- Works with custom ID columns
- Optionally load package migrations [NEW]
- Configure maximum indentation level [NEW]


### Screenshots

Here are a few screenshots.

No comments & guest:

![](https://i.imgur.com/9df4Xun.png)

No comments & logged in:

![](https://i.imgur.com/ALI6GbR.png)

One comment:

![](https://i.imgur.com/9wBNiy2.png)

One comment edit form:

![](https://i.imgur.com/cxDh34O.png)

Two comments from different users:

![](https://i.imgur.com/2P5u25x.png)


### Tutorials & articles

I plan to expand this chapter with more tutorials and articles. If you write something about this package let me know, so that I can update this chapter.

**Screencasts:**

- [Adding comments to your Laravel application](https://www.youtube.com/watch?v=YhA0CSX1HIg) by Andre Madarang.


## Installation

From the command line:

```bash
composer require laravelista/comments
```


### Run migrations

We need to create the table for comments.

```bash
php artisan migrate
```


### Add Commenter trait to your User model

Add the `Commenter` trait to your User model so that you can retrieve the comments for a user:

```php
use Laravelista\Comments\Commenter;

class User extends Authenticatable
{
    use Notifiable, Commenter;
}
```


### Add Commentable trait to models

Add the `Commentable` trait to the model for which you want to enable comments for:

```php
use Laravelista\Comments\Commentable;

class Product extends Model
{
    use Commentable;
}
```


### Publish Config & configure (optional)

Publish the config file (optional):

```bash
php artisan vendor:publish --provider="Laravelista\Comments\ServiceProvider" --tag=config
```


### Publish views (customization)

The default UI is made for Bootstrap 4, but you can change it however you want.

```bash
php artisan vendor:publish --provider="Laravelista\Comments\ServiceProvider" --tag=views
```


### Publish Migrations (customization)

You can publish migration to allow you to have more control over your table

```bash
php artisan vendor:publish --provider="Laravelista\Comments\ServiceProvider" --tag=migrations
```


### Publish translations (customization)

The package currently only supports English, but I am open to PRs for other languages.

```bash
php artisan vendor:publish --provider="Laravelista\Comments\ServiceProvider" --tag=translations
```


## Usage

In the view where you want to display comments, place this code and modify it:

```
@comments(['model' => $book])
```

In the example above we are setting the `commentable_type` to the class of the book. We are also passing the `commentable_id` the `id` of the book so that we know to which book the comments relate to. Behind the scenes, the package detects the currently logged in user if any.

If you open the page containing the view where you have placed the above code, you should see a working comments form.


### View only approved comments

To view only approved comments, use this code:

```
@comments([
    'model' => $book,
    'approved' => true
])
```


### Paginate comments

Pagination paginates by top level comments only, meaning that if you specify the number of comments per page to be 1, and that one comment has 100 replies, it will display that one comment and all of its replies.

It was not possible to do it any other way, because if I paginate by all comments (parent and child) you will end up with blank pages since the comments components loops parent comments first and then uses recursion for replies.

To use pagination, use this code:

```
@comments([
    'model' => $user,
    'perPage' => 2
])
```

Replace `2` with any number you want.

### Configure maximum indentation level

By default the replies go up to level three. After that they are "mashed" at that level.

```
- 0
    - 1
        - 2
            - 3
```

You can configure the maximum indentation level like so:

```
@comments([
    'model' => $user,
    'maxIndentationLevel' => 1
])
```


## Events

This package fires events to let you know when things happen.

- `Laravelista\Comments\Events\CommentCreated`
- `Laravelista\Comments\Events\CommentUpdated`
- `Laravelista\Comments\Events\CommentDeleted`


## REST API

To change the controller or the routes, see the config.

```
Route::post('comments', '\Laravelista\Comments\CommentController@store');
Route::delete('comments/{comment}', '\Laravelista\Comments\CommentController@destroy');
Route::put('comments/{comment}', '\Laravelista\Comments\CommentController@update');
Route::post('comments/{comment}', '\Laravelista\Comments\CommentController@reply');
```


### POST `/comments`

Request data:

```
'commentable_type' => 'required|string',
'commentable_id' => 'required|string|min:1',
'message' => 'required|string'
```


### PUT `/comments/{comment}`

- {comment} - Comment ID.

Request data:

```
'message' => 'required|string'
```


### POST `/comments/{comment}`

- {comment} - Comment ID.

Request data:

```
'message' => 'required|string'
```


## Upgrading from older versions (troubleshoot)

Before creating an issue, read [this](./UPGRADE.md).


## Sponsors & Backers

I would like to extend my thanks to the following sponsors & backers for funding my open-source journey. If you are interested in becoming a sponsor or backer, please visit the [Backers page](https://mariobasic.com/backers).


## Contributing

Thank you for considering contributing to Comments! The contribution guide can be found [Here](https://mariobasic.com/contributing).


## Code of Conduct

In order to ensure that the open-source community is welcoming to all, please review and abide by the [Code of Conduct](https://mariobasic.com/code-of-conduct).


## License

Comments is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).