<?php

Route::middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 数据
    Route::get('/', 'IndexController@index')->name('coupon.index');
    Route::get('/statistic', 'IndexController@statistic')->name('coupon.index');

    // 优惠卷
    Route::get('/list', 'CouponController@list')->name('coupon.list');
    Route::get('/add', 'CouponController@add')->name('coupon.add');
    Route::post('/add', 'CouponController@addSubmit')->name('coupon.add');
    Route::get('/edit', 'CouponController@edit')->name('coupon.edit');
    Route::post('/edit', 'CouponController@editSubmit')->name('coupon.edit');
    Route::post('/status', 'CouponController@statusSubmit')->name('coupon.add.edit');
    Route::get('/push', 'CouponController@push')->name('coupon.push');
    Route::post('/push', 'CouponController@pushSubmit')->name('coupon.push');
    Route::post('/remove', 'CouponController@removeSubmit')->name('coupon.remove');

    // 优惠卷领取
    Route::get('/receive', 'ReceiveController@list')->name('coupon/receive.list');
    Route::post('/receive/remove', 'ReceiveController@removeSubmit')->name('coupon/receive.remove');
});
