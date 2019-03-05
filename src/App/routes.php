<?php

Route::get('blog', 'PostsController@index');
Route::get('blog/{slug}', 'PostsController@show');