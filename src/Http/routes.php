<?php

Route::group(['prefix' => 'api'], function () {
    Route::post('search/category/{query}', 'CategoryController@search');
    Route::apiResource('category', 'CategoryController');
    Route::apiResource('tag', 'TagController');

    Route::group(['prefix'=>'blog'], function () {
        // frontend
        Route::post('/', 'BlogController@index')->name('blog.index');
        // Backend
        Route::post('/all', 'BlogController@all')->name('blog.all');
        Route::post('/store', 'BlogController@store')->name('blog.store');
        Route::delete('/{category}/{blog}', 'BlogController@destroy')->name('blog.destroy');
        // frontend
        Route::post('/{category}/{blog}', 'BlogController@show')->name('blog.show');
        Route::post('/{tag}/{blog}', 'BlogController@show')->name('blog.show');
        // Backend
        Route::post('/{blog}', 'BlogController@edit')->name('blog.edit');
        Route::put('/{blog}', 'BlogController@update')->name('blog.update');
    });

    Route::post('{blog}/like', 'LikeController@likeIt')->name('blog.like');
    Route::delete('{blog}/like', 'LikeController@unLikeIt')->name('blog.unlike');
});
