<?php

Route::prefix('verify')->middleware(['sign', 'auth'])->group(function () {
    Route::get('/', 'VerifyController@index');
    Route::post('/', 'VerifyController@submit');
});
