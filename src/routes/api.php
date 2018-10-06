<?php
Route::group([
    'middleware' => 'api',
    'namespace'  => "Bitfumes\Blogg\Http\Controllers",
    'prefix'     => 'api'
], function () {
    Route::resource('blog', 'BlogController');
});
