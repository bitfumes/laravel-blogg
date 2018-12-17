<?php

Route::group(['prefix' => 'api'], function () {
    Route::post('search/category/{query}', 'CategoryController@search');
    Route::apiResource('category', 'CategoryController');
    Route::apiResource('tag', 'TagController');

    Route::group(['prefix'=>'blog'], function () {
        Route::post('/', 'BlogController@index')->name('blog.index');
        Route::post('/store', 'BlogController@store')->name('blog.store');
        Route::put('/{blog}', 'BlogController@update')->name('blog.update');
        Route::delete('/{blog}', 'BlogController@destroy')->name('blog.destroy');
        Route::post('/{category}/{blog}', 'BlogController@show')->name('blog.show');
        Route::post('/{tag}/{blog}', 'BlogController@show')->name('blog.show');
    });

    Route::post('{blog}/like', 'LikeController@likeIt')->name('blog.like');
    Route::post('{blog}/unlike', 'LikeController@unLikeIt')->name('blog.unlike');
});

Route::get('/{view?}', 'HomeController@index')->where('view', '(.*)')->name('blogg');
