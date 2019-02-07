<?php

use Illuminate\Http\Request;
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

Route::get('/', function () {
    $posts = \App\Post::all();
    return view('welcome', ['posts' => $posts]);
});

// Admin add new post
Route::get('/add-post', function () {
    return view('new-post');
});

// Admin list all posts
Route::get('/list-posts', 'PostController@list_all');

//Handle post submission form
Route::post('/submit-post', 'PostController@add_post');

Route::post('/read-one', 'PostController@read_one');

Route::post('/update-post', 'PostController@update_data');

Route::post('/delete-post', 'PostController@delete_data');

// Admin list all galleries
Route::get('/galleries', 'GalleryController@list_all');
 
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
