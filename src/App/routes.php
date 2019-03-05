<?php

Route::get('blog', '\Swiftmade\Blogdown\App\Controllers\PostsController@index');
Route::get('blog/{slug}', '\Swiftmade\Blogdown\App\Controllers\PostsController@show');
