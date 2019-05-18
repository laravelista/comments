<?php

Route::post('comments', config('comments.controller') . '@store');
Route::delete('comments/{comment}', config('comments.controller') . '@destroy');
Route::put('comments/{comment}', config('comments.controller') . '@update');
Route::post('comments/{comment}', config('comments.controller') . '@reply');