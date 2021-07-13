<?php

Route::namespace('System')->prefix('system')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 账号
    Route::get('/account', 'AccountController@list')->name('system/account.list');
    Route::get('/account/add', 'AccountController@add')->name('system/account.submit');
    Route::post('/account/add', 'AccountController@addSubmit')->name('system/account.submit');
    Route::get('/account/edit', 'AccountController@edit')->name('system/account.submit');
    Route::post('/account/edit', 'AccountController@editSubmit')->name('system/account.submit');
    Route::post('/account/remove', 'AccountController@removeSubmit')->name('system/account.remove');

    // 角色
    Route::get('/role', 'RoleController@list')->name('system/role.list');
    Route::get('/role/add', 'RoleController@add')->name('system/role.submit');
    Route::post('/role/add', 'RoleController@addSubmit')->name('system/role.submit');
    Route::get('/role/edit', 'RoleController@edit')->name('system/role.submit');
    Route::post('/role/edit', 'RoleController@editSubmit')->name('system/role.submit');
    Route::post('/role/remove', 'RoleController@removeSubmit')->name('system/role.remove');

    // 日志
    Route::get('/log', 'LogController@list')->name('system/log.list');
    Route::post('/log/remove', 'LogController@removeSubmit')->name('system/log.remove');

    // 素材
    Route::get('/assets', 'Assets\AssetsController@list')->name('system/assets.list');
    Route::post('/assets/remove', 'Assets\AssetsController@removeSubmit')->name('system/assets.remove');

    // 素材分组
    Route::get('/assets/group', 'Assets\GroupController@list')->name('system/assets/group.list');
    Route::get('/assets/group/add', 'Assets\GroupController@add')->name('system/assets/group.submit');
    Route::post('/assets/group/add', 'Assets\GroupController@addSubmit')->name('system/assets/group.submit');
    Route::get('/assets/group/edit', 'Assets\GroupController@edit')->name('system/assets/group.submit');
    Route::post('/assets/group/edit', 'Assets\GroupController@editSubmit')->name('system/assets/group.submit');
    Route::post('/assets/group/sort', 'Assets\GroupController@sortSubmit')->name('system/assets/group.submit');
    Route::post('/assets/group/remove', 'Assets\GroupController@removeSubmit')->name('system/assets/group.remove');

    // 链接
    Route::get('/link', 'LinkController@list')->name('system/link.list');
    Route::get('/link/add', 'LinkController@add')->name('system/link.submit');
    Route::post('/link/add', 'LinkController@addSubmit')->name('system/link.submit');
    Route::get('/link/edit', 'LinkController@edit')->name('system/link.submit');
    Route::post('/link/edit', 'LinkController@editSubmit')->name('system/link.submit');
    Route::post('/link/sort', 'LinkController@sortSubmit')->name('system/link.add.submit');
    Route::post('/link/remove', 'LinkController@removeSubmit')->name('system/link.remove');
});
