<?php

namespace App\Services;

use App\Repositories\MovieRepositoryInterface;

use App\Services\HelperService;
use App\Services\StaffService;

class MovieService
{

    protected $movieRepo;
    protected $helperService, $staffService;

    public function __construct(
        MovieRepositoryInterface $movieRepo,
        HelperService $helperService,
        StaffService $staffService
    ) {
        $this->movieRepo = $movieRepo;
        $this->helperService = $helperService;
        $this->staffService = $staffService;
    }

    /**
     * idからmovieを取得
     *
     * @var $movie_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getMovieById($movie_id)
    {
        return $this->movieRepo->getMovieById($movie_id);
    }

    /**
     * movieを作成
     *
     * @var $obj id, title, poster_path, overview
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($obj)
    {
        return $this->movieRepo->create($obj);
    }

    /**
     * movieとstaffを紐づけ
     *
     */
    public function attachStaffs($movie, $staffArray)
    {
        return $this->movieRepo->attachStaffs($movie, $staffArray);
    }

    /**
     * 映画の平均評価を取得（ユーザー情報付き）
     *
     * @param array|$movieIds|映画id
     * @return Movie|平均評価
     */
    public function getMoviesWithAvgRatingAndUserInfo($movieIds, $user_id)
    {
        return $this->movieRepo->getMoviesWithAvgRatingAndUserInfo($movieIds, $user_id);
    }

    /**
     * 映画の平均評価を取得
     *
     * @param array|$movieIds|映画id
     * @return Movie|平均評価
     */
    public function getMoviesWithAvgRating($movieIds)
    {
        return $this->movieRepo->getMoviesWithAvgRating($movieIds);
    }

    /**
     * 映画の平均評価を取得（ユーザー情報付き）
     *
     * @param int|$movie_id|映画id
     * @return Movie|平均評価付き映画
     */
    public function getMovieWithAvgRatingAndUserInfo($movie_id, $user_id)
    {
        return $this->movieRepo->getMovieWithAvgRatingAndUserInfo($movie_id, $user_id);
    }

    public function getAttachedMovieById($user, $movie_id)
    {
        return $this->movieRepo->getAttachedMovieById($user, $movie_id);
    }

    public function getAllAttachedMovies($user)
    {
        return $this->movieRepo->getAllAttachedMovies($user);
    }

    public function getFavMovies($user)
    {
        return $this->movieRepo->getFavMovies($user);
    }

    public function getWatchedMovies($user)
    {
        return $this->movieRepo->getWatchedMovies($user);
    }

    public function getMovieUserRelInfo($movieList)
    {
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

    /**
     * 対象映画を映画マスタから取得 or 映画マスタに存在しない場合、requestをもとに映画レコードを作成
     *
     * @param Array|$movie|映画 (json)
     * @return Object
     */
    public function getMovieFromDB($targetMovie)
    {
        // 対象映画を映画マスタから取得
        $movie = $this->getMovieById($targetMovie['id']);
        // 映画マスタに存在しない場合、requestをもとに映画レコードを作成
        if(!$movie) {
            $movie = $this->createMovieAndStaff($targetMovie);
        }
        return $movie;
    }

    public function createMovieAndStaff($targetMovie)
    {
        $creditArray = $this->helperService->getCredits($targetMovie, 3);  // クレジット情報を取得
        $targetStaff = $this->staffService->create($creditArray);          // クレジット情報をもとにstaffレコード作成
        $movie = $this->create($targetMovie);                // 映画情報をもとにmovieレコード作成
        $this->attachStaffs($movie, $targetStaff);           // movieレコードとstaffレコードを紐づけ
        return $movie;
    }
}
