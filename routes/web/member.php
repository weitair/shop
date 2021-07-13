<?php

Route::namespace('Member')->prefix('member')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 列表
    Route::get('/profile', 'Profile\ProfileController@index')->name('member/profile.list');
    Route::get('/profile/list', 'Profile\ProfileController@list')->name('member/profile.list');
    Route::get('/profile/detail', 'Profile\ProfileController@detail')->name('member/profile.detail');
    Route::get('/profile/order', 'Profile\ProfileController@order')->name('member/profile.detail');
    Route::get('/profile/comment', 'Profile\ProfileController@comment')->name('member/profile.detail');
    Route::get('/profile/coupon', 'Profile\ProfileController@coupon')->name('member/profile.detail');
    Route::get('/profile/point', 'Profile\ProfileController@point')->name('member/profile.detail');
    Route::get('/profile/address', 'Profile\ProfileController@address')->name('member/profile.detail');

    Route::get('/profile/edit', 'Profile\EditController@edit')->name('member/profile/edit.info');
    Route::post('/profile/edit', 'Profile\EditController@editSubmit')->name('member/profile/edit.info');
    Route::get('/profile/edit/tag', 'Profile\EditController@tag')->name('member/profile/edit.tag');
    Route::post('/profile/edit/tag', 'Profile\EditController@tagSubmit')->name('member/profile/edit.tag');
    Route::get('/profile/edit/tag/batch', 'Profile\EditController@tagBatch')->name('member/profile/edit.tag');
    Route::post('/profile/edit/tag/batch', 'Profile\EditController@tagBatchSubmit')->name('member/profile/edit.tag');
    Route::post('/profile/edit/point', 'Profile\EditController@pointBatchSubmit')->name('member/profile/edit.point');

    // 标签
    Route::get('/tag', 'TagController@list')->name('member/tag.list');
    Route::get('/tag/add', 'TagController@add')->name('member/tag.add');
    Route::post('/tag/add', 'TagController@addSubmit')->name('member/tag.add');
    Route::get('/tag/edit', 'TagController@edit')->name('member/tag.edit');
    Route::post('/tag/edit', 'TagController@editSubmit')->name('member/tag.edit');
    Route::post('/tag/sort', 'TagController@sortSubmit')->name('member/tag.add.edit');
    Route::post('/tag/remove', 'TagController@removeSubmit')->name('member/tag.remove');

    // 等级
    Route::get('/level', 'LevelController@list')->name('member/level.list');
    Route::get('/level/edit', 'LevelController@edit')->name('member/level.edit');
    Route::post('/level/edit', 'LevelController@editSubmit')->name('member/level.edit');

    //反馈
    Route::get('/feedback', 'Feedback\FeedbackController@index')->name('member/feedback.list');
    Route::get('/feedback/list', 'Feedback\FeedbackController@list')->name('member/feedback.list');
    Route::post('/feedback/remove', 'Feedback\FeedbackController@removeSubmit')->name('member/feedback.remove');

    // 反馈分类
    Route::get('/feedback/category', 'Feedback\CategoryController@list')
        ->name('member/feedback/category.list');
    Route::get('/feedback/category/add', 'Feedback\CategoryController@add')
        ->name('member/feedback/category.add');
    Route::post('/feedback/category/add', 'Feedback\CategoryController@addSubmit')
        ->name('member/feedback/category.add');
    Route::get('/feedback/category/edit', 'Feedback\CategoryController@edit')
        ->name('member/feedback/category.edit');
    Route::post('/feedback/category/edit', 'Feedback\CategoryController@editSubmit')
        ->name('member/feedback/category.edit');
    Route::post('/feedback/category/sort', 'Feedback\CategoryController@sortSubmit')
        ->name('member/feedback/category.add.edit');
    Route::post('/feedback/category/remove', 'Feedback\CategoryController@removeSubmit')
        ->name('member/feedback/category.remove');
});
