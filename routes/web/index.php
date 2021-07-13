<?php

Route::middleware(['sign'])->group(function () {

    Route::post('/auth', 'AuthController@index');
    Route::post('/auth/logout', 'AuthController@logout');
    Route::get('/auth/setting', 'AuthController@setting');
});

Route::middleware(['sign', 'auth.admin'])->group(function () {

    Route::get('/index/addon', 'IndexController@addon');
    Route::get('/index/link', 'IndexController@link');

    Route::get('/profile', 'ProfileController@index');
    Route::post('/profile/change', 'ProfileController@change');
    Route::post('/profile/password', 'ProfileController@password');

    Route::post('/upload/{action}/{width?}/{height?}', 'UploadController@index');
});
