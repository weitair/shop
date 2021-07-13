<?php

Route::prefix('member')->middleware(['sign', 'auth'])->group(function () {
    Route::get('/', 'MemberController@index');
    Route::post('/avatar', 'MemberController@avatar');
    Route::post('/change', 'MemberController@change');

    /**
     * 收货地址
     */
    Route::get('/address', 'AddressController@index');
    Route::get('/address/detail', 'AddressController@detail');
    Route::get('/address/add', 'AddressController@add');
    Route::post('/address/save', 'AddressController@save');
    Route::post('/address/save/local', 'AddressController@saveLocal');
    Route::post('/address/remove', 'AddressController@remove');

    /**
     * 发票
     */
    Route::get('/invoice', 'InvoiceController@index');
    Route::post('/invoice/save', 'InvoiceController@save');

    /**
     * 收藏
     */
    Route::get('/favorite', 'FavoriteController@index');
    Route::post('/favorite/remove', 'FavoriteController@remove');

    /**
     * 历史
     */
    Route::get('/history', 'HistoryController@index');
    Route::post('/history/remove', 'HistoryController@remove');
});
