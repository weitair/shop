<?php

Route::prefix('cart')->middleware(['sign', 'auth'])->group(function () {
    Route::get('/', 'CartController@index');
    Route::get('/count', 'CartController@count');
    Route::post('/add', 'CartController@add');
    Route::post('/change', 'CartController@change');
    Route::post('/clear', 'CartController@clear');
    Route::post('/remove', 'CartController@remove');
});
