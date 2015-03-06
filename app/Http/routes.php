<?php

Route::get('/', function () {
    return 'Home Page';
});

Route::resource('articles', 'ArticleController');

Route::controllers([
   'auth' => 'Auth\AuthController',
]);
