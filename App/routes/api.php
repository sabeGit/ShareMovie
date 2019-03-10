<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');
// ログイン
Route::post('/login', 'Auth\AuthController@login')->name('login');
// 本登録メール確認
Route::get('/register/verify', 'Auth\RegisterController@verify')->name('verify');
// 本登録メール再送
Route::get('/register/verify/resend', 'Auth\RegisterController@resendVerifyMail')->name('resend');
// パスワードリセットメール送信
Route::get('/password', 'Auth\ForgotPasswordController@sendPasswordResetMail')->name('password');
// パスワードリセットメール確認
Route::get('/password/verify', 'Auth\ForgotPasswordController@verifyPasswordResetMail')->name('verify.password');
// パスワードリセット
Route::post('/password/reset', 'Auth\ResetPasswordController@resetPassword')->name('reset.password');

Route::get('/movie/search', 'MovieController@search')->name('searchMovies');

Route::get('/movie', 'MovieController@getMovieById')->name('getMovieById');

Route::get('/user', 'UserController@getUserByName')->name('getUser');

// ユーザーのお気に入り・視聴映画リスト取得
Route::get('/user/movie', 'UserController@getAllAttachedMovies')->name('getAllMovies');;
// ユーザーお気に入り映画
Route::get('/user/movie/fav', 'UserController@getFavMovies');
// ユーザー視聴映画
Route::get('/user/movie/watched', 'UserController@getWatchedMovies');


// Route::get('/user', function () {
//     return Auth::user();
// })->name('user');

Route::group(['middleware' => 'auth:api'], function() {
    // コメントを投稿
    Route::post('posts', 'PostController@create');
    // お気に入り映画リストを編集
    Route::post('/user/movie/fav', 'UserController@editFavoriteMovie');
    // 視聴済み映画リストを編集
    Route::post('/user/movie/watched', 'UserController@editWatchedMovie');
    // 評価を編集
    Route::post('/user/movie/rating', 'UserController@editMovieRating');
    // ユーザーアカウント情報を編集
    Route::post('/user/account', 'UserController@editAccount');
    // ログアウト
    Route::post('/logout', 'Auth\LoginController@logout')->middleware('jwt.refresh')->name('logout');
    // ログインユーザー
    Route::get("/me", "Auth\AuthController@me");
});
