<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Movie;
use App\Models\Staff;
use App\Services\UserService;
use App\Services\MovieService;
use App\Services\StaffService;
use App\Services\HelperService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class UserController extends Controller {

    protected $userService;
    protected $movieService;
    protected $staffService;
    protected $helperService;

    public function __construct(UserService $userService, MovieService $movieService, StaffService $staffService, HelperService $helperService) {
        $this->userService   = $userService;
        $this->movieService  = $movieService;
        $this->staffService  = $staffService;
        $this->helperService = $helperService;
    }

    public function getUserByName(Request $request) {
        $user = $this->userService->getUserByName($request->input('username'));
        return $user;
    }

    public function getMovieUserRelByMovieId(Request $request) {
        $movieList = $this->movieService->getAttachedMoviesById($request->user(), $request->input('movie_id'));
        $movieListInfo = $this->movieService->getMovieUserRelInfo($movieList);
        return $movieListInfo;
    }

    public function getAllAttachedMovies(Request $request) {
        $movies = $this->getMoviesWithAvgRatingByUsername($request->input('username'));
        \Debugbar::info($movies);
        return $movies;
    }

    public function getFavMovies(Request $request) {
        $user = $this->userService->getByName($request->input('username'));
        $movieList = $this->movieService->getFavMovies($user);
        return $movieList;
    }

    public function getWatchedMovies(Request $request) {
        $user = $this->userService->getByName($request->input('username'));
        $movieList = $this->movieService->getWatchedMovies($user);
        return $movieList;
    }

    public function editFavoriteMovie(Request $request) {
        // 対象映画を映画マスタから取得
        $movie = $this->getMovieRecord($request->movie);
        // お気に入り映画リストを編集
        $this->userService->editFavoriteMovie($request->user(), $request->favorite, $movie->id);
        $movies = $this->getMoviesWithAvgRatingByUsername($request->user()->name);
        return $movies;
    }

    public function editWatchedMovie(Request $request) {
        // 対象映画を映画マスタから取得
        $movie = $this->getMovieRecord($request->movie);
        // 視聴済み映画リストを編集
        $this->userService->editWatchedMovie($request->user(), $request->watched, $movie->id);
        $movies = $this->getMoviesWithAvgRatingByUsername($request->user()->name);
        return $movies;
    }

    public function editMovieRating(Request $request) {
        // 対象映画を映画マスタから取得
        $movie = $this->getMovieRecord($request->movie);
        // 視聴済み映画リストを編集
        $this->userService->editMovieRating($request->user(), $request->rating, $movie->id);
        $movies = $this->getMoviesWithAvgRatingByUsername($request->user()->name);
        return $movies;
    }

    private function getMovieRecord($targetMovie) {
        // 映画マスタからidを条件に映画レコードを取得
        $movie = $this->movieService->getById($targetMovie['id']);
        // 映画マスタに存在しない場合、requestをもとに映画レコードを作成
        if(!$movie) {
            $movie = $this->editMovieUserRel($targetMovie);
        }
        return $movie;
    }

    private function editMovieUserRel($targetMovie) {
        $creditArray = $this->helperService->getCredits($targetMovie, 3);  // クレジット情報を取得
        $targetStaff = $this->staffService->create($creditArray);          // クレジット情報をもとにstaffレコード作成
        $movie = $this->movieService->create($targetMovie);                // 映画情報をもとにmovieレコード作成
        $this->movieService->attachStaffs($movie, $targetStaff);           // movieレコードとstaffレコードを紐づけ

        return $movie;
    }

    private function getMoviesWithAvgRatingByUsername($username) {
        $user = $this->userService->getUserByNameWithMovies($username);
        $movieIds = $this->userService->getMovieIdsFromUser($user);
        $movies = $this->movieService->getMoviesWithAvgRating($movieIds, $user->id);
        return $movies;
    }
}
