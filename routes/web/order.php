<?php

Route::namespace('Order')->prefix('order')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 订单
    Route::get('/record', 'OrderController@list')->name('order/record.list');
    Route::get('/record/detail', 'OrderController@detail')->name('order/record.detail');
    Route::get('/record/shipment', 'OrderController@shipment')->name('order/record.shipment');
    Route::post('/record/shipment', 'OrderController@shipmentSubmit')->name('order/record.shipment');
    Route::get('/record/logistics', 'OrderController@logistics')->name('order/record.logistics');
    Route::post('/record/logistics', 'OrderController@logisticsSubmit')->name('order/record.logistics');
    Route::get('/record/remark', 'OrderController@remark')->name('order/record.remark');
    Route::post('/record/remark', 'OrderController@remarkSubmit')->name('order/record.remark');
    Route::get('/record/price', 'OrderController@price')->name('order/record.price');
    Route::post('/record/price', 'OrderController@priceSubmit')->name('order/record.price');
    Route::post('/record/receive', 'OrderController@receiveSubmit')->name('order/record.receive');
    Route::post('/record/prints', 'OrderController@printsSubmit')->name('order/record.prints');

    //核销
    Route::get('/verify', 'VerifyController@list')->name('order/verify.list');
    Route::get('/verify/search', 'VerifyController@search')->name('order/verify.list');
    Route::post('/verify/submit', 'VerifyController@submit')->name('order/verify.submit');

    // 发票
    Route::get('/invoice', 'InvoiceController@list')->name('order/invoice.list');
    Route::get('/invoice/make', 'InvoiceController@make')->name('order/invoice.make');
    Route::post('/invoice/make', 'InvoiceController@makeSubmit')->name('order/invoice.make');

    // 评论
    Route::get('/comment/list', 'CommentController@list')->name('order/comment.list');
    Route::get('/comment/reply', 'CommentController@reply')->name('order/comment.reply');
    Route::post('/comment/reply', 'CommentController@replySubmit')->name('order/comment.reply');
    Route::post('/comment/audit', 'CommentController@auditSubmit')->name('order/comment.audit');
    Route::post('/comment/remove', 'CommentController@removeSubmit')->name('order/comment.remove');

    //设置
    Route::get('/setting', 'SettingController@index')->name('order/setting.index');
    Route::post('/setting', 'SettingController@submit')->name('order/setting.submit');
});
