<?php

namespace App\Repositories;

interface UserRepositoryInterface
{

    /**
     * ユーザーを取得　取得条件：ユーザーネーム
     *
     * @param string $username
     * @return User
     */
    public function getUserByName($username);

    /**
     * 映画のお気に入り情報を更新
     *
     * @param User    $user
     * @param boolean $favorite
     * @param int     $movie_id
     * @return void
     */
    public function editFavoriteMovie($user, $favorite, $movie_id);

    /**
     * 映画の視聴済み情報を更新
     *
     * @param User    $user
     * @param boolean $watched
     * @param int     $movie_id
     * @return void
     */
    public function editWatchedMovie($user, $watched, $movie_id);

    /**
     * 映画のお気に入り情報を更新
     *
     * @param User $user
     * @param int  $favorite
     * @param int  $movie_id
     * @return void
     */
    public function editMovieRating($user, $rating, $movie_id);

    /**
     * ユーザーのアカウント情報（ユーザーネーム、プロフィール画像）を更新
     *
     * @param User   $user
     * @param string $username
     * @param string $imageUrl
     * @return void
     */
    public function editAccount($user, $username, $imageUrl);

}
