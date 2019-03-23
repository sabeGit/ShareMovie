<?php
namespace App\Repositories;
use App\Models\Movie;
use App\User;

class MovieRepository implements MovieRepositoryInterface {

    protected $movie;

    public function __construct(Movie $movie) {
        $this->movie = $movie;
    }

    /**
     * idからmovieを取得
     *
     * @var $movie_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getMovieById($movie_id) {
        return $this->movie->find($movie_id);
    }

    /**
     * movieを作成
     *
     * @var $obj id, title, poster_path, overview
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($movie) {
        $movie = Movie::updateOrCreate(
            ['id'          => $movie['id']],
            ['title'       => $movie['title'],
             'poster_path' => $movie['poster_path'],
             'overview'    => $movie['overview']]
        );
        return $movie;
    }

    /**
     * movieとstaffを紐づけ
     *
     */
    public function attachStaffs($movie, $staffArray) {
        foreach ($staffArray as $job => $staffInfos) {
            foreach($staffInfos as $staffInfo) {
                $targetMovie = $movie->staffs()->where('id', $staffInfo->id)->get();
                if ($targetMovie->isEmpty()) {
                    $movie->staffs()->attach($staffInfo->id);
                }
                if ($job == 'casts') {
                    $movie->staffs()->updateExistingPivot($staffInfo->id, ['is_actor' => true]);
                } else {
                    $movie->staffs()->updateExistingPivot($staffInfo->id, ['is_crew' => true]);
                }
            }
        }
        return $movie;
    }

    /**
     * 平均評価付き映画情報を取得（複数）
     *
     * @param array|$movieIds|映画id
     * @return Movie|平均評価付き映画
     */
    public function getMoviesWithAvgRatingAndUserInfo($movieIds, $user_id) {
        return $movies = Movie::with([
            'users' => function($query) use($user_id) {
                $query->where('id', $user_id);
            },
            'staffs'
        ])->whereIn('id', $movieIds)->get();
    }

    /**
     * 映画の平均評価を取得
     *
     * @param array|$movieIds|映画id
     * @return Movie|平均評価付き映画
     */
    public function getMoviesWithAvgRating($movieIds) {
        return $movies = Movie::with(['avgRating', 'staffs'])->whereIn('id', $movieIds)->get();
    }

    /**
     * 平均評価付き映画情報を取得（単数）
     *
     * @param int|$movie_id|映画id
     * @return Movie|平均評価付き映画
     */
    public function getMovieWithAvgRatingAndUserInfo($movie_id, $user_id) {
        return $movie = Movie::with([
            'avgRating',
            'users' => function($query) use($user_id) {
                $query->where('id', $user_id)->first();
            },
            'staffs',
            'posts.user',
            'posts.movie'
        ])->where('id', $movie_id)->first();
    }

    /**
     * userとmovieの紐づき情報を取得（単数）
     *
     * @param Model|$user|ユーザー
     * @param int|$movie_id|映画id
     * @return array|映画（単数）
     */
    public function getAttachedMovieById($user, $movie_id) {
        return $movieList = $user->movies()->where('id', $movie_id)->get();
    }

    /**
     * userのお気に入り映画リストを取得
     *
     */
    public function getFavMovies($user) {
        return $movieList = $user->movies()->where('movie_user_rels.favorite', true)->get();
    }

    /**
     * userの視聴済み映画リストを取得
     *
     */
    public function getWatchedMovies($user) {
        return $movieList = $user->movies()->where('movie_user_rels.watched', true)->get();
    }
}
