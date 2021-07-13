<?php

Route::namespace('Select')->prefix('select')->middleware(['sign', 'auth.admin'])->group(function () {

    // 选择客户
    Route::get('/member/list', 'MemberController@list');

    // 选择优惠卷
    Route::get('/coupon/list', 'CouponController@list');

    // 选择商品
    Route::get('/goods', 'GoodsController@index');
    Route::get('/goods/list', 'GoodsController@list');

    // 选择分类
    Route::get('/category/list', 'CategoryController@list');

    // 选择素材
    Route::get('/assets', 'AssetsController@index');
    Route::get('/assets/list', 'AssetsController@list');
    Route::post('/assets/move', 'AssetsController@moveSubmit');
    Route::post('/assets/remove', 'AssetsController@removeSubmit');
    Route::post('/assets/upload', 'AssetsController@uploadSubmit');
    Route::post('/assets/remote', 'AssetsController@remoteSubmit');
    Route::post('/assets/group/add', 'AssetsController@groupAddSubmit');

    // 选择微页面
    Route::get('/page/list', 'PageController@list');

    // 选择文章
    Route::get('/article/list', 'ArticleController@list');
});
