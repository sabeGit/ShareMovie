<?php

namespace App\Repositories;

interface MovieRepositoryInterface
{
    /**
     * idからmovieを取得
     *
     * @var $movie_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getMovieById($movie_id);

    /**
     * movieを作成
     *
     * @var $obj id, title, poster_path, overview
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($obj);

    /**
     * movieとstaffを紐づけ
     *
     */
    public function attachStaffs($movie, $staffArray);

    /**
     * 映画の平均評価を取得（ユーザー情報付き）
     *
     * @return Movie|平均評価付き映画
     */
    public function getMovieWithAvgRatingAndUserInfo($movie_id, $user_id);

    /**
     * 映画の平均評価を取得
     *
     * @return Movie|平均評価付き映画
     */
    public function getMoviesWithAvgRating($movieIds);

    /**
     * 映画の平均評価を取得（ユーザー情報付き）
     *
     * @return Movie|平均評価付き映画
     */
    public function getMoviesWithAvgRatingAndUserInfo($movieIds, $user_id);

    // /**
    //  * 映画の平均評価を取得
    //  *
    //  * @return Movie
    //  */
    // public function getMoviesWithAvgRatingById($movie_id);

    // /**
    //  * 映画の平均評価とユーザー情報を取得
    //  *
    //  * @param Model|$movie|映画
    //  * @return int|平均評価
    //  */
    // public function getMoviesWithAvgRatingWithUser($movie_id);

    /**
     * userとmovieの紐づき情報を取得(単数)
     *
     */
    public function getAttachedMovieById($user, $movie_id);

    /**
     * userのお気に入り映画リストを取得
     *
     */
    public function getFavMovies($user);

    /**
     * userの視聴済み映画リストを取得
     *
     */
    public function getWatchedMovies($user);
}
