<?php
Route::group([
    'middleware' => 'web',
    'namespace'  => "Bitfumes\Blogg\Http\Controllers"
], function () {
    Route::resource('category', 'CategoryController');
    Route::group(['prefix'=>'blog'], function () {
        Route::get('/', 'BlogController@index')->name('blog.index');
        Route::post('/', 'BlogController@store')->name('blog.store');
        Route::put('/{blog}', 'BlogController@update')->name('blog.update');
        Route::delete('/{blog}', 'BlogController@destroy')->name('blog.destroy');
        Route::get('/{category}/{blog}', 'BlogController@show')->name('blog.show');
    });
});
