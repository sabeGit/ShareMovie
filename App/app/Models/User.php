<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Tymon\JWTAuth\Contracts\JWTSubject;

use App\Post;

//class User extends Authenticatable implements MustVerifyEmailContract {
class User extends Authenticatable implements JWTSubject {
    //use HasApiTokens, MustVerifyEmail, Notifiable;
    // use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'email_verified', 'email_verify_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function movies() {
        return $this->belongsToMany('App\Models\Movie', 'movie_user_rels', 'user_id', 'movie_id')->withPivot('watched', 'favorite', 'rating')->withTimestamps();
    }

    public function avgRating() {
        return $this->belongsToMany('App\Models\Movie', 'movie_user_rels', 'user_id', 'movie_id')
            ->withPivot('watched', 'favorite', 'rating')->withTimestamps()
            ->selectRaw('AVG(rating) avg, movie_id, overview')
            ->groupBy('movie_id');
    }

    public function getMoviesWithAvgRatingAttribute() {
        if ( ! array_key_exists('avgRating', $this->relations)) $this->load('avgRating');

        $related = $this->getRelation('avgRating')->first();

        return ($related) ? $related->aggregate : 0;
    }
}
