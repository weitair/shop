<?php

Route::namespace('Shop')->prefix('shop')->middleware(['sign', 'auth.admin'])->group(function () {
    Route::get('/design/goods/group', 'DesignController@goodsGroup');
    Route::get('/design/link', 'DesignController@link');
});

Route::namespace('Shop')->prefix('shop')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 装修
    Route::get('/design', 'DesignController@home')->name('shop/design.index');
    Route::post('/design', 'DesignController@homeSubmit')->name('shop/design.submit');
    Route::get('/design/tabbar', 'DesignController@tabbar')->name('shop/design/tabbar.index');
    Route::post('/design/tabbar', 'DesignController@tabbarSubmit')->name('shop/design/tabbar.submit');
    Route::get('/design/category', 'DesignController@category')->name('shop/design/category.index');
    Route::post('/design/category', 'DesignController@categorySubmit')->name('shop/design/category.submit');
    Route::get('/design/mine', 'DesignController@mine')->name('shop/design/mine.index');
    Route::post('/design/mine', 'DesignController@mineSubmit')->name('shop/design/mine.submit');
    Route::get('/design/cart', 'DesignController@cart')->name('shop/design/cart.index');
    Route::post('/design/cart', 'DesignController@cartSubmit')->name('shop/design/cart.submit');


    // 页面
    Route::get('/page', 'PageController@list')->name('shop/page.list');
    Route::get('/page/add', 'PageController@add')->name('shop/page.add');
    Route::post('/page/add', 'PageController@addSubmit')->name('shop/page.add');
    Route::get('/page/edit', 'PageController@edit')->name('shop/page.edit');
    Route::post('/page/edit', 'PageController@editSubmit')->name('shop/page.edit');
    Route::post('/page/home', 'PageController@homeSubmit')->name('shop/page.add.edit');
    Route::post('/page/status', 'PageController@statusSubmit')->name('shop/page.add.edit');
    Route::post('/page/sort', 'PageController@sortSubmit')->name('shop/page.add.edit');
    Route::post('/page/remove', 'PageController@removeSubmit')->name('shop/page.remove');

    // 地址
    Route::get('/address', 'AddressController@list')->name('shop/address.list');
    Route::get('/address/add', 'AddressController@add')->name('shop/address.add');
    Route::post('/address/add', 'AddressController@addSubmit')->name('shop/address.add');
    Route::get('/address/edit', 'AddressController@edit')->name('shop/address.edit');
    Route::post('/address/edit', 'AddressController@editSubmit')->name('shop/address.edit');
    Route::post('/address/status', 'AddressController@statusSubmit')->name('shop/address.add.edit');
    Route::post('/address/sort', 'AddressController@sortSubmit')->name('shop/address.add.edit');
    Route::post('/address/remove', 'AddressController@removeSubmit')->name('shop/address.remove');

    // 员工
    Route::get('/employee', 'EmployeeController@list')->name('shop/employee.list');
    Route::get('/employee/add', 'EmployeeController@add')->name('shop/employee.add');
    Route::post('/employee/add', 'EmployeeController@addSubmit')->name('shop/employee.add');
    Route::get('/employee/edit', 'EmployeeController@edit')->name('shop/employee.edit');
    Route::post('/employee/edit', 'EmployeeController@editSubmit')->name('shop/employee.edit');
    Route::post('/employee/status', 'EmployeeController@statusSubmit')->name('shop/employee.add.edit');
    Route::post('/employee/remove', 'EmployeeController@removeSubmit')->name('shop/employee.remove');

    //设置
    Route::get('/setting', 'SettingController@index')->name('shop/setting.index');
    Route::post('/setting', 'SettingController@submit')->name('shop/setting.submit');
});
