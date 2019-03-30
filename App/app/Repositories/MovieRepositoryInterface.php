<?php

namespace App\Repositories;

interface MovieRepositoryInterface
{
    /**
     * idからmovieを取得
     *
     * @param int $movie_id
     * @return Movie
     */
    public function getMovieById($movie_id);

    /**
     * movieを作成
     *
     * @param object $movie
     * @return Movie
     */
    public function create($movie);

    /**
     * movieとstaffを紐づけ
     *
     * @param Movie $movie
     * @param array $staffArray
     * @return void
     */
    public function attachStaffs($movie, $staffArray);

    /**
     * 映画の平均評価を取得（ユーザー情報付き）（単数）
     *
     * @param int $movie_id
     * @param int $user_id
     * @return Movie
     */
    public function getMovieWithAvgRatingAndUserInfo($movie_id, $user_id);

    /**
     * 映画の平均評価を取得（ユーザー情報付き）（複数）
     *
     * @param array $movieIds
     * @param int   $user_id
     * @return Movie
     */
    public function getMoviesWithAvgRatingAndUserInfo($movieIds, $user_id);

    /**
     * 映画の平均評価を取得
     *
     * @param array $movieIds
     * @return Movie
     */
    public function getMoviesWithAvgRating($movieIds);
}
