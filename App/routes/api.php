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

// 「register」グループ
Route::group(['prefix' => 'register'], function() {
    // 会員登録
    Route::post('/', 'Auth\RegisterController@register')->name('register');
    // 本登録メール確認
    Route::get('/verify', 'Auth\RegisterController@verify')->name('verify');
    // 本登録メール再送
    Route::get('/verify/resend', 'Auth\RegisterController@resendVerifyMail')->name('resendVerifyMail');
});

// 「password」グループ
Route::group(['prefix' => 'password'], function() {
    // パスワードリセットメール送信
    Route::get('/', 'Auth\ForgotPasswordController@sendPasswordResetMail')->name('sendPasswordResetMail');
    // パスワードリセット
    Route::post('/reset', 'Auth\ResetPasswordController@resetPassword')->name('resetPassword');
});

// 「movie」グループ
Route::group(['prefix' => 'movie'], function() {
    // Idを条件に映画情報を取得
    Route::get('/', 'MovieController@getMovieById')->name('getMovieById');
    // TMDbの映画を検索
    Route::get('/search', 'MovieController@search')->name('searchMovies');
    // 人気映画をTMDBから取得
    Route::get('/popular', 'MovieController@getPopularMovieFromTMDB')->name('getPopularMovieFromTMDB');
});

// 「user」グループ
Route::group(['prefix' => 'user'], function() {
    // ユーザーネームを条件にユーザーを取得
    Route::get('/', 'UserController@getUserByName')->name('getUserByName');
    // ユーザーのお気に入り・視聴映画リスト取得
    Route::get('/movie', 'UserController@getAllAttachedMovies')->name('getAllMovies');
    // 認証あり
    Route::group(['middleware' => 'auth:api'], function() {
        // お気に入り映画リストを編集
        Route::post('/movie/fav', 'UserController@editFavoriteMovie')->name('editFavoriteMovie');
        // 視聴済み映画リストを編集
        Route::post('/movie/watched', 'UserController@editWatchedMovie')->name('editWatchedMovie');
        // 評価を編集
        Route::post('/movie/rating', 'UserController@editMovieRating')->name('editMovieRating');
        // ユーザーアカウント情報を編集
        Route::post('/account', 'UserController@editAccount')->name('editAccount');
    });
});

// その他認証が必要なルート
Route::group(['middleware' => 'auth:api'], function() {
    // コメントを投稿
    Route::post('/posts', 'PostController@create')->name('createPost');
    // ログアウト
    Route::post('/logout', 'Auth\LoginController@logout')->middleware('jwt.refresh')->name('logout');
    // ログインユーザー
    Route::get("/me", "Auth\AuthController@me")->name('me');
});

// ログイン
Route::post('/login', 'Auth\AuthController@login')->name('login');
