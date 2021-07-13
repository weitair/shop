<?php

Route::middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    Route::get('/', 'ArticleController@list')->name('article.list');
    Route::get('/add', 'ArticleController@add')->name('article.add');
    Route::post('/add', 'ArticleController@addSubmit')->name('article.add');
    Route::get('/edit', 'ArticleController@edit')->name('article.edit');
    Route::post('/edit', 'ArticleController@editSubmit')->name('article.edit');
    Route::post('/status', 'ArticleController@statusSubmit')->name('article.add.edit');
    Route::post('/remove', 'ArticleController@removeSubmit')->name('article.remove');

    Route::get('/category', 'CategoryController@list')->name('article/category.list');
    Route::get('/category/add', 'CategoryController@add')->name('article/category.add');
    Route::post('/category/add', 'CategoryController@addSubmit')->name('article/category.add');
    Route::get('/category/edit', 'CategoryController@edit')->name('article/category.edit');
    Route::post('/category/edit', 'CategoryController@editSubmit')->name('article/category.edit');
    Route::post('/category/status', 'CategoryController@statusSubmit')->name('article/category.add.edit');
    Route::post('/category/sort', 'CategoryController@sortSubmit')->name('article/category.add.edit');
    Route::post('/category/remove', 'CategoryController@removeSubmit')->name('article/category.remove');

    Route::get('/banner', 'BannerController@list')->name('article/banner.list');
    Route::get('/banner/add', 'BannerController@add')->name('article/banner.add');
    Route::post('/banner/add', 'BannerController@addSubmit')->name('article/banner.add');
    Route::get('/banner/edit', 'BannerController@edit')->name('article/banner.edit');
    Route::post('/banner/edit', 'BannerController@editSubmit')->name('article/banner.edit');
    Route::post('/banner/status', 'BannerController@statusSubmit')->name('article/banner.add.edit');
    Route::post('/banner/sort', 'BannerController@sortSubmit')->name('article/banner.add.edit');
    Route::post('/banner/remove', 'BannerController@removeSubmit')->name('article/banner.remove');
});
