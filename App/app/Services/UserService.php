<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;

class UserService {

    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo) {
        $this->userRepo = $userRepo;
    }

    /**
     * idからuserを取得
     *
     * @var $user_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getById($user_id) {
        return $this->userRepo->getById($user_id);
    }

    public function getUserByName($username) {
        return $this->userRepo->getUserByName($username);
    }

    public function getUserByNameWithMovies($username) {
        return $this->userRepo->getUserByNameWithMovies($username);
    }

    public function editFavoriteMovie($user, $favorite, $movie_id) {
        return $this->userRepo->editFavoriteMovie($user, $favorite, $movie_id);
    }

    public function editWatchedMovie($user, $watched, $movie_id) {
        return $this->userRepo->editWatchedMovie($user, $watched, $movie_id);
    }

    public function editMovieRating($user, $rating, $movie_id) {
        return $this->userRepo->editMovieRating($user, $rating, $movie_id);
    }

    public function editAccount($user, $username, $imageUrl) {
        return $this->userRepo->editAccount($user, $username, $imageUrl);
    }

    /**
     * userコレクションに紐づいた映画idを抽出
     *
     * @param collection|$user|ユーザー
     * @return array|映画id
     */
    public function getMovieIdsFromUser($user) {
        $array = array();
        foreach ($user->movies as $movie) {
            $array[] = $movie->id;
        }
        return $array;
    }
}
