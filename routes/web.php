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

Route::get('/', 'PagesController@index');
Route::get('/about','PagesController@about');
Route::get('/services','PagesController@services');
//Route::get('/users/{id}/{name}', function ($id,$name) {
//    return $id. " ".  $name;
//});

// connects routes to all the resource functions created in PostsController
Route::resource('posts','PostsController');

//came after make:auth
Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
