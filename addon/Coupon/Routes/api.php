<?php

Route::middleware(['sign'])->group(function () {
    Route::get('/', 'CouponController@index');
});

Route::middleware(['sign', 'auth'])->group(function () {
    Route::post('/receive', 'CouponController@receive');
    Route::get('/mine', 'CouponController@mine');
});
