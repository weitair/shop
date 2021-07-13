<?php

Route::prefix('goods')->middleware(['sign'])->group(function () {

    Route::get('/', 'GoodsController@index');
    Route::get('/list', 'GoodsController@list');
    Route::get('/detail', 'GoodsController@detail');
    Route::get('/comment', 'GoodsController@comment');
    Route::get('/comment/list', 'GoodsController@commentList');
    Route::get('/category', 'CategoryController@index');
    Route::get('/category/item', 'CategoryController@goods');
    Route::get('/poster', 'GoodsController@poster');

    // 搜索
    Route::post('/search', 'SearchController@search');
    Route::post('/search/clear', 'SearchController@clear');
    Route::get('/search/history', 'SearchController@history');
});

Route::prefix('goods')->middleware(['sign', 'auth'])->group(function () {

    Route::post('/favorite', 'GoodsController@favorite');
});
