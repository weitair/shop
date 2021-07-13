<?php

Route::namespace('Finance')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 支付流水
    Route::get('/finance/payment', 'PaymentController@list')->name('finance/payment.list');
});
