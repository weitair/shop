<?php

Route::prefix('mine')->middleware(['sign', 'auth'])->group(function () {
    Route::get('/', 'MineController@index');
});
