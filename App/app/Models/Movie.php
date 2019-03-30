<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{

    protected $fillable = ['id', 'title', 'poster_path', 'overview'];

    protected $appends = ['poster_full_path'];

    /**
     * 映画画像のベースURL
     */
    const POSTER_PATH_BASE_URL = 'https://image.tmdb.org/t/p/w500/';

    /**
     * モデルの主キーを自動増分させるか否か
     *
     * @param boolean
     */
    public $incrementing = false;

    /**
     * スタッフテーブルとのリレーション情報
     *
     * @return Staff
     */
    public function staffs()
    {
        return $this->belongsToMany(
            'App\Models\Staff',
            'movie_staff_rels',
            'movie_id',
            'staff_id'
        )->withPivot('is_actor', 'is_crew')->withTimestamps();
    }

    /**
     * ユーザーテーブルとのリレーション情報
     *
     * @return User
     */
    public function users()
    {
        return $this->belongsToMany(
            'App\User','movie_user_rels',
            'movie_id',
            'user_id'
        )->withPivot('watched', 'favorite', 'rating')->withTimestamps();
    }

    /**
     * ポストテーブルとのリレーション情報
     *
     * @return Post
     */
    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    /**
     * 映画の平均評価を計算
     *
     * @return Movie
     */
    public function avgRating()
    {
        return $this->belongsToMany('App\User', 'movie_user_rels', 'movie_id', 'user_id')
            ->withPivot('watched', 'favorite', 'rating')->withTimestamps()
            ->selectRaw('TRUNCATE(AVG(rating), 0) aggregate, movie_id, user_id, name, profile_image')
            ->groupBy('movie_id');
    }

    /**
     * 映画の平均評価を取得
     *
     * @return int
     */
    public function getAvgRatingAttribute()
    {
        if ( ! array_key_exists('avgRating', $this->relations)) $this->load('avgRating');
        $related = $this->getRelation('avgRating')->first();

        return ($related) ? $related->aggregate : 0;
    }

    /**
     * 映画画像URLを取得
     *
     * @return string
     */
    public function getPosterFullPathAttribute()
    {
        return self::POSTER_PATH_BASE_URL . $this->poster_path;
    }
}
