<?php

Route::namespace('Channel')->prefix('channel')->middleware(['auth.admin', 'permission'])->group(function () {
    Route::get('/weapp/release/download', 'Weapp\ReleaseController@download')->name('channel/weapp/release.download');
});

Route::namespace('Channel')->prefix('channel')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    /**
     * 公众号
     */
    // 粉丝
    Route::get('/wechat/fans', 'Wechat\FansController@list')->name('channel/wechat/fans.list');
    Route::post('/wechat/fans/sync', 'Wechat\FansController@syncSubmit')->name('channel/wechat/fans.sync');

    // 设置
    Route::get('/wechat/setting', 'Wechat\SettingController@index')->name('channel/wechat/setting.index');
    Route::post('/wechat/setting', 'Wechat\SettingController@submit')->name('channel/wechat/setting.submit');

    /**
     * 小程序
     */
    // 发布小程序
    Route::get('/weapp/release', 'Weapp\ReleaseController@index')->name('channel/weapp/release.index');

    // 订阅消息
    Route::get('/weapp/subscribe', 'Weapp\SubscribeController@list')->name('channel/weapp/subscribe.list');
    Route::post('/weapp/subscribe/sync', 'Weapp\SubscribeController@syncSubmit')->name('channel/weapp/subscribe.sync');
    Route::post('/weapp/subscribe/status', 'Weapp\SubscribeController@statusSubmit')->name('channel/weapp/subscribe.status');

    // 设置
    Route::get('/weapp/setting', 'Weapp\SettingController@index')->name('channel/weapp/setting.index');
    Route::post('/weapp/setting', 'Weapp\SettingController@submit')->name('channel/weapp/setting.submit');

    /**
     * H5
     */
    // 发布H5
    Route::get('/h5/release', 'H5\ReleaseController@index')->name('channel/h5/release.index');
    Route::post('/h5/release/submit', 'H5\ReleaseController@submit')->name('channel/h5/release.submit');
});
