<?php

Route::resource('posts', 'PostController');
Route::get('/', 'PostController@index');
