<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model {

    protected $fillable = ['id', 'title', 'poster_path', 'overview'];

    protected $appends = ['poster_full_path'];

    public function getPosterFullPathAttribute() {
        return 'https://image.tmdb.org/t/p/w500/' . $this->poster_path;
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

    public function movieWithAvgRating() {
        return $this->belongsToMany('App\User', 'movie_user_rels', 'movie_id', 'user_id')
            ->withPivot('watched', 'favorite', 'rating')->withTimestamps()
            ->selectRaw('AVG(rating) aggregate, movie_id, user_id, name, profile_image')
            ->groupBy('movie_id');
    }

    // public function getMoviesWithAvgRatingAttribute() {
    //     return $this->users->avg('pivot.rating');
    // }

    // accessor for easier fetching the count
    public function getMovieWithAvgRatingAttribute() {
        if ( ! array_key_exists('movieWithAvgRating', $this->relations)) $this->load('movieWithAvgRating');

        $related = $this->getRelation('movieWithAvgRating')->first();

        return ($related) ? $related->aggregate : 0;
    }
}
