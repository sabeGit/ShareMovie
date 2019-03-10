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
use App\Exceptions\Common\ExtensionException;
use App\Exceptions\Common\S3Exception;
use App\Exceptions\Common\SetUpAccountException;

class UserController extends Controller {

    protected $userService;
    protected $movieService;
    protected $staffService;
    protected $helperService;

    public function __construct(UserService $userService, MovieService $movieService, StaffService $staffService, HelperService $helperService)
    {
        $this->userService   = $userService;
        $this->movieService  = $movieService;
        $this->staffService  = $staffService;
        $this->helperService = $helperService;
    }

    public function getUserByName(Request $request)
    {
        $user = $this->userService->getUserByName($request->input('username'));
        \Debugbar::info($user);
        return $user;
    }

    public function getMovieUserRelByMovieId(Request $request)
    {
        $movieList = $this->movieService->getAttachedMoviesById($request->user(), $request->input('movie_id'));
        $movieListInfo = $this->movieService->getMovieUserRelInfo($movieList);
        return $movieListInfo;
    }

    public function getAllAttachedMovies(Request $request)
    {
        $movies = $this->getMoviesWithAvgRatingByUsername($request->input('username'));
        return $movies;
    }

    public function getFavMovies(Request $request)
    {
        $user = $this->userService->getByName($request->input('username'));
        $movieList = $this->movieService->getFavMovies($user);
        return $movieList;
    }

    public function getWatchedMovies(Request $request)
    {
        $user = $this->userService->getByName($request->input('username'));
        $movieList = $this->movieService->getWatchedMovies($user);
        return $movieList;
    }

    public function editFavoriteMovie(Request $request)
    {
        // 対象映画を映画マスタから取得 or 映画マスタに存在しない場合、requestをもとに映画レコードを作成
        $movie = $this->movieService->getMovieFromDB($request->input('movie'));
        // お気に入り映画リストを編集
        $this->userService->editFavoriteMovie($request->user(), $request->favorite, $movie->id);
        $user = $this->userService->getUserByName($request->user()->name);
        return $user;
    }

    public function editWatchedMovie(Request $request)
    {
        // 対象映画を映画マスタから取得 or 映画マスタに存在しない場合、requestをもとに映画レコードを作成
        $movie = $this->movieService->getMovieFromDB($request->input('movie'));
        // 視聴済み映画リストを編集
        $this->userService->editWatchedMovie($request->user(), $request->watched, $movie->id);
        $user = $this->userService->getUserByName($request->user()->name);
        return $user;
    }

    public function editMovieRating(Request $request)
    {
        // 対象映画を映画マスタから取得 or 映画マスタに存在しない場合、requestをもとに映画レコードを作成
        $movie = $this->movieService->getMovieFromDB($request->input('movie'));
        // 視聴済み映画リストを編集
        $this->userService->editMovieRating($request->user(), $request->rating, $movie->id);
        $user = $this->userService->getUserByName($request->user()->name);
        return $user;
    }

    public function editAccount(Request $request)
    {
        $allowExt = ['jpeg', 'jpg', 'png'];
        $fileBase64 = $request->input('params')['setUpInfo']['uploadedImage'];
        $url = '';
        if ($fileBase64) {
            $extension = $this->helperService->getExtFromFileBase64($fileBase64);
            if (!array_search($extension, $allowExt)) {
                throw new ExtensionException();
            }
            $decodedFile = $this->helperService->decodeProfileImage($fileBase64);
            $url = $this->helperService->uploadFileToS3($decodedFile, 'profile_image', '', $extension);
            if (!$url) {
                throw new S3Exception();
            }
        }
        $result = $this->userService->editAccount($request->user(), $request->input('params')['setUpInfo']['username'], $url);
        if (!$result) {
            throw new SetUpAccountException();
        }
        return $result;
    }

    // private function getMovieRecord($targetMovie) {
    //     // 映画マスタからidを条件に映画レコードを取得
    //     $movie = $this->movieService->getMovieById($targetMovie['id']);
    //     // 映画マスタに存在しない場合、requestをもとに映画レコードを作成
    //     if(!$movie) {
    //         $movie = $this->editMovieUserRel($targetMovie);
    //     }
    //     return $movie;
    // }
    //
    // private function editMovieUserRel($targetMovie) {
    //     $creditArray = $this->helperService->getCredits($targetMovie, 3);  // クレジット情報を取得
    //     $targetStaff = $this->staffService->create($creditArray);          // クレジット情報をもとにstaffレコード作成
    //     $movie = $this->movieService->create($targetMovie);                // 映画情報をもとにmovieレコード作成
    //     $this->movieService->attachStaffs($movie, $targetStaff);           // movieレコードとstaffレコードを紐づけ
    //
    //     return $movie;
    // }

    private function getMoviesWithAvgRatingByUsername($username)
    {
        $user = $this->userService->getUserByNameWithMovies($username);
        $movieIds = $this->userService->getMovieIdsFromUser($user);
        $movies = $this->movieService->getMoviesWithAvgRatingAndUserInfo($movieIds, $user->id);
        return $movies;
    }
}
