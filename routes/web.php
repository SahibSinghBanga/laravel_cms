<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::middleware(['auth'])->group(function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('categories', 'CategoriesController');
    Route::resource('posts', 'PostsController');
    Route::resource('tags', 'TagsController');
    Route::get('trashed-posts', 'PostsController@trashed')->name('trashed-posts.index');
    Route::put('restore-posts/{post}', 'PostsController@restore')->name('restore-posts');
});
