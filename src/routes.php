<?php

Route::post('comments', '\Laravelista\Comments\CommentsController@store');
Route::delete('comments/{comment}', '\Laravelista\Comments\CommentsController@destroy');
Route::put('comments/{comment}', '\Laravelista\Comments\CommentsController@update');
Route::post('comments/{comment}', '\Laravelista\Comments\CommentsController@reply');