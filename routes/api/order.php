<?php

Route::prefix('order')->middleware(['sign', 'auth'])->group(function () {
    Route::get('/', 'OrderController@index');
    Route::get('/detail', 'OrderController@detail');
    Route::post('/confirm', 'OrderController@confirm');
    Route::post('/create', 'OrderController@create');
    Route::post('/close', 'OrderController@close');
    Route::post('/receive', 'OrderController@receive');
    Route::post('/comment', 'OrderController@comment');
    Route::post('/payment', 'OrderController@payment');
    Route::post('/remove', 'OrderController@remove');
    Route::get('/verify', 'OrderController@verify');
});
