<?php

Route::get('blog', '\Swiftmade\Blogdown\Http\Controllers\PostsController@index');
Route::get('blog/{slug}', '\Swiftmade\Blogdown\Http\Controllers\PostsController@show');
