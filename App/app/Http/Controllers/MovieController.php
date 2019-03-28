<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\HelperService;
use App\Services\MovieService;

class MovieController extends Controller
{
    /**
     * 汎用サービスクラスインスタンス
     */
    protected $helperService;
    /**
     * 映画サービスクラスインスタンス
     */
    protected $movieService;

    /**
     * フリーワード検索URL
     */
    const SEARCH_BASE_URL    = 'https://api.themoviedb.org/3/search/movie';
    /**
     * ID検索URL
     */
    const GET_BY_ID_BASE_URL = 'https://api.themoviedb.org/3/movie/';
    /**
     * 人気映画検索URL
     */
    const POPULAR_BASE_URL   = 'https://api.themoviedb.org/3/movie/popular';

    /**
     * コンストラクタ
     */
    public function __construct(
        MovieService $movieService,
        HelperService $helperService
    ) {
        $this->movieService  = $movieService;
        $this->helperService = $helperService;
    }

    /**
     * 検索キーワード(freeword)を条件にTMDbAPIで映画を検索
     *
     * @param Request $request
     * @return json
     */
    public function search(Request $request)
    {
        // freewordが空の場合、APIを実行しない
        $freeword = $request->freeword;
        if ($freeword == '') {
            $movies = [];
        } else {
            // リクエストURLの生成
            $freeword = str_replace(array(' ', '　'), '+', $freeword);
            $params = array(
                'api_key'=>env('TMDB_ACCESSKEY'),
                'query'=>$freeword,
                'language'=>'ja'
            );
            $url = $this->helperService->createUrlWithParams(
                self::SEARCH_BASE_URL,
                $params
            );

            // TMDbAPIをコール & jsonデコード
            $json_str = file_get_contents($url);
            $json_obj = json_decode($json_str);
            $movies   = $json_obj->results;
        }

        // API取得映画のサイト内平均評価を取得
        $movieIds  = $this->helperService->getMovieIdsFromSearchRes($movies);
        $moviesWithAvgRating = $this->movieService->getMoviesWithAvgRating($movieIds);

        // API取得映画に平均評価を付与
        foreach ($movies as $movie) {
            $movie->avgRating = 0;
            foreach ($moviesWithAvgRating as $movieWithAvgRating) {
                if ($movie->id == $movieWithAvgRating->id)
                $movie->avgRating = intval($movieWithAvgRating->avgRating);
            }
        }

        return response()->json($movies);
    }

    /**
     * 映画IDを条件にTMDbAPIで映画を検索
     *
     * @param Request $request
     * @return json
     */
    public function getMovieById(Request $request)
    {
        // リクエストURLの生成
        $params = array(
            'api_key'            => env('TMDB_ACCESSKEY'),
            'language'           => 'ja',
            'append_to_response' => 'credits,videos'
        );
        $url = $this->helperService->createUrlWithParams(
            self::GET_BY_ID_BASE_URL . $request->movieId,
            $params
        );

        // TMDbAPIをコール & jsonデコード
        $json_str    = file_get_contents($url);
        $movie       = json_decode($json_str);

        // APIから取得した映画オブジェクトに追加プロパティの初期値を設定
        if ($movie) {
            $movie->favorite  = 0;
            $movie->watched   = 0;
            $movie->rating    = 0;
            $movie->avgRating = 0;
            $movie->posts     = null;
        }

        // 平均評価付き映画オブジェクトを取得
        $movieWithAvgRatingAndUserInfo =
            $this->movieService->getMovieWithAvgRatingAndUserInfo(
                $request->input('movieId'),
                $request->input('userId')
            );

        // APIから取得した映画オブジェクトにDBから取得した追加プロパティの値を設定
        if ($movieWithAvgRatingAndUserInfo) {
            if (count($movieWithAvgRatingAndUserInfo->users)) {
                $movie->favorite = $movieWithAvgRatingAndUserInfo->users[0]->pivot->favorite;
                $movie->watched  = $movieWithAvgRatingAndUserInfo->users[0]->pivot->watched;
                $movie->rating   = $movieWithAvgRatingAndUserInfo->users[0]->pivot->rating;
            }
            $movie->posts     = $movieWithAvgRatingAndUserInfo->posts;
            $movie->avgRating = intval($movieWithAvgRatingAndUserInfo->avgRating);
        }

        return response()->json($movie);
    }

    /**
     * TMDbから人気映画を取得
     * ホーム画面の背景画像に使用
     *
     * @param Request $request
     * @return json
     */
    public function getPopularMovieFromTMDB()
    {
        // リクエストURLの生成
        $params = array(
            'api_key'=>env('TMDB_ACCESSKEY'),
            'language'=>'ja'
        );
        $url = $this->helperService->createUrlWithParams(
            self::POPULAR_BASE_URL,
            $params
        );

        // TMDbAPIをコール & jsonデコード
        $json_str = file_get_contents($url);
        $json_obj = json_decode($json_str);
        $movies   = $json_obj->results;

        return response()->json($movies[0]);
    }
}
