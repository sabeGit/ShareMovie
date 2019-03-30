<?php

namespace App\Services;

use App\Repositories\MovieRepositoryInterface;

use App\Services\HelperService;
use App\Services\StaffService;

class MovieService
{

    /**
     * 映画レポジトリクラスインスタンス
     */
    protected $movieRepo;
    /**
     * 汎用サービスクラスインスタンス
     */
    protected $helperService;
    /**
     * スタッフサービスクラスインスタンス
     */
    protected $staffService;

    /**
     * コンストラクタ
     */
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
     * @param int $movie_id
     * @return Movie
     */
    public function getMovieById($movie_id)
    {
        return $this->movieRepo->getMovieById($movie_id);
    }

    /**
     * movieを作成
     *
     * @param object $movie
     * @return Movie
     */
    public function create($movie)
    {
        return $this->movieRepo->create($movie);
    }

    /**
     * 映画の平均評価を取得（ユーザー情報付き）（単数）
     *
     * @param int $movie_id
     * @param int $user_id
     * @return Movie
     */
    public function getMovieWithAvgRatingAndUserInfo($movie_id, $user_id)
    {
        return $this->movieRepo->getMovieWithAvgRatingAndUserInfo($movie_id, $user_id);
    }

    /**
     * 映画の平均評価を取得（ユーザー情報付き）（複数）
     *
     * @param array $movieIds
     * @param int   $user_id
     * @return Movie
     */
    public function getMoviesWithAvgRatingAndUserInfo($movieIds, $user_id)
    {
        return $this->movieRepo->getMoviesWithAvgRatingAndUserInfo($movieIds, $user_id);
    }

    /**
     * 映画の平均評価を取得
     *
     * @param array $movieIds
     * @return Movie
     */
    public function getMoviesWithAvgRating($movieIds)
    {
        return $this->movieRepo->getMoviesWithAvgRating($movieIds);
    }

    /**
     * 対象映画を映画マスタから取得 or 映画マスタに存在しない場合、requestをもとに映画レコードを作成
     *
     * @param object $targetMovie
     * @return Movie
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

    /**
     * APIから取得した映画情報をDBに保存
     *
     * @param object $targetMovie
     * @return Movie
     */
    public function createMovieAndStaff($targetMovie)
    {
        // クレジット情報を取得
        $creditArray = $this->helperService->getCredits($targetMovie, 3);
        // クレジット情報をもとにstaffレコード作成
        $targetStaff = $this->staffService->create($creditArray);
        // 映画情報をもとにmovieレコード作成
        $movie = $this->create($targetMovie);
        // movieレコードとstaffレコードを紐づけ
        $this->movieRepo->attachStaffs($movie, $targetStaff);

        return $movie;
    }
}
