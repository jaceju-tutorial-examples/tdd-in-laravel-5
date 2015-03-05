<?php

Route::get('/', function () {
    return 'Home Page';
});

Route::resource('posts', 'PostController');
