<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\HelperService;
use App\Services\MovieService;

class MovieController extends Controller
{

    protected $helperService;
    protected $movieService;

    /**
     * コンストラクタ
     */
    public function __construct(MovieService $movieService, HelperService $helperService)
    {
        $this->movieService  = $movieService;
        $this->helperService = $helperService;
    }

    /**
     * searchメソッド
     */
    public function search(Request $request)
    {
        $freeword = $request->freeword;                    // 検索キーワード
        if ($freeword == '') {
            $movies = [];
        } else {
            $freeword = str_replace(array(' ', '　'), '+', $freeword);
            $params = array(                                  // リクエストパラメータを生成
                          'api_key'=>env('TMDB_ACCESSKEY'),   // APIキー
                          'query'=>$freeword,                 // 検索キーワード
                          'language'=>'ja'                    // 言語
                      );

            $url = $this->helperService->createUrlWithParams(       // パラメータ付きのリクエストURLを取得
                                             config('url.SEARCH_BASE_URL'),
                                             $params
                                         );
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
        return response()->json($movies);
    }

    public function getMovieById(Request $request)
    {
        // リクエストURLの生成
        $params = array(                                             // リクエストパラメータを生成
                    'api_key'            => env('TMDB_ACCESSKEY'),   // APIキー
                    'language'           => 'ja',                    // 言語
                    'append_to_response' => 'credits,videos'         // 検索オプション
                  );
        $url = $this->helperService->createUrlWithParams(       // パラメータ付きのリクエストURLを取得
                                        config('url.GET_BY_ID_BASE_URL').$request->movieId,
                                        $params
                                     );

        // TMDbAPIをコール & jsonデコード
        $json_str    = file_get_contents($url);    // URLからAPIを実行
        $movie       = json_decode($json_str);     // jsonをobjectに変換

        // APIから取得した映画オブジェクトに追加プロパティの初期値を設定
        if ($movie) {
            $movie->favorite  = 0;      // お気に入り
            $movie->watched   = 0;      // 視聴済み
            $movie->rating    = 0;      // 評価
            $movie->avgRating = 0;      // 平均評価
            $movie->posts     = null;   // コメント
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
                $movie->favorite = $movieWithAvgRatingAndUserInfo->users[0]->pivot->favorite;   // お気に入り
                $movie->watched  = $movieWithAvgRatingAndUserInfo->users[0]->pivot->watched;    // 視聴済み
                $movie->rating   = $movieWithAvgRatingAndUserInfo->users[0]->pivot->rating;     // 評価
            }
            $movie->posts     = $movieWithAvgRatingAndUserInfo->posts;              // コメント
            $movie->avgRating = intval($movieWithAvgRatingAndUserInfo->avgRating);  // 平均評価
        }
        // \Debugbar::info($movie);
        return response()->json($movie);
    }

    public function getPopularMovieFromTMDB()
    {
        // TMDbAPIをコール
        $params      = array(                                   // リクエストパラメータを生成
                           'api_key'=>env('TMDB_ACCESSKEY'),    // APIキー
                           'language'=>'ja'                     // 言語
                       );
        $url = $this->helperService->createUrlWithParams(    // パラメータ付きのリクエストURLを取得
                                         config('url.POPULAR_BASE_URL'),
                                         $params
                                     );
        $json_str = file_get_contents($url);    // URLからAPIを実行
        $json_obj = json_decode($json_str);     // jsonをobjectに変換

        $movies   = $json_obj->results;
        return response()->json($movies[0]);
    }
}
