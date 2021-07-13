<?php

Route::middleware(['sign'])->group(function () {
    Route::get('/', 'ArticleController@index');
    Route::get('/list', 'ArticleController@list');
    Route::get('/detail', 'ArticleController@detail');
});
