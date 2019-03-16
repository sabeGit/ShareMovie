<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\HelperService;
use App\Services\MovieService;

class MovieController extends Controller
{

    protected $helperService;

    public function __construct(MovieService $movieService, HelperService $helperService)
    {
        $this->movieService  = $movieService;
        $this->helperService = $helperService;
    }

    public function search(Request $request)
    {
        $freeword = $request->input('freeword');                    // 検索キーワード
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

        $movieIds  = $this->helperService->getMovieIdsFromSearchRes($movies);
        $moviesWithAvgRating = $this->movieService->getMoviesWithAvgRating($movieIds);
        foreach ($movies as $movie) {
            $movie->avgRating = 0;
            foreach ($moviesWithAvgRating as $movieWithAvgRating) {
                if ($movie->id == $movieWithAvgRating->id)
                $movie->avgRating = intval($movieWithAvgRating->avgRating);
            }
        }

        return $movies;
    }

    public function getMovieById(Request $request)
    {
        $baseUrl  = 'https://api.themoviedb.org/3/movie/'.$request->input('movieId');    // リクエストのベースURL
        /*
        * リクエストパラメータを生成
        * api_key            : APIキー
        * language           : 言語
        * append_to_response : 検索オプション
        */
        $params      = array('api_key'=>env('TMDB_ACCESSKEY'), 'language'=>'ja', 'append_to_response'=>'credits,videos');
        $url         = $this->helperService->createUrlWithParams($baseUrl, $params);  // パラメータ付きのリクエストURLを取得
        $json_str    = file_get_contents($url);    // URLからAPIを実行
        $movie       = json_decode($json_str);     // jsonをobjectに変換
        if ($movie) {
            $movie->favorite = 0;
            $movie->watched = 0;
            $movie->rating = 0;
            $movie->avgRating = 0;
            $movie->posts = null;
        }
        $movieWithAvgRatingAndUserInfo = $this->movieService->getMovieWithAvgRatingAndUserInfo($request->input('movieId'), $request->input('userId'));
        if ($movieWithAvgRatingAndUserInfo) {
            if (count($movieWithAvgRatingAndUserInfo->users)) {
                $movie->favorite = $movieWithAvgRatingAndUserInfo->users[0]->pivot->favorite;
                $movie->watched = $movieWithAvgRatingAndUserInfo->users[0]->pivot->watched;
                $movie->rating = $movieWithAvgRatingAndUserInfo->users[0]->pivot->rating;
            }
            $movie->posts = $movieWithAvgRatingAndUserInfo->posts;
            $movie->avgRating = intval($movieWithAvgRatingAndUserInfo->avgRating);
        }
        return response()->json($movie);
    }

    public function getPopularMovieFromTMDB()
    {
        $baseUrl  = 'https://api.themoviedb.org/3/movie/popular';    // リクエストのベースURL
        /*
        * リクエストパラメータを生成
        * api_key            : APIキー
        * language           : 言語
        */
        $params      = array('api_key'=>env('TMDB_ACCESSKEY'), 'language'=>'ja');
        $url         = $this->helperService->createUrlWithParams($baseUrl, $params);  // パラメータ付きのリクエストURLを取得
        $json_str = file_get_contents($url);    // URLからAPIを実行
        $json_obj = json_decode($json_str);     // jsonをobjectに変換
        $movies   = $json_obj->results;
        return response()->json($movies[0]);
    }
}
