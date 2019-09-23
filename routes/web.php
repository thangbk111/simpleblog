<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/show/{slug}', 'PostController@showPostDetail')->name('show_post');

Route::group(['prefix' => 'posts', 'middleware' => 'auth'], function () {
    Route::get('/', 'PostController@showMyPost')->name('my_post');
    Route::get('create', 'PostController@create')->name('create_post');
    Route::post('store', 'PostController@store')->name('store_post');
    Route::get('/edit/{slug}', 'PostController@edit')->name('edit_post');
    Route::post('/update/{slug}', 'PostController@update')->name('update_post');
    Route::post('/delete/{id}', 'PostController@delete')->name('delete_post');
});

Route::group(['prefix' => 'admin'], function() {
    Route::get('/posts', 'PostManagerController@list')->name('list_post');
    Route::post('/schedule_post/{postId}', 'PostManagerController@setSchedulePost')->name('schedule_post');
    Route::post('/unpublish_post/{postId}', 'PostManagerController@unpublishPost')->name('unpublish_post');
});