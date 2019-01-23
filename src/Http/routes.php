<?php

Route::group(['prefix' => 'api/blog'], function () {
    Route::post('search/category/{query}', 'CategoryController@search');
    Route::apiResource('category', 'CategoryController');
    Route::apiResource('tag', 'TagController');
    // frontend
    Route::post('/', 'BlogController@index')->name('blog.index');
    // Backend
    Route::post('/all', 'BlogController@all')->name('blog.all');
    Route::post('/store', 'BlogController@store')->name('blog.store');
    Route::post('/tag/{tag}', 'BlogController@byTag')->name('blog.show.bytag');
    Route::post('{blog}/like', 'LikeController@likeIt')->name('blog.like');
    Route::delete('{blog}/like', 'LikeController@unLikeIt')->name('blog.unlike');

    Route::post('/{category}', 'BlogController@byCategory')->name('blog.show.bycategory');
    Route::delete('/{category}/{blog}', 'BlogController@destroy')->name('blog.destroy');
    // frontend
    Route::post('/{category}/{blog}', 'BlogController@show')->name('blog.show');
    // Backend
    Route::patch('/{blog}', 'BlogController@edit')->name('blog.edit');
    Route::put('/{blog}', 'BlogController@update')->name('blog.update');
});
