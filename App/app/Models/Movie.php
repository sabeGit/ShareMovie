<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model {

    protected $fillable = ['id', 'title', 'poster_path', 'overview'];

    protected $appends = ['poster_full_path'];

    public function getPosterFullPathAttribute() {
        return config('url.POSTER_PATH_BASE_URL') . $this->poster_path;
    }

    /**
     * モデルの主キーを自動増分させるか否か
     *
     * @var boolean
     */
    public $incrementing = false;

    public function staffs() {
        return $this->belongsToMany('App\Models\Staff', 'movie_staff_rels', 'movie_id', 'staff_id')->withPivot('is_actor', 'is_crew')->withTimestamps();
    }

    public function users() {
        return $this->belongsToMany('App\User', 'movie_user_rels', 'movie_id', 'user_id')->withPivot('watched', 'favorite', 'rating')->withTimestamps();
    }

    public function posts() {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    public function avgRating() {
        return $this->belongsToMany('App\User', 'movie_user_rels', 'movie_id', 'user_id')
            ->withPivot('watched', 'favorite', 'rating')->withTimestamps()
            ->selectRaw('TRUNCATE(AVG(rating), 0) aggregate, movie_id, user_id, name, profile_image')
            ->groupBy('movie_id');
    }

    // accessor for easier fetching the count
    public function getAvgRatingAttribute() {
        if ( ! array_key_exists('avgRating', $this->relations)) $this->load('avgRating');

        $related = $this->getRelation('avgRating')->first();

        return ($related) ? $related->aggregate : 0;
    }
}
