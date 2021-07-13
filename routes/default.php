<?php

Route::any('/', function () {
    if (is_dir(base_path('public/admin'))) {
        return redirect('admin');
    }
    return redirect('install');
});
