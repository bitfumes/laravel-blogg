<?php
Route::group(['middleware' => 'web'], function () {
    Route::resource('post', 'PostController');
});
