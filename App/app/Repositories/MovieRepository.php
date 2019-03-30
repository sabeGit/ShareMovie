<?php
namespace App\Repositories;
use App\Models\Movie;
use App\User;

class MovieRepository implements MovieRepositoryInterface
{

    protected $movie;

    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    /**
     * idからmovieを取得
     *
     * @param int $movie_id
     * @return Movie
     */
    public function getMovieById($movie_id)
    {
        return $this->movie->find($movie_id);
    }

    /**
     * movieを作成
     *
     * @param object $movie
     * @return Movie
     */
    public function create($movie)
    {
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
     * @param Movie $movie
     * @param array $staffArray
     * @return void
     */
    public function attachStaffs($movie, $staffArray)
    {
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
     * 映画の平均評価を取得（ユーザー情報付き）（単数）
     *
     * @param int $movie_id
     * @param int $user_id
     * @return Movie
     */
    public function getMovieWithAvgRatingAndUserInfo($movie_id, $user_id)
    {
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
     * 映画の平均評価を取得（ユーザー情報付き）（複数）
     *
     * @param array $movieIds
     * @param int   $user_id
     * @return Movie
     */
    public function getMoviesWithAvgRatingAndUserInfo($movieIds, $user_id)
    {
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
     * @param array $movieIds
     * @return Movie
     */
    public function getMoviesWithAvgRating($movieIds)
    {
        return $movies = Movie::with([
            'avgRating',
            'staffs'
        ])->whereIn('id', $movieIds)->get();
    }
}
