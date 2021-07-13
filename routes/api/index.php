<?php

Route::middleware(['sign'])->group(function () {

    Route::post('/upload/{action}/{width?}/{height?}', 'UploadController@index');

    /**
     * 鉴权
     */
    Route::post('/auth/login', 'AuthController@index');
    Route::get('/auth/login/wechat', 'AuthController@wechat');
    Route::get('/auth/login/wechat/appid', 'AuthController@appid');
    Route::post('/auth/login/weapp', 'AuthController@weapp');
    Route::post('/auth/login/password', 'AuthController@password');
    Route::post('/auth/login/code', 'AuthController@code');
    Route::post('/auth/login/fetch/code', 'AuthController@loginCode');

    // 注册
    Route::post('/auth/register', 'AuthController@register');
    Route::post('/auth/register/fetch/code', 'AuthController@registerCode');
    Route::post('/auth/register/weapp', 'AuthController@weappRegister');

    // index
    Route::get('/index', 'IndexController@index');
    Route::get('/index/about', 'IndexController@about');
    Route::get('/index/popupwindow', 'IndexController@popupwindow');

    // 页面
    Route::get('/page', 'PageController@index');
    Route::get('/page/home', 'PageController@home');
    Route::get('/page/cart', 'PageController@cart');
    Route::get('/page/mine', 'PageController@mine');

    // 反馈
    Route::get('/feedback', 'FeedbackController@index');
    Route::post('/feedback/submit', 'FeedbackController@submit');
});

Route::post('/payment/notify', 'PaymentController@notify');
