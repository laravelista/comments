<?php

Route::post('comments', '\Laravelista\Comments\CommentsController@store');
Route::delete('comments/{comment}', '\Laravelista\Comments\CommentsController@destroy');
