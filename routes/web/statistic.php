<?php

Route::namespace('Statistic')->prefix('statistic')->middleware(['sign', 'auth.admin'])->group(function () {

    Route::get('/dashboard/operations', 'DashboardController@operations');
    Route::get('/dashboard/goods', 'DashboardController@goods');
    Route::get('/dashboard/card', 'DashboardController@card');
    Route::get('/dashboard/todo', 'DashboardController@todo');

    Route::get('/goods/card', 'GoodsController@card');
    Route::get('/goods/view', 'GoodsController@view');
    Route::get('/goods/sale', 'GoodsController@sale');
    Route::get('/goods/payment', 'GoodsController@payment');

    Route::get('/order/card', 'OrderController@card');
    Route::get('/order/global', 'OrderController@global');

    Route::get('/member/global', 'MemberController@global');
    Route::get('/member/channel', 'MemberController@channel');
    Route::get('/member/province', 'MemberController@province');

    Route::get('/finance/card', 'FinanceController@card');
    Route::get('/finance/global', 'FinanceController@global');
});
