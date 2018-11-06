<?php

Route::post('comments', '\Laravelista\Comments\Controllers\CommentsController@store');
Route::delete('comments/{comment}', '\Laravelista\Comments\Controllers\CommentsController@destroy');
Route::put('comments/{comment}', '\Laravelista\Comments\Controllers\CommentsController@update');
Route::post('comments/{comment}', '\Laravelista\Comments\Controllers\CommentsController@reply');