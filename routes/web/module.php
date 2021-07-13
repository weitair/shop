<?php

Route::namespace('System')->prefix('system')->middleware(['sign', 'auth.admin'])->group(function () {

    // 模块
    Route::get('/module', 'ModuleController@list')->name('system/module.list');
    Route::get('/module/add', 'ModuleController@add')->name('system/module.submit');
    Route::post('/module/add', 'ModuleController@addSubmit')->name('system/module.submit');
    Route::get('/module/edit', 'ModuleController@edit')->name('system/module.submit');
    Route::post('/module/edit', 'ModuleController@editSubmit')->name('system/module.submit');
    Route::get('/module/sort', 'ModuleController@sort')->name('system/module.submit');
    Route::post('/module/sort', 'ModuleController@sortSubmit')->name('system/module.submit');
    Route::post('/module/remove', 'ModuleController@removeSubmit')->name('system/module.remove');
});
