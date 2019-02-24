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

// APIのURL以外のリクエストに対してはindexテンプレートを返す
// 画面遷移はフロントエンドのVueRouterが制御する
Route::get('/{any?}', function () {
    return view('index');
})->where('any', '.+');

// Auth::routes(['verify' => true]);

// Route::get('/users/{id?}', 'UserController@show')->name('users.show');
//
// Route::get('/home', 'HomeController@index')->name('home');
//
// Route::get('/movies/search', 'MovieController@search')->name('movies.search');
// Route::get('/movies/{id?}', 'MovieController@show')->name('movies.show');
