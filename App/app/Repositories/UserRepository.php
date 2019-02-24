<?php
namespace App\Repositories;
use App\User;
use App\Models\Post;

class UserRepository implements UserRepositoryInterface {

    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * idからuserを取得
     *
     * @param int|$user_id|ユーザーid
     * @return User
     */
    public function getById($user_id) {
        return $this->user->find($user_id);
    }

    /**
     * userを取得
     *
     * @param string|$username|ユーザー名
     * @return Model
     */
    public function getUserByName($username) {
        $user = $this->user->where('name', $username)->first();
        return $user->load('movies');
    }

    /**
     * 映画が紐づいたuserを取得
     *
     * @param string|$username|ユーザー名
     * @return Model
     */
    public function getUserByNameWithMovies($username) {
        $user = $this->user->where('name', $username)->first();
        return $user->load('movies');
    }

    /**
     * お気に入り映画リストを編集
     *
     * @param Model|$user|ユーザー
     * @param bool|$favorite|お気に入り登録情報
     * @param int|$movie_id|映画id
     * @return array|紐づけ結果
     */
    public function editFavoriteMovie($user, $favorite, $movie_id) {
        return $user->movies()->syncWithoutDetaching([
            $movie_id =>
            [
                'favorite'   => $favorite
            ]
        ]);
    }

    /**
     * 視聴済み映画リストを編集
     *
     * @param Model|$user|ユーザー
     * @param bool|$watched|視聴済み登録情報
     * @param int|$movie_id|映画id
     * @return array|紐づけ結果
     */
    public function editWatchedMovie($user, $watched, $movie_id) {
        return $user->movies()->syncWithoutDetaching([
            $movie_id =>
            [
                'watched'   => $watched
            ]
        ]);
    }

    /**
     * 評価を編集
     *
     * @param Model|$user|ユーザー
     * @param bool|$rating|評価
     * @param int|$movie_id|映画id
     * @return array|紐づけ結果
     */
    public function editMovieRating($user, $rating, $movie_id) {
        return $user->movies()->syncWithoutDetaching([
            $movie_id =>
            [
                'watched'   => true,
                'rating'    => $rating
            ]
        ]);
    }

    // /**
    //  * userとmovieの紐づき情報を取得（単数）
    //  *
    //  * @param Model|$user|ユーザー
    //  * @param int|$movie_id|映画id
    //  * @return array|映画（単数）
    //  */
    // public function getAttachedMoviesById($user, $movie_id) {
    //     return $movieList = $user->movies()->where('id', $movie_id)->get();
    // }

    // /**
    //  * userとmovieの紐づき情報を取得（複数）
    //  *
    //  * @param Model|$user|ユーザー
    //  * @return array|映画（複数）
    //  */
    // public function getAllAttachedMovies($user) {
    //     return $movieList = $user->movies()->get();
    // }

    // /**
    //  * userのお気に入り映画リストを取得
    //  *
    //  */
    // public function getFavMovies($user) {
    //     return $movieList = $user->movies()->where('movie_user_rels.favorite', true)->get();
    // }
    //
    // /**
    //  * userの視聴済み映画リストを取得
    //  *
    //  */
    // public function getWatchedMovies($user) {
    //     return $movieList = $user->movies()->where('movie_user_rels.watched', true)->get();
    // }
}
