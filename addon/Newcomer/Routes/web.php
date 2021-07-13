<?php

Route::middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 新人奖励
    Route::get('/index', 'NewcomerController@index')->name('newcomer.index');
    Route::post('/index', 'NewcomerController@submit')->name('newcomer.submit');
});
