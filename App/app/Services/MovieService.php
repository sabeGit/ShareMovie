<?php

namespace App\Services;

use App\Repositories\MovieRepositoryInterface;

class MovieService {

    protected $movieRepo;

    public function __construct(MovieRepositoryInterface $movieRepo) {
        $this->movieRepo = $movieRepo;
    }

    /**
     * idからmovieを取得
     *
     * @var $movie_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getMovieById($movie_id) {
        return $this->movieRepo->getMovieById($movie_id);
    }

    /**
     * movieを作成
     *
     * @var $obj id, title, poster_path, overview
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($obj) {
        return $this->movieRepo->create($obj);
    }

    /**
     * movieとstaffを紐づけ
     *
     */
    public function attachStaffs($movie, $staffArray) {
        return $this->movieRepo->attachStaffs($movie, $staffArray);
    }

    /**
     * 映画の平均評価を取得
     *
     * @param array|$movieIds|映画id
     * @return Movie|平均評価
     */
    public function getMoviesWithAvgRating($movieIds, $user_id) {
        return $this->movieRepo->getMoviesWithAvgRating($movieIds, $user_id);
    }

    /**
     * 映画の平均評価を取得
     *
     * @param int|$movie_id|映画id
     * @return Movie|平均評価付き映画
     */
    public function getMovieWithAvgRating($movie_id, $user_id) {
        return $this->movieRepo->getMovieWithAvgRating($movie_id, $user_id);
    }

    public function getAttachedMovieById($user, $movie_id) {
        return $this->movieRepo->getAttachedMovieById($user, $movie_id);
    }

    public function getAllAttachedMovies($user) {
        return $this->movieRepo->getAllAttachedMovies($user);
    }

    public function getFavMovies($user) {
        return $this->movieRepo->getFavMovies($user);
    }

    public function getWatchedMovies($user) {
        return $this->movieRepo->getWatchedMovies($user);
    }

    public function getMovieUserRelInfo($movieList) {
        $movieListInfo = array();
        if($movieList->isEmpty()) {         // userにmovieが紐づいていない場合
            $movieListInfo['watched'] = false;
            $movieListInfo['favorite']    = false;
        } else {                           // userにmovieが紐づいている場合
            $movieListInfo['watched'] = (bool)$movieList[0]->pivot->watched;
            $movieListInfo['favorite']    = (bool)$movieList[0]->pivot->favorite;
        }
        return $movieListInfo;
    }

}
