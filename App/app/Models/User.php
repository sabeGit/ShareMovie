<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Post;

class User extends Authenticatable implements JWTSubject
{

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified',
        'email_verify_token',
        'profile_image'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * トークン取得
     *
     * @return string
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * 追加トークン情報
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
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
     * 映画テーブルとのリレーション情報
     *
     * @return Movie
     */
    public function movies()
    {
        return $this->belongsToMany(
            'App\Models\Movie',
            'movie_user_rels',
            'user_id',
            'movie_id'
        )->withPivot('watched', 'favorite', 'rating')->withTimestamps();
    }
}
