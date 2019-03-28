<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Movie;
use App\Models\Staff;
use App\Services\UserService;
use App\Services\MovieService;
use App\Services\StaffService;
use App\Services\HelperService;
use App\Exceptions\Common\EditAccountException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {

    /**
     * 汎用サービスクラスインスタンス
     */
    protected $helperService;
    /**
     * ユーザーサービスクラスインスタンス
     */
    protected $userService;
    /**
     * 映画サービスクラスインスタンス
     */
    protected $movieService;

    use \App\Json\UserFailJson;

    /**
     * コンストラクタ
     */
    public function __construct(
        UserService $userService,
        MovieService $movieService,
        HelperService $helperService
    ) {
        $this->userService   = $userService;
        $this->movieService  = $movieService;
        $this->helperService = $helperService;
    }

    /**
     * ユーザーネームからユーザー情報を取得
     *
     * @param Request $request
     * @return json
     */
    public function getUserByName(Request $request)
    {
        $user = $this->userService->getUserByName($request->input('username'));
        return response()->json($user);
    }

    /**
     * ユーザーネームからユーザー情報を取得
     *
     * @param Request $request
     * @return json
     */
    // public function getAllAttachedMovies(Request $request)
    // {
    //     $movies = $this->getMoviesWithAvgRatingByUsername($request->input('username'));
    //     return response()->json($movie);
    // }

    /**
     * 映画をお気に入りリストを編集
     *
     * @param Request $request
     * @return json
     */
    public function editFavoriteMovie(Request $request)
    {
        // 対象映画を映画マスタから取得 or 映画マスタに存在しない場合、requestをもとに映画レコードを作成
        $movie = $this->movieService->getMovieFromDB($request->movie);

        // お気に入り映画リストを編集
        $this->userService->editFavoriteMovie(
            $request->user(),
            $request->favorite,
            $movie->id
        );

        // 最新のユーザー情報を取得
        $user = $this->userService->getUserByName($request->user()->name);

        return response()->json($user);
    }

    /**
     * 映画を視聴済みリストを編集
     *
     * @param Request $request
     * @return json
     */
    public function editWatchedMovie(Request $request)
    {
        // 対象映画を映画マスタから取得 or 映画マスタに存在しない場合、requestをもとに映画レコードを作成
        $movie = $this->movieService->getMovieFromDB($request->movie);

        // 視聴済み映画リストを編集
        $this->userService->editWatchedMovie(
            $request->user(),
            $request->watched,
            $movie->id
        );

        // 最新のユーザー情報を取得
        $user = $this->userService->getUserByName($request->user()->name);

        return response()->json($user);
    }

    /**
     * 映画の評価を編集
     *
     * @param Request $request
     * @return json
     */
    public function editMovieRating(Request $request)
    {
        // 対象映画を映画マスタから取得 or 映画マスタに存在しない場合、requestをもとに映画レコードを作成
        $movie = $this->movieService->getMovieFromDB($request->movie);

        // 視聴済み映画リストを編集
        $this->userService->editMovieRating(
            $request->user(),
            $request->rating,
            $movie->id
        );

        // 最新のユーザー情報を取得
        $user = $this->userService->getUserByName($request->user()->name);

        return response()->json($user);
    }

    /**
     * ユーザーのアカウント情報を編集
     *
     * @param Request $request
     * @return json
     */
    public function editAccount(Request $request)
    {
        // ファイルをS3にアップロード
        $fileBase64 = $request->profileImage;
        if ($fileBase64) {
            $decodedFile = $this->helperService->decodeProfileImage($fileBase64);
            $url = $this->helperService->uploadFileToS3($decodedFile, 'profile_image', '');
        }

        // ユーザー情報を更新
        $result = $this->userService->editAccount(
            $request->user(),
            $request->username,
            $url
        );

        // 更新成功の場合は最新のユーザー情報、更新失敗の場合はエラーメッセージを返却
        if ($result) {
            $user = $this->userService->getUserByName($request->user()->name);
            return response()->json($user);
        } else {
            throw new EditAccountException();
        }
    }

    // private function getMoviesWithAvgRatingByUsername($username)
    // {
    //     $user = $this->userService->getUserByNameWithMovies($username);
    //     $movieIds = $this->userService->getMovieIdsFromUser($user);
    //     $movies = $this->movieService->getMoviesWithAvgRatingAndUserInfo(
    //         $movieIds,
    //         $user->id
    //     );
    //     return $movies;
    // }
}
