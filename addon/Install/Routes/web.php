<?php

Route::prefix('install')->group(function() {
    Route::get('/', 'InstallController@index');
    Route::get('/step2', 'InstallController@step2');
    Route::get('/step3', 'InstallController@step3');
    Route::get('/step4', 'InstallController@step4');
    Route::get('/step5', 'InstallController@step5');
    Route::get('/detect', 'InstallController@detect');
    Route::post('/test', 'InstallController@test');
    Route::post('/check', 'InstallController@check');
    Route::post('/submit', 'InstallController@submit');
});
