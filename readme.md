# Comments

Comments is a Laravel package. With it you can easily implement native comments for your application.

[![Become a Patron](https://img.shields.io/badge/Become%20a-Patron-f96854.svg?style=for-the-badge)](https://www.patreon.com/laravelista)

## Overview

This package can be used to comment on any model you have in your application.

All comments are stored in a single table with a polymorphic relation for content and a polymorphic relation for the user who posted the comment.

### Features

- [x] View comments
- [x] Create comments
- [x] Delete comments
- [x] Edit comments
- [x] **Reply to comments**
- [x] **Authorization rules**
- [x] **Support localization**
- [x] **Dispatch events**
- [x] **Route, Controller, Comment, Migration & View customizations**
- [x] **Support for non-integer IDs**
- [x] **Support for multiple User models**
- [x] **Solved N+1 query problem**
- [x] **Comment approval (opt-in)**
- [x] **Guest commenting**

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

**Articles:**

- [Laravelista: Comments preview (Outdated)](https://laravelista.com/posts/comments-preview)

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

## Updating from older versions

### Support for guest commenting

If you are updating an already existing database table `comments` and want support for guest commenting **(new installations get this by default)**, then create a new migration with `php artisan make:migration add_guest_commenting_columns_to_comments_table` and paste this code inside:

```
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddGuestCommentingColumnsToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->string('commenter_id')->nullable()->change();
            $table->string('commenter_type')->nullable()->change();

            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();
        });
    }
}
```

Finally, run `php artisan migrate`.

### Support for approving comments

If you are updating an already existing database table `comments` and want support for approving comments **(new installations get this by default)**, then create a new migration with `php artisan make:migration add_approved_column_to_comments_table` and paste this code inside:

```
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddApprovedColumnToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->boolean('approved')->default(true)->nullable();
        });
    }
}
```

Finally, run `php artisan migrate`.

### Support for multiple user models

If you are updating an already existing database table `comments` and want support for multiple user models **(new installations get this by default)**, then create a new migration with `php artisan make:migration add_commenter_type_column_to_comments_table` and paste this code inside:

```
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddCommenterTypeColumnToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->string('commenter_id')->change();
            $table->string('commenter_type')->nullable();
        });

        DB::table('comments')->update([
            'commenter_type' => '\App\User'
        ]);
    }
}
```

Then, add `doctrine/dbal` dependency with:

```
composer require doctrine/dbal
```

Finally, run `php artisan migrate`.

### Support for non-integer IDs

If you are updating an already existing database table `comments` and want support for non-integer IDs **(new installations get this by default)**, then create a new migration with `php artisan make:migration allow_commentable_id_to_be_string` and paste this code inside:

```
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllowCommentableIdToBeString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->string('commentable_id')->change();
        });
    }
}
```

Then, add `doctrine/dbal` dependency with:

```
composer require doctrine/dbal
```

Finally, run `php artisan migrate`.