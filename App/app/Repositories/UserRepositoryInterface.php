<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    /**
     * idからuserを取得
     *
     * @var $user_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getById($user_id);

    /**
     * nameからuserを取得
     *
     * @var $username
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getUserByName($username);

    /**
     * nameから映画が紐づいたuserを取得
     *
     * @var $username
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getUserByNameWithMovies($username);

    /**
     * お気に入り映画リストを編集
     *
     */
    public function editFavoriteMovie($user, $favorite, $movie_id);

    /**
     * 視聴済み映画リストを編集
     *
     */
    public function editWatchedMovie($user, $watched, $movie_id);

    /**
     * 評価を編集
     *
     */
    public function editMovieRating($user, $rating, $movie_id);

    /**
     * 評価を編集
     *
     */
    public function editAccount($user, $username, $imageUrl);


    // /**
    //  * userとmovieの紐づき情報を取得(条件：movie_id)
    //  *
    //  */
    // public function getAttachedMoviesById($user, $movie_id);
    //
    // /**
    //  * userとmovieの紐づき情報を取得(条件：なし)
    //  *
    //  */
    // public function getAllAttachedMovies($user);
    //
    // /**
    //  * userのお気に入り映画リストを取得
    //  *
    //  */
    // public function getFavMovies($user);
    //
    // /**
    //  * userの視聴済み映画リストを取得
    //  *
    //  */
    // public function getWatchedMovies($user);

}
