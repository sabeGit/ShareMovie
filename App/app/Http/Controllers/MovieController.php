<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\HelperService;
use App\Services\MovieService;

class MovieController extends Controller {

    protected $helperService;

    public function __construct(MovieService $movieService, HelperService $helperService) {
        $this->movieService  = $movieService;
        $this->helperService = $helperService;
    }

    public function search(Request $request) {
        $noimage  = asset('img/noimage.png');                       // poster_pathがnullだった場合、代わりに表示する画像
        $freeword = $request->input('freeword');                    // 検索キーワード
        \Debugbar::info($request);
        $baseUrl  = 'https://api.themoviedb.org/3/search/movie';    // リクエストのベースURL

        if ($freeword == '') {
            $movies = [];
        } else {
            $freeword = str_replace(array(' ', '　'), '+', $freeword);
            /*
            * リクエストパラメータを生成
            * api_key  : APIキー
            * query    : 検索キーワード
            * language : 言語
            */
            $params   = array('api_key'=>env('TMDB_ACCESSKEY'), 'query'=>$freeword, 'language'=>'ja');
            $url      = $this->helperService->createUrlWithParams($baseUrl, $params);  // パラメータ付きのリクエストURLを取得
            $json_str = file_get_contents($url);    // URLからAPIを実行
            $json_obj = json_decode($json_str);     // jsonをobjectに変換
            $movies   = $json_obj->results;
        }

        return $movies;
    }

    public function getMovieById(Request $request) {
        \Debugbar::info($request);
        $movie = $this->movieService->getMovieWithAvgRating($request->input('movieId'), $request->input('userId'));
        return $movie;
    }
    // public function getMovieById(Request $request) {
    //     $baseUrl  = 'https://api.themoviedb.org/3/movie/'.$request;    // リクエストのベースURL
    //     /*
    //     * リクエストパラメータを生成
    //     * api_key            : APIキー
    //     * language           : 言語
    //     * append_to_response : 検索オプション
    //     */
    //     $params      = array('api_key'=>env('TMDB_ACCESSKEY'), 'language'=>'ja', 'append_to_response'=>'credits,videos');
    //     $url         = $this->helperService->createUrlWithParams($baseUrl, $params);  // パラメータ付きのリクエストURLを取得
    //     $json_str    = file_get_contents($url);    // URLからAPIを実行
    //     $movie       = json_decode($json_str);     // jsonをobjectに変換
    //     $creditArray = $this->helperService->getCredits($movie, 3);  // クレジット情報を取得
    //     // $trailer     = $this->getTrailer();
    //
    //     return view('movies.show', compact('movie', 'creditArray'));
    // }

    // private function getTrailer($id) {
    //     $baseUrl = 'https://api.themoviedb.org/3/movie/'.$id;   // リクエストのベースURL
    //     /*
    //     * リクエストパラメータを生成
    //     * api_key            : APIキー
    //     * language           : 言語
    //     * append_to_response : 検索オプション
    //     */
    //     $params      = array('api_key'=>env('TMDB_ACCESSKEY'), 'language'=>'en', 'append_to_response'=>'credits');
    //     $url         = $this->createUrlWithParams($baseUrl, $params);  // パラメータ付きのリクエストURLを取得
    //     $json_str    = file_get_contents($url);    // URLからAPIを実行
    //     $movie       = json_decode($json_str);     // jsonをobjectに変換
    //
    // }
}
