# Upgrading from older versions

Be sure to update your version of the config file to match the latest version of the package.


## Support for soft deletes (`3.4.0`)

If you are updating an already existing database table `comments` and want support for soft deletes **(new installations get this by default)**, then create a new migration with `php artisan make:migration add_soft_delete_column_to_comments_table` and paste this code inside:

```
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteColumnToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
}
```

Finally, run `php artisan migrate`.


## Support for guest commenting

If you are updating an already existing database table `comments` and want support for guest commenting **(new installations get this by default)**, then create a new migration with `php artisan make:migration add_guest_commenting_columns_to_comments_table` and paste this code inside:

```
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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


## Support for approving comments

If you are updating an already existing database table `comments` and want support for approving comments **(new installations get this by default)**, then create a new migration with `php artisan make:migration add_approved_column_to_comments_table` and paste this code inside:

```
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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


## Support for multiple user models

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


## Support for non-integer IDs

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

