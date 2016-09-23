<?php

Route::group([
    'middleware' => 'web',
    'prefix' => 'api/v1',
    'namespace' => 'Laravelista\Comments\Http\Controllers'
], function() {
    Route::resource('comments', 'CommentController', [
        'only' => ['index', 'store', 'update', 'destroy']
    ]);
});
