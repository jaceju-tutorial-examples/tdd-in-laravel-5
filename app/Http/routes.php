<?php

Route::get('/', function () {
    return 'Home Page';
});

Route::resource('posts', 'PostController');

Route::controllers([
   'auth' => 'Auth\AuthController',
]);
