<?php
namespace App\Repositories;
use App\User;
use App\Models\Post;

class UserRepository implements UserRepositoryInterface {

    protected $user;

    /**
     * コンストラクタ
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * ユーザーを取得　取得条件：ユーザーネーム
     *
     * @param string $username
     * @return User
     */
    public function getUserByName($username)
    {
        $user = $this->user->where('name', $username)->first();
        return $user->load('movies', 'posts.user', 'posts.movie');
    }

    /**
     * 映画のお気に入り情報を更新
     *
     * @param User    $user
     * @param boolean $favorite
     * @param int     $movie_id
     * @return void
     */
    public function editFavoriteMovie($user, $favorite, $movie_id)
    {
        return $user->movies()->syncWithoutDetaching([
            $movie_id =>
            [
                'favorite'   => $favorite
            ]
        ]);
    }

    /**
     * 映画の視聴済み情報を更新
     *
     * @param User    $user
     * @param boolean $watched
     * @param int     $movie_id
     * @return void
     */
    public function editWatchedMovie($user, $watched, $movie_id)
    {
        return $user->movies()->syncWithoutDetaching([
            $movie_id =>
            [
                'watched'   => $watched
            ]
        ]);
    }

    /**
     * 映画のお気に入り情報を更新
     *
     * @param User $user
     * @param int  $favorite
     * @param int  $movie_id
     * @return void
     */
    public function editMovieRating($user, $rating, $movie_id)
    {
        return $user->movies()->syncWithoutDetaching([
            $movie_id =>
            [
                'watched'   => true,
                'rating'    => $rating
            ]
        ]);
    }

    /**
     * ユーザーのアカウント情報（ユーザーネーム、プロフィール画像）を更新
     *
     * @param User   $user
     * @param string $username
     * @param string $imageUrl
     * @return void
     */
    public function editAccount($user, $username, $imageUrl)
    {
        return $user->update([
            'name' => $username,
            'profile_image' => $imageUrl
        ]);
    }
}
