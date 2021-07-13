<?php

Route::namespace('Setting')->prefix('setting')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 系统设置
    Route::get('/system', 'SystemController@index')->name('setting/system.index');
    Route::post('/system', 'SystemController@submit')->name('setting/system.submit');
    Route::post('/system/cache', 'SystemController@cacheSubmit')->name('setting/system.submit');

    // 应用设置
    Route::get('/app', 'AppController@index')->name('setting/app.index');
    Route::post('/app', 'AppController@submit')->name('setting/app.submit');

    // 消息设置
    Route::get('/message', 'MessageController@index')->name('setting/message.index');
    Route::post('/message', 'MessageController@submit')->name('setting/message.submit');
    Route::get('/message/template', 'MessageController@template')->name('setting/message.index');
    Route::get('/message/template/edit', 'MessageController@templateEdit')->name('setting/message.submit');
    Route::post('/message/template/edit', 'MessageController@templateEditSubmit')->name('setting/message.submit');

    // 支付渠道
    Route::get('/payment', 'PaymentController@list')->name('setting/payment.index');
    Route::get('/payment/config', 'PaymentController@config')->name('setting/payment/config.submit');
    Route::post('/payment/config', 'PaymentController@configSubmit')->name('setting/payment/config.submit');

    // 物流设置
    Route::get('/logistics', 'LogisticsController@index')->name('setting/logistics.index');
    Route::post('/logistics', 'LogisticsController@submit')->name('setting/logistics.submit');

    // 快递公司
    Route::get('/logistics/company', 'ExpressController@list')->name('setting/logistics.index');
    Route::get('/logistics/company/add', 'ExpressController@add')->name('setting/logistics.submit');
    Route::post('/logistics/company/add', 'ExpressController@addSubmit')->name('setting/logistics.submit');
    Route::get('/logistics/company/edit', 'ExpressController@edit')->name('setting/logistics.submit');
    Route::post('/logistics/company/edit', 'ExpressController@editSubmit')->name('setting/logistics.submit');
    Route::post('/logistics/company/sort', 'ExpressController@sortSubmit')->name('setting/logistics.submit');
    Route::post('/logistics/company/remove', 'ExpressController@removeSubmit')->name('setting/logistics.submit');

    // 运费模板
    Route::get('/logistics/template', 'TemplateController@list')->name('setting/logistics.index');
    Route::get('/logistics/template/add', 'TemplateController@add')->name('setting/logistics.submit');
    Route::post('/logistics/template/add', 'TemplateController@addSubmit')->name('setting/logistics.submit');
    Route::get('/logistics/template/edit', 'TemplateController@edit')->name('setting/logistics.submit');
    Route::post('/logistics/template/edit', 'TemplateController@editSubmit')->name('setting/logistics.submit');
    Route::post('/logistics/template/sort', 'TemplateController@sortSubmit')->name('setting/logistics.submit');
    Route::post('/logistics/template/remove', 'TemplateController@removeSubmit')->name('setting/logistics.submit');
});
