<?php

Route::namespace('Goods')->prefix('goods')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 商品
    Route::get('/stock', 'GoodsController@index')->name('goods/stock.list');
    Route::get('/stock/list', 'GoodsController@list')->name('goods/stock.list');
    Route::get('/stock/add', 'GoodsController@add')->name('goods/stock.add');
    Route::post('/stock/add', 'GoodsController@addSubmit')->name('goods/stock.add');
    Route::get('/stock/edit', 'GoodsController@edit')->name('goods/stock.edit');
    Route::post('/stock/edit', 'GoodsController@editSubmit')->name('goods/stock.edit');
    Route::get('/stock/edit/content', 'GoodsController@content')->name('goods/stock.edit');
    Route::post('/stock/edit/content', 'GoodsController@contentSubmit')->name('goods/stock.edit');
    Route::get('/stock/edit/sale', 'GoodsController@sale')->name('goods/stock.edit');
    Route::post('/stock/edit/sale', 'GoodsController@saleSubmit')->name('goods/stock.edit');
    Route::get('/stock/edit/logistics', 'GoodsController@logistics')->name('goods/stock.edit');
    Route::post('/stock/edit/logistics', 'GoodsController@logisticsSubmit')->name('goods/stock.edit');
    Route::get('/stock/edit/other', 'GoodsController@other')->name('goods/stock.edit');
    Route::post('/stock/edit/other', 'GoodsController@otherSubmit')->name('goods/stock.edit');
    Route::post('/stock/status', 'GoodsController@statusSubmit')->name('goods/stock.add.edit');
    Route::post('/stock/sort', 'GoodsController@sortSubmit')->name('goods/stock.add.edit');
    Route::post('/stock/recover', 'GoodsController@recoverSubmit')->name('goods/stock.add.edit');
    Route::post('/stock/spec', 'GoodsController@specSubmit')->name('goods/stock.add.edit');
    Route::post('/stock/spec/value', 'GoodsController@specValueSubmit')->name('goods/stock.add.edit');
    Route::post('/stock/remove', 'GoodsController@removeSubmit')->name('goods/stock.remove');
    Route::post('/stock/remove/force', 'GoodsController@forceRemoveSubmit')->name('goods/stock.remove');
    Route::get('/stock/category', 'GoodsController@category')->name('goods/stock.add.edit');
    Route::post('/stock/category', 'GoodsController@categorySubmit')->name('goods/stock.add.edit');

    // 商品分类
    Route::get('/category', 'CategoryController@list')->name('goods/category.list');
    Route::get('/category/add', 'CategoryController@add')->name('goods/category.add');
    Route::post('/category/add', 'CategoryController@addSubmit')->name('goods/category.add');
    Route::get('/category/edit', 'CategoryController@edit')->name('goods/category.edit');
    Route::post('/category/edit', 'CategoryController@editSubmit')->name('goods/category.edit');
    Route::post('/category/status', 'CategoryController@statusSubmit')->name('goods/category.add.edit');
    Route::post('/category/sort', 'CategoryController@sortSubmit')->name('goods/category.add.edit');
    Route::post('/category/remove', 'CategoryController@removeSubmit')->name('goods/category.remove');

    // 商品分组
    Route::get('/group', 'GroupController@list')->name('goods/group.list');
    Route::get('/group/add', 'GroupController@add')->name('goods/group.add');
    Route::post('/group/add', 'GroupController@addSubmit')->name('goods/group.add');
    Route::get('/group/edit', 'GroupController@edit')->name('goods/group.edit');
    Route::post('/group/edit', 'GroupController@editSubmit')->name('goods/group.edit');
    Route::post('/group/status', 'GroupController@statusSubmit')->name('goods/group.add.edit');
    Route::post('/group/sort', 'GroupController@sortSubmit')->name('goods/group.add.edit');
    Route::post('/group/remove', 'GroupController@removeSubmit')->name('goods/group.remove');

    // 商品规格
    Route::get('/spec', 'SpecController@list')->name('goods/spec.list');
    Route::get('/spec/add', 'SpecController@add')->name('goods/spec.add');
    Route::post('/spec/add', 'SpecController@addSubmit')->name('goods/spec.add');
    Route::get('/spec/edit', 'SpecController@edit')->name('goods/spec.edit');
    Route::post('/spec/edit', 'SpecController@editSubmit')->name('goods/spec.edit');
    Route::post('/spec/sort', 'SpecController@sortSubmit')->name('goods/spec.add.edit');
    Route::post('/spec/remove', 'SpecController@removeSubmit')->name('goods/spec.remove');
    Route::post('/spec/value/add', 'SpecController@addValueSubmit')->name('goods/spec.add.edit');
    Route::post('/spec/value/remove', 'SpecController@removeValueSubmit')->name('goods/spec.add.edit');

    // 商品支持
    Route::get('/support', 'SupportController@list')->name('goods/support.list');
    Route::get('/support/add', 'SupportController@add')->name('goods/support.add');
    Route::post('/support/add', 'SupportController@addSubmit')->name('goods/support.add');
    Route::get('/support/edit', 'SupportController@edit')->name('goods/support.edit');
    Route::post('/support/edit', 'SupportController@editSubmit')->name('goods/support.edit');
    Route::post('/support/status', 'SupportController@statusSubmit')->name('goods/support.add.edit');
    Route::post('/support/sort', 'SupportController@sortSubmit')->name('goods/support.add.edit');
    Route::post('/support/remove', 'SupportController@removeSubmit')->name('goods/support.remove');

    // 单位
    Route::get('/unit', 'UnitController@list')->name('goods/unit.list');
    Route::get('/unit/add', 'UnitController@add')->name('goods/unit.add');
    Route::post('/unit/add', 'UnitController@addSubmit')->name('goods/unit.add');
    Route::get('/unit/edit', 'UnitController@edit')->name('goods/unit.edit');
    Route::post('/unit/edit', 'UnitController@editSubmit')->name('goods/unit.edit');
    Route::post('/unit/sort', 'UnitController@sortSubmit')->name('goods/unit.add.edit');
    Route::post('/unit/remove', 'UnitController@removeSubmit')->name('goods/unit.remove');

    //设置
    Route::get('/setting', 'SettingController@index')->name('goods/setting.index');
    Route::post('/setting', 'SettingController@submit')->name('goods/setting.submit');
});
