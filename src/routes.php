<?php

Route::post('comments', config('comments.controller') . '@store')->name('comments.store');
Route::delete('comments/{comment}', config('comments.controller') . '@destroy')->name('comments.destroy');
Route::put('comments/{comment}', config('comments.controller') . '@update')->name('comments.update');
Route::post('comments/{comment}', config('comments.controller') . '@reply')->name('comments.reply');